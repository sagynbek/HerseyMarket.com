@extends('layouts.master')


@section('title')
	New Categories
@stop

@section('content')
 
	<div class="container">
		@include('includes.category-header')
		@include('includes.message-block')
		
		<div class="container">
            <div class="row">
            	@if(sizeof($offer_categories))
            		<div class="table-responsive col-xs-12">          
					  <table class="table table-hover">
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>User</th>
					        <th>Post</th>
					        <th>Category</th>
					        <th>Custom sub-category</th>
					        <th>Accept</th>
					        <th>Delete</th>
					      </tr>
					    </thead>
					    <tbody>
							@foreach($offer_categories as $i=>$category)
		                      <tr>
		                      	<td>{{$i+1}}</td>
		                        <td><a href="{{url('users/'.$category->post->user->id)}}">{{$category->post->user->name}}</a></td>
		                        <td><a href="{{url('product/'.$category->post_id)}}">{{$category->post->pr_name}}</a></td>
		                        <td>{{$category->category->name}}</td>
		                        <td>{{$category->custom_category}}</td>
		                        <td><a href="{{url('sub-accept/'.$category->id)}}">Accept</a></td>
		                        <td><a href="{{url('sub-delete/'.$category->id)}}">Decline</a></td>
		                      </tr> 
							@endforeach
					    </tbody>
					  </table>
					</div>
				@else
					<h4>Bir şey yok</h4>
				@endif
				
				<div class="col-md-12 text-center">
				    {{ $offer_categories->links() }}
				</div>

			</div>
		</div>
		
	</div>
@stop

