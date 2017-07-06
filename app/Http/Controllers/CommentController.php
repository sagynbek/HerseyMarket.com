<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Post;
use App\User;
use App\Comment;
use App\Notification;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CommentController extends Controller
{	

	public function postComment(Request $request){
		if(!Auth::check()){
			return back()->withWarning('Yorum yapabilmek için giriş yapmalısınız');
		}


		$this->validate($request,[
			'text' => 'required | min:3 | max:501'
		]);

		$comment = new Comment();

		$comment->user_id = $request['user_id'];
		$comment->post_id = $request['post_id'];
		$comment->text = $request['text'];
		
		$comment->save();

		$receiver = Post::where('id',$request['post_id'])->first();

		if(Auth::user()->id != $receiver->user_id){
			$notification = new Notification();
			$notification->sender_id = Auth::user()->id;
			

			$notification->receiver_id = $receiver->user_id;
			$notification->post_id = $request['post_id'];
			$notification->commented = true;
			$notification->seen = false;
			$notification->save();
		}
		return back()->withSuccess('Başarılıyla yorum bıraktınız'); 
	}

	public function getDelete($id)
	{	
		$comment = Comment::where('id',$id)->first();
		
		if($comment=="" || (Auth::user()->id!=$comment->user_id && Auth::user()->admin!=1))
			return back()->withWarning('Sakın oyle birşey yapma');

		$comment->delete();
		return back()->withSuccess('Başarılıyla yorumu sildiniz');
	}

}