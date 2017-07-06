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


class NotificationController extends Controller
{	/*
	public function getNotification(){
		$notifications = Notification::where('user_id',Auth::user()->id)->get();
		$unread=0;

		foreach($notifications as $notify){
			if($notify->seen==0)$unread++;
		}

		return ['notifications'=>$notifications, 'unread'=>$unread];

	}*/
	public function getReadNotifications()
	{
		$notifications = Notification::where('receiver_id',Auth::user()->id)->where('seen',false)->get();

		foreach($notifications as $notification){
			$notification->seen = 1;
			$notification->update();
		}


		return back()->withSuccess('Bütün bilgilendirmeler başarıyla okunmuş hale gelmiştir');
	}

	public function getCleanNotification(){
		$notifications = Notification::where('receiver_id',Auth::user()->id)->where('seen',false)->get();

		foreach($notifications as $notification){
			$notification->seen = 1;
			$notification->update();
		}
		return response(['success'=>1]);
	}
}