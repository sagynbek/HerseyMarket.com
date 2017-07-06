@extends('layouts.master')

@section('title')
	Paylaşım
@stop

@section('content')
	<div class="container col-md-6 col-md-offset-1">
		@include('includes.message-block')
		<form action="{{ route('make_post') }}" method="POST" enctype="multipart/form-data">
			<h3>Paylaş</h3>
			<div class="form-group">
				<label>
					Ürün ismi
				</label>
				<input  class="form-control" type="text" name="pr_name" value="{{ Request::old('pr_name')}}" minlength="2">
			</div>
			<div class="form-group">
				<label>Anlatım</label>
				<textarea  class="form-control" rows="4" placeholder="Anlatım" name="pr_description" minlength="5">{{ Request::old('pr_description') }}</textarea>
			</div>
			<div class="form-group">
				<label>Değer | Bedava (sayı giriniz sadece)</label>
				<input type="integer" class="form-control" name="price" placeholder="Değer" min="0" max="1000000">
			</div>
			<div class="form-group">
				<label>Kategori</label>
				<select class="form-control" name="select_category" id="category">		
					<option>Kategori seç</option>
					@foreach($categories as $category)
						@if($category->name!="HEPSİ")
							<option >{{$category->name}}</option>
						@endif
					@endforeach
				</select>
				<select class="form-control" name="select_category2" id="category2" style="display:none">
				</select>
				

				<input type="text" name="custom_category" class="custom_category form-control" style="display:none" placeholder="Kendinin kategorini ekle">
				<h5 class="custom_category text-primary text-right" style="display: none">*YoYeni kategoriniz, adminin onayına gönederilir</h5>

			</div>
			<div class="form-group">
				<label>Malın bulunduğu yer</label>
				<select class="form-control" id="select-city" name="select_city">
	                <option>Şehir seç</option>
	                @foreach($cities as $city)
	                    <option @if(Auth::user()->city->id==$city->id) selected="selected"  @endif>{{$city->name}}</option>
	                @endforeach
	            </select>
	            <select class="form-control" id="select-province" name="select_province">
	                @foreach($provinces as $province)
	                    <option  @if(Auth::user()->province->id==$province->id) selected="selected"  @endif >{{$province->name}}</option>
	                @endforeach
	            </select>
			</div>
            <div id="loader" style="display: none">
                <img style="width: 30px;" src= "{{asset('img/loader.gif')}}" >
            </div>
            <div class="form-group">
            	<label>Fotoğraflar (ikinci ve üçüncüsü seçmeli)</label>
			    <input class="form-control" type="file" name="image1" required > 
				<input class="form-control" type="file" name="image2" >
				<input class="form-control" type="file" name="image3" >
			</div>
			<div class="form-group">
				<h6><em>*Sadece JPG formatlı maksimum 2 MB boyutlu dosya yükleyebilirsiniz</em></h6>
			</div>
			<input type="hidden" name="_token" value="{{ Session::token() }}">
			<button class="btn btn-primary" id="sub-post"><img style="width:22px;display:none" src="{{asset('img/loader.gif')}}"> Gönder</button>
			
		</form>
	</div>
	<script>
        var token = "{{ Session::token() }}";
    </script>
@stop

