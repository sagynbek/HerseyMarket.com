<?php
namespace App\Http\Controllers;
/**
* 
*/

use App\Message;
use App\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{	

	public function getMessageMenu(){

		$conversations = Message::where([
				['to_user_id',Auth::user()->id]
			])->orWhere([
				['user_id',Auth::user()->id]
			])->orderBy('created_at','asc')->get();
		
		$users = array();

	    $cnt_mes=0;
	    $i=0;
	    $ar = array();
	    
	    
	    foreach($conversations as  $conv){
	        if($conv->user_id!=Auth::user()->id)
	        	$cur=$conv->user_id;
	       	if($conv->to_user_id!=Auth::user()->id)
	        	$cur=$conv->to_user_id;
	       	
	        if(!array_key_exists($cur, $ar)){
	        	$ar[$cur] = User::where('id',$cur)->first()->name; 
	        }
	    } 
	    
		return view( 'message-menu',['users'=>$ar] );
	}

	public function postMessage(Request $request)
	{
		if(!Auth::check())
			return back()->withWarning("Giriş yapmalısınız");
		
		$this->validate($request,[
			'message' => 'required|min:3|max:500'
		]);
		$message = new Message();

		$message->user_id = Auth::user()->id;
		$message->to_user_id = $request['to_user_id'];
		$message->message = $request['message'];
		$message->seen = false;
		$message->delivered = false;
		
		$message->save();

		return back()->withSuccess('Mesajınız başarıyla iletildi');
	}
	public function postMessageAjax(request $request)
	{
		if(!Auth::check())
			return back()->withWarning("Giriş yapmalısınız");

		$this->validate($request,[
			'message'=>'required|min:3|max:500'
		]);

		$message = new Message();
		$message->user_id = Auth::user()->id;
		$message->to_user_id = $request['to_user_id'];
		$message->message = $request['message'];
		$message->seen = false;
		$message->delivered = false;
			
		$message->save();

		return response(['success'=>'1']);
	}
	// Get message on load "message page"
	public function getMessage($id)
	{
		$messages = Message::where([
				['user_id',$id],
				['to_user_id',Auth::user()->id]
			])->orWhere([
				['user_id',Auth::user()->id],
				['to_user_id',$id]
			])->orderBy('created_at','asc')->get();
		
		foreach ($messages as $message) {
			if($message->to_user_id == Auth::user()->id){
				$message->seen = 1;
				$message->update();
			}
		}
		$user = User::where('id',$id)->first();
		if($user==null)
			return redirect()->route('home')->withWarning('Öyle kişi bulunmadı');

		return view( 'message',['messages'=>$messages, 'user'=>$user] );
	}
	//Get new message AJAX, on "Message page"
	public function getNewMessage(Request $request)
	{
		$messages = Message::where('user_id',$request['user'])
							->where('to_user_id',Auth::user()->id)
							->where('seen',false)
							->get();
		
		foreach ($messages as $message) {
			$message->seen=1;
			$message->update();
		}
		return response()->json($messages);
	}

	//Get new Message in any page, except "Message page"
	public function getNewNotificationMessage(Request $request)
	{
		$messages = Message::where('to_user_id',Auth::user()->id)
							->where('seen',false)
							->where('delivered',false)
							->get();


		$i=0;
		$new=array();
		foreach($messages as $message){

			$message->delivered=1;
			$name=User::where('id',$message->user_id)->first();
			$ar=array('user_id' => $message->user_id,'user_name'=>$name->name);
			$new[$i] = $ar;

			//return response()->json($new[0]['user_id']);

			$message->update();
			$i++;
		}


		return response()->json($new);
	}

	// Real message for feedback

	public function postRealMessage(Request $request){
		$this->validate($request,[
			'message' => 'required|min:5|max:1000',
			'email' => 'required'
		]);
		//return $request['email'] . "<br>". $request['name'];
		$mytitle= $request['title'];
        Mail::send('emails.send-mail', [
        	'myheader' => $request['title'], 
        	'mymessage' => $request['message'],
        	'myname' => $request['name']
        	], function ($message){
        		$message->from("sender@gmail.com", "Sagynbek Kenzhebaev");
				$message->to('kenzhebaev9797@gmail.com')->subject('Feedback');
		});
		return redirect()->route('home')->withSuccess('Teşekkürler, mesajınız başarıyla gönderilmiştir');
	}
}