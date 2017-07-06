@extends('layouts.master')

@section('title')
    Sohbetlerim
@stop

@section('content')
	<div class="container">
        @include('includes.message-block')
        <div class="row text-center" style="margin-bottom: 1.2em">
        	<h3>Sohbetlerim</h3>
        	<h4>Toplam - {{sizeof($users)}} sohbet</h4>
        </div>
        <div class="table-responsive">          
		  <table class="table table-hover">
		    <thead>
		      <tr>
		        <th>Fotoğraf</th>
		        <th>Sohbet</th>
		        <th>Bilgi</th>
		      </tr>
		    </thead>
		    <tbody>
				@foreach($users as $i=>$name)
				<tr>
					<td>
						@if(Storage::has('/public/img/'.$i . '.jpg'))
							<img src="{{ route('account.image', ['filename' => $i . '_thumb.jpg']) }}" alt="{{$name}}" >
						@else
							<img src="{{ route('account.image', ['filename' => 'nopicture_thumb.jpg']) }}" alt="{{$name}}" >
						@endif
					</td>

					<td>
						<a href="{{url('/message/'.$i)}}">{{$name}}</a>
					</td>
					<td>
						<a href="{{url('/users/'.$i)}}">Profil</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>
	</div>
@stop