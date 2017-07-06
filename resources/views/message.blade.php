@extends('layouts.master')

@section('title')
	Mesaj
@stop

@section('content')
	<div class="container">
		@include('includes.message-block')
		<div class="chat">
			<div class="container message-box-header text-center">
				<h3 style="position: relative; margin:0px">
					@if(Storage::has('/public/img/'.$user->id . '.jpg'))
						<img src="{{ route('account.image', ['filename' => $user->id . '_thumb.jpg']) }}" alt="{{$user->name}}" >
					@else
						<img src="{{ route('account.image', ['filename' => 'nopicture_thumb.jpg']) }}" alt="{{$user->name}}" >
					@endif
				<a href="{{ url('users/'.$user->id) }}">{{$user->name}}</a></h3>
			</div>
			
			<div class="container get-rid-padding" >
				@php
					$pr=0;
				@endphp
				<div class="message-box" id="chat-part">
					@foreach($messages as $message)
						@php $align="message-left" @endphp
						@if($message->user->id == Auth::user()->id)
							@php $align="message-right" @endphp
						@endif

						<blockquote class="blockquote @if($message->user->id == Auth::user()->id) blockquote-reverse	@endif ">
						 	<p>{{$message->message}}</p>
						 	<h6>{{$message->created_at->diffForHumans()}}</h6>
						</blockquote>

						{{$ch=$message->sender_id}}
						@php
							$pr=$message->user->id;
						@endphp
					@endforeach
				</div>
				<div class="message-field">
					<form class="send-message-box" action="{{ route('send_message') }}" method="post">
						
						<textarea name="message" class="send-message-textarea" id="message-area" placeholder="Mesajinizi yazin..."></textarea>
						
						<input type="hidden" name="to_user_id" id="to_user" value="{{ $user->id }}">
						<input type="hidden" name="_token" id ="token_id" value="{{ Session::token() }}">
						<em class="show-characters"></em>
						<button type="submit" name="submit" id="sub-mes" class="btn btn-primary send-message-btn">
							<span class="glyphicon glyphicon-send"></span> Gönder
						</button>
					</form>
				</div>
			</div>
		</div>

	</div>
@stop