<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Post;
use App\User;
use App\Category;
use App\L2_Category;
use App\Province;
use App\City;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProvinceController extends Controller
{	
	public function getProvinceAjax(Request $request){
		//return response()->json(['name'=>'Osh']);
		$city = City::where('name',$request['city'])->first();
		if(!empty($city)){
			$provinces = Province::where('city_id',$city->id)->get();
			return response()->json($provinces);
		}
	}
}