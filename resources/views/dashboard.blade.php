@extends('layouts.master')


@section('title')
	Ana sayfa
@stop

@section('content')
	
	@include('includes.category-header')

	@include('includes.search-section')
	<div class="container">
		
		@include('includes.message-block')
		
		<div class="container">
            <div class="row">
            	@include('includes.posts-body')
				
				@if(sizeof($posts)==0)
					<h4>Bir şey bulunamadı :(</h4>
				@endif
				@include('includes.pagination')

			</div>
		</div>
		
	</div>
@stop

