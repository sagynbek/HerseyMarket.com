<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Post;
use App\User;
use App\Like;
use App\Notification;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{	
	public function postLike(Request $request){
		if(!Auth::check())
			return back()->withWarning("Beğenmek için giriş yapınız");
		$post=Post::where('id',$request['post_id'])->first();

		if($post->user_id==Auth::user()->id)return redirect()->back();

		$this->validate($request,[
			'like' => 'required|integer|min:0|max:6'
		]);

		$like = new Like();
		$like->user_id = Auth::user()->id;
		$like->post_id = $request['post_id'];
		$like->like =  $request['like'];

		$like->save();

		if($request['like']<6){
			$post->vote_sum+=$request['like'];
			$post->vote_num++;
		}
		else
			$post->report++;

		$post->update();


		$notification = new Notification();
		$notification->sender_id = Auth::user()->id;
		
		$receiver = Post::where('id',$request['post_id'])->first();

		$notification->receiver_id = $receiver->user_id;
		$notification->post_id = $request['post_id'];
		$notification->liked = $request['like'];
		$notification->seen = false;
		$notification->save();


		
		if($request['like']<6){

			return back()->withSuccess('Başarılıyla oyladınız');
		}
		if($request['like']==6)
			return back()->withSuccess('Raporunuz iletildi, teşekkürler');


			
	}
	public function postCancelLike(Request $request)
	{	
		$post=Post::where('id',$request['post_id'])->first();

		if($post->user_id==Auth::user()->id)return redirect()->back();

		$like = Like::where('user_id',Auth::user()->id)->where('post_id',$request['post_id'])->first();

		if(!empty($like)){
			if($like->like<6){
				$post->vote_sum-=$like->like;
				$post->vote_num--;
			}
			else $post->report--;
			$post->update();
			$like->delete();


			return back()->withSuccess('Raporu başarılıyla sildiniz');
		}

	}
}