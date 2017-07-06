<?php
namespace App\Http\Controllers;
/**
* 
*/
use App\User;
use App\Post;
use App\City;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Input; 

class UserController extends Controller{

	use Notifiable;

	public function getSignUp(){
		$cities = City::orderBy('id','asc')->get();
		return view('signup',['cities'=>$cities]);
	}

	public function postSignUp(Request $request){
		$mobile = str_replace(" ", "", $request['mobile']);

		if(strlen($mobile)>0 && strlen($mobile)<10)
			return redirect('signup')->withWarning('Mobil telefonunuz yanlış girilmiştir, 11 haneli olmalı')->withInput();

		$this->validate($request,[
		 	'email'=> 'required|email|unique:users',
		 	'name' => 'required|min:3|max:50',
		 	'password' => 'required|min:5|max:50'
		]);


		$city = City::where('name',$request['select_city'])->first();
		$province = Province::where('name',$request['select_province'])->first();
		if(!$province){
			$province = new Province();
			$province->id = null;
		}


		if($city==null)
			return redirect('signup')->withWarning('Oturduğunuz yeri seçiniz')->withInput();

		$email = $request['email'];
		$name = $request['name'];
		$password = bcrypt($request['password']);

		$user = new User();

		$user->name = $name;
		$user->email = $email;
		$user->password = $password;
		$user->city_id = $city->id;
		$user->province_id = $province->id;
		$user->mobile = $mobile;
		$user->admin=0;

		$user->save();
		Auth::login($user);
		// Image 
		if($request['image']!="" && $request['image']!=null){
			$extention= $request->file('image')->getClientOriginalExtension();
			if($extention!="jpg" && $extention!="JPG" )
				return redirect('home')->withWarning('Profilinizin fotoğrafı JPEG formatlı dosya olmalı')->withInput();

			

			$file = $request->file('image');
			$filename=$user->id.'.jpg';
			$filename_thumb=$user->id.'_thumb.jpg';
			
			if ($file){
	            Image::make(Input::file('image'))->fit(262, 200)->save(storage_path()."/app/public/img/".$filename);
				
				Image::make(Input::file('image'))->fit(55, 50)->save(storage_path()."/app/public/img/".$filename_thumb);
			}
   		}
   		
		return redirect()->route("dashboard")->withSuccess('Tebrikler, başarıyla üyelik oluşturmuşsunuz');
	}

	public function postSignIn(Request $request){
		Auth::logout();
		$this->validate($request,[
			'email' => 'required',
			'password' => 'required'
		]);

		if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']],$request['remember'])){

			return redirect()->route('dashboard');
		}
		else
			return redirect()->back()->withWarning('Şifreniz yada email adresiniz yanlıştır');

	}

	public function getSignOut(){
		Auth::logout();
		return redirect()->route('home');	
	}

	public function getUserId($id){
		$user = User::findOrFail($id);
		$posts = Post::where('user_id',$id)->orderBy('created_at','desc')->paginate(12);
		
		return view('user', ['user' => $user, 'posts'=>$posts] );
	}

	public function getEditProfile(){
		$cities = City::get();
		$provinces = Province::where('city_id',Auth::user()->city->id)->get();
		return view('editprofile',['cities'=>$cities,'provinces'=>$provinces]);
	}

	public function postEditProfile(Request $request){
		if(!Auth::user())
			return redirect()->back()->withWarning('Yapmayın lütfen');

		$mobile = str_replace(" ", "", $request['mobile']);

		if(strlen($mobile)>0 && strlen($mobile)<10)
			return redirect('signup')->withWarning('Mobil telefonunuz yanlış girilmiştir, 11 haneli olmalı')->withInput();


		if($request['new_password']!=""){
			$this->validate($request,[
			 	'name' => 'required|min:3|max:50',
			 	'new_password' => 'required|min:5|max:50'
			]);
		}
		else{
			$this->validate($request,[
			 	'name' => 'required|min:3|max:50'
			]);	
		}
		
		$user = Auth::user();
		
		$user->name=$request['name'];
		if($request['new_password']!="")
			$user->password=bcrypt($request['new_password']);

		$city = City::where('name',$request['select_city'])->first();
		$province = Province::where('name',$request['select_province'])->first();
		$user->city_id = $city->id;
		$user->province_id = $province->id;
		$user->mobile = $mobile;


		$user->update();

		if($request['image']!=""){
			$this->validate($request,[
				'image' => 'image|max:2024'
			]);

			$extention= $request->file('image')->getClientOriginalExtension();

			if($extention!="jpg" && $extention!="JPG")
				return redirect()->route('dashboard')->withWarning('Sadece jpg dosya yükleyin lütfen');

			$file = $request->file('image');
			$filename=$user->id.'.jpg';
			$filename_thumb=$user->id.'_thumb.jpg';
			
			if ($file){
	            Image::make(Input::file('image'))->fit(262, 200)->save(storage_path()."/app/public/img/".$filename);
				
				Image::make(Input::file('image'))->fit(55, 50)->save(storage_path()."/app/public/img/".$filename_thumb);
			}
   		}

		return redirect()->route('dashboard')->withSuccess('Başarıyla işleminizi tamamlamışsınızdır');
	}

	public function getUserImage($filename)
    {
        $file = Storage::get('/public/img/'.$filename);
        return new Response($file, 200);
    }

    public function getAdministrating($id){
    	if(Auth::user()->admin==0)return redirect()->route('dashboard');

    	$user = User::where('id',$id)->first();
    	//0 is main admin whose prevelegy can't be changed
    	if(!empty($user) && $user->id!=0){
    		if($user->admin==0)$user->admin=1;
    		else $user->admin=0;
    		$user->update();
    		return back()->withSuccess('Başarıyla birisinin yetkisin değiştirmişsiniz');
    	}
    }

    public function getAllUsers(){
    	if(Auth::check() && Auth::user()->admin==1){
    		$users = User::paginate(30);
    		return view('admin.all-users',['users'=>$users]);
    	}
    	return redirect()->route('dashboard');

    }
}
