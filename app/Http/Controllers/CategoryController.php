<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Post;
use App\User;
use App\Category;
use App\L2_Category;
use App\Offer_Category;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{	
	public function getCategory(Request $request)
	{	
		$categ = Category::where('name', $request['category'])->first();

		if(count($categ)){
			$categories = L2_Category::where('category_id',$categ->id)->get();
			/*$array = array();

			foreach($categories as $category){
				array_push( $array, array('name',$category->name) );
			}*/
			if(!empty($categories))
				return response()->json($categories);
		}
		return 0;
	}

	public function getNewCategories()
	{	
		if(Auth::user()->admin==1){
			$categories = Category::orderBy('id','asc')->get();
			$sub_categories = L2_Category::orderBy('category_id','asc')->get();
		
			$offer_categories = Offer_Category::paginate(40);
			return view('custom-categories',['offer_categories'=>$offer_categories,'categories'=>$categories,'sub_categories'=>$sub_categories]);
		}
		return abort(401,'Unauthorized action.');
	}

	public function getSubAccept($id)
	{
		if(Auth::user()->admin!=1)
			return route("dashboard");

		$offer = Offer_Category::where('id',$id)->first();
		if(count($offer)){
			$category = new L2_Category;
			$category->category_id = $offer->category_id;
			$category->name = strtoupper($offer->custom_category);
			$category->save();
			$offer->delete();
			return redirect()->route('custom_categories');
		}
	}
	public function getSubDelete($id)
	{
		if(Auth::user()->admin!=1)
			return route("dashboard");
		
		$offer = Offer_Category::where('id',$id)->first();
		if(count($offer)){
			$offer->delete();
			return redirect()->route('custom_categories');
		}
	}
}