<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Post;
use App\User;
use App\Comment;
use App\Like;
use App\Notification;
use App\Category;
use App\City;
use App\Offer_Category;
use App\Province;
use App\L2_Category;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Input;
use App\Notifications\PostLiked;



class PostController extends Controller
{	
	public function getMainPage(){
		$categories = Category::orderBy('id','asc')->get();
		$posts = Post::orderBy('id','asc')->paginate(7);
		if(!Auth::check())
			return view('welcome',['categories'=>$categories,'posts'=>$posts]);
		else
			return redirect()->route('dashboard');
	}

	public function getDashboard(){
		/*if(!Auth::check())
			return redirect()->route('home');
		*/
		$posts = Post::orderBy('created_at','desc')->paginate(12);
		$categories = Category::orderBy('id','asc')->get();
		$cities = City::get();
		if(Auth::check())
			$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		else{
			$provinces = null;
		}
		$sub_categories = L2_Category::orderBy('category_id','asc')->get();
		
		return view('dashboard',['posts'=>$posts,'categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces,'sub_categories'=>$sub_categories]);
	}

	public function getTest(){
		
		$categories = Category::orderBy('id','asc')->get();

		$sub_categories = L2_Category::orderBy('category_id','asc')->get();

		return view('test',['categories'=>$categories,'sub_categories'=>$sub_categories]);
	}

	public function getCreatePost(){
		$categories = Category::orderBy('id','asc')->get();
		$cities = City::get();
		$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		return view('post',['categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces]);
	}

	public function postCreatePost(Request $request){
		//Validation
		$this->validate($request,[
			'pr_name'=>'required|min:2|max:50',
			'pr_description' => 'required|min:5',
			'price' => 'required|integer|min:0|max:1000000'
		]);


		$post = new Post();
		//$post->file_dir = $request['file_dir'];
		//$post->user_id = 
		$post->pr_name = title_case($request['pr_name']);
		$post->pr_description = $request['pr_description'];
		$post->price = $request['price'];
		$city = City::where('name',$request['select_city'])->first();
		$province = Province::where('name',$request['select_province'])->first();
		$post->city_id = $city->id;
		$post->province_id = $province->id;

		$post->category_id = Category::where('name',$request['select_category'])->first()->id;
		if($request['select_category2']!="")
			$post->l2_category_id = L2_Category::where('name',$request['select_category2'])->first()->id;

		$request->user()->posts()->save($post);

		for ($i=1; $i <4; $i++) { 
			$file = $request->file('image'.$i);
			if($file){
				$ch_img='image'.$i;
				$this->validate($request,[
					$ch_img => 'required|image|between:1,10048'
				]);
				$extention= $request->file('image'.$i)->getClientOriginalExtension();
				if($extention!="jpg" && $extention!="JPG"){
					$post->delete();
					return redirect()->back()->withWarning('Sadece jpg yükleyin lütfen');
				}
				$filename=$post->id.'_'.$i.'_post.jpg';
				$filename_thumb=$post->id.'_'.$i.'_post_thumb.jpg';

				Image::make(Input::file('image'.$i))->fit(262, 200)->save(storage_path()."/app/public/img/".$filename);
				Image::make(Input::file('image'.$i))->fit(55, 50)->save(storage_path()."/app/public/img/".$filename_thumb);
			}
		}

		if($request['custom_category']!=""){
			//Save to custom_category
			$offer = new Offer_Category;
			$offer->category_id = Category::where('name',$request['select_category'])->first()->id;
			$offer->post_id = $post->id;
			$offer->custom_category = $request['custom_category'];
			$offer->save();
		}

		return redirect()->route('dashboard')->withSuccess('Başarıyla işleminizi tamamlamışsınızdır');
	}

	public function getEditPost($id){
		$post = Post::findOrFail($id);
		if(count($post)){
			if(Auth::user()->id == $post->user_id || Auth::user()->admin==1){	
				$categories = Category::orderBy('name','asc')->get();
				$l2_categories = L2_Category::where('category_id',$post->category_id)->orderBy('name','asc')->get();
				$cities = City::get();
				$provinces = Province::where('city_id',$post->city->id)->get();
			
				return view('editpost',['post'=>$post,'categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces,'l2_categories'=>$l2_categories]);
			}
			else 
				return redirect()->route('dashboard')->withWarning('Yapmayın lütfen');
		}
		else return redirect()->route('dashboard')->withWarning('Yapmayın lütfen');
	}

	public function postEditPost(Request $request){
		$this->validate($request,[
			'pr_name'=>'required|min:2|max:50',
			'pr_description' => 'required|min:5',
			'price' => 'required|integer|min:0|max:1000000',
			'id' => 'required|integer'
		]);

		$post = Post::where('id',$request['id'])->first();

		$post->pr_name = title_case($request['pr_name']);
		$post->pr_description = $request['pr_description'];
		$post->price = $request['price'];
		$post->category_id = Category::where('name',$request['select_category'])->first()->id;

		if($request['select_category2']!="")
			$post->l2_category_id = L2_Category::where('name',$request['select_category2'])->first()->id;

		if($request['custom_category']!=""){
			//Save to custom_category
			$offer = Offer_Category::where('post_id',$post->id)->first();
			if(count($offer))$update=1;
			else
				$offer = new Offer_Category;
			$offer->category_id = Category::where('name',$request['select_category'])->first()->id;
			$offer->post_id = $post->id;
			$offer->custom_category = $request['custom_category'];
			if($update)$offer->update();
			else
				$offer->save();
		}

		$city = City::where('name',$request['select_city'])->first();
		$province = Province::where('name',$request['select_province'])->first();
		$post->city_id = $city->id;
		$post->province_id = $province->id;

		for ($i=1; $i <4; $i++) { 
			$file = $request->file('image'.$i);
			if($file){
				$ch_img='image'.$i;
				$this->validate($request,[
					$ch_img => 'required|image|between:1,10048'
				]);
				$extention= $request->file('image'.$i)->getClientOriginalExtension();
				if($extention!="jpg" && $extention!="JPG"){
					return redirect()->back()->withWarning('Sadece jpg dosya yükleyin');
				}
				$filename=$post->id.'_'.$i.'_post.jpg';
				$filename_thumb=$post->id.'_'.$i.'_post_thumb.jpg';

				Image::make(Input::file('image'.$i))->fit(262, 200)->save(storage_path()."/app/public/img/".$filename);
				Image::make(Input::file('image'.$i))->fit(55, 50)->save(storage_path()."/app/public/img/".$filename_thumb);
			}
		}

		$post->update();

		return redirect()->route('dashboard')->withSuccess('Başarıyla işleminizi tamamlamışsınızdır');
	}

	public function getDeletePost($id){
		$post = Post::findOrFail($id);


		if(!empty($post) && (Auth::user()->id == $post->user_id || Auth::user()->admin==1) ){
			//Deleting all photos
			$dir='/public/img/';
			for ($i=1; $i <4; $i++) { 
				$filename=$post->id.'_'.$i.'_post.jpg';
				$filename_thumb=$post->id.'_'.$i.'_post_thumb.jpg';

				if(Storage::has($dir.$filename)){
					Storage::delete([$dir.$filename]);
				}
				if(Storage::has($dir.$filename_thumb)){
					Storage::delete([$dir.$filename_thumb]);
				}
			}

			Like::where('post_id',$post->id)->delete();
			Notification::where('post_id',$post->id)->delete();
			Comment::where('post_id',$post->id)->delete();

			$post->delete();

			return redirect()->route('dashboard')->withSuccess('Başarıyla silinmiştir');
		}
		else
			return redirect()->route('dashboard')->withWarning('Yapmayın lütfen');

	}

	public function getPostInfo($id){
		
		$post = Post::findOrFail($id);

		if(count($post)==0 || $post==null)
			return redirect()->route('dashboard')->withWarning('Böyle bir şey bılınmamıştır');
		
		$likes = Like::where('post_id',$post->id)->get();

		$category = Category::where('id',$post->category_id)->first();

		
		$num=0.0;
		$sum=0.0;
		$report=0;
		foreach ($likes as $like) {
			if($like->like<6){
				$sum+=$like->like;
				$num++;
			}
			else{
				$report++;
			}
		}
		if(Auth::user())
			$like = $likes->where( 'user_id',Auth::user()->id )->first();
		else
			$like = null;
		$comments = Comment::where('post_id',$id)->orderBy('created_at','desc')->get();
		if($num>0)
			$av=$sum/$num;
		else $av=0;

		return view('product-page', ['post' => $post, 'comments'=> $comments, 'average'=>$av, 'like'=>$like, 'report'=>$report, 'number'=>$num, 'category'=>$category->name ]);

	}
 
	public function getSearchingPost(Request $request)
	{	
		$posts = Post::orderBy('id','desc');

		if($request['bedava']){
			$posts = $posts->where('price',0);
		}

		if($request['description']!=""){
			$posts = $posts->where('pr_name','like','%'.$request['description'].'%')
						->orWhere('pr_description','like','%'.$request['description'].'%');
		}
		//return $posts->get();
		if($request['select_category']!="HEPSİ"){
			$cat=Category::where('name',$request['select_category'])->first();
			$posts = $posts->where('category_id',$cat->id);
		}
		/*if($request['select_category2']!="" && $request['select_category2']!=null){
			$cat2=L2_Category::where('name',$request['select_category'])->first();
			$posts = $posts->where('category_id',$cat->id);
		}*/
		if($request['select_city']!="Bütün şehirler"){
			$city = City::where('name',$request['select_city'])->first();
			//return $city->id;
			$posts = $posts->where('city_id',$city->id);
		}
		//return $posts->get();
		if($request['select_province']!="HEPSİ" && $request['select_province']!=null){
			$province=Province::where('name',$request['select_province'])->first();
			$posts = $posts->where('province_id',$province->id);
		}

		$categories = Category::orderBy('id','asc')->get();
		$cities = City::get();
		if(Auth::user())
			$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		else
			$provinces = null;

		$sub_categories = L2_Category::orderBy('category_id','asc')->get();
		
		return view('dashboard',['posts'=>$posts->paginate(12),'categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces,'sub_categories'=>$sub_categories]);
	}
	public function getSearchCategory($id){
		$posts = Post::where('category_id',$id)->orderBy('id','desc');

		$categories = Category::orderBy('id','asc')->get();
		$cities = City::get();
		if(Auth::user())
			$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		else
			$provinces = null;
		$sub_categories = L2_Category::orderBy('category_id','asc')->get();
		
		return view('dashboard',['posts'=>$posts->paginate(12),'categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces,'sub_categories'=>$sub_categories]);
	}
	public function getSearchCategorySub($id1,$id2){
		$posts = Post::where([ ['category_id',$id1], ['l2_category_id',$id2] ])->orderBy('id','desc');

		$categories = Category::orderBy('id','asc')->get();
		$cities = City::get();
		if(Auth::user())
			$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		else
			$provinces = null;
		$sub_categories = L2_Category::orderBy('category_id','asc')->get();
		
		return view('dashboard',['posts'=>$posts->paginate(12),'categories'=>$categories,'cities'=>$cities,'provinces'=>$provinces,'sub_categories'=>$sub_categories]);
	}

	public function getSold($id){
		$post = Post::findOrFail($id);

		if(empty($post) || $post==null)
			return redirect()->route('dashboard');

		if($post->sold==1)$post->sold=0;
		else $post->sold=1;

		$post->update();
		return redirect()->back();
		
	}
}