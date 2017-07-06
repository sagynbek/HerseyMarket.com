@extends('layouts.master')

@section('title')
	Değiştir
@stop

@section('content')
	<div class="container col-md-6 col-md-offset-1">
		@include('includes.message-block')
		<form action="{{route('edit_post')}}" method="post" enctype="multipart/form-data">
			<h3>Değiştir</h3>
			<div class="form-group">	
				<label>
					Ürün ismi
				</label>
				<input class="form-control" type="text" name="pr_name" value="{{ $post->pr_name }}" required>
			</div>

			<div class="form-group">	
				<label>Açıklama</label> 
				<textarea class="form-control" rows="4" placeholder="Açıklama" name="pr_description" required>{{ $post->pr_description }}</textarea>
			</div>
			<div class="form-group">	
				<label>Değer | Bedava (sayı)</label>
				<input class="form-control" type="integer" name="price" placeholder="Değer" value="{{ $post->price }}" required min="0" max="1000000">
			</div> 

			<div class="form-group">
				<label>Kategori seç</label>
				<select class="form-control" name="select_category" id="category">
					@foreach($categories as $category)
						@if($category->name!="HEPSİ")
							<option @if($category->id==$post->category_id) selected="selected" @endif>{{$category->name}}</option>
						@endif
					@endforeach
				</select>
				<select class="form-control" name="select_category2" id="category2">
					@foreach($l2_categories as $category)
						<option @if($category->id==$post->l2_category_id) selected="selected" @endif>{{$category->name}}</option>
					@endforeach
				</select>
				
				<input type="text" name="custom_category" class="custom_category form-control" style="display:none" placeholder="Kendinin kategorini ekle">
				<h5 class="custom_category text-primary text-right" style="display: none">*Yeni kategoriniz, adminin onayına gönederilir</h5>

			</div>
			<div class="form-group">	
				<label>Malın bulunduğu yer</label> 
				<select class="form-control" id="select-city" name="select_city">
	                <option>Şehir seç</option>
	                @foreach($cities as $city)
	                    <option @if($post->city->id==$city->id) selected="selected"  @endif>{{$city->name}}</option>
	                @endforeach
	            </select>
	            <select  class="form-control" id="select-province" name="select_province">
	                @foreach($provinces as $province)
	                    <option  @if($post->province->id==$province->id) selected="selected"  @endif >{{$province->name}}</option>
	                @endforeach
	            </select>
			</div>
            <div id="loader" style="display: none">
                <img style="width: 30px;" src= "{{asset('img/loader.gif')}}" >
            </div>


			<div class="form-group">
                <hr>
				<label class="form-control-label">Fotoğraflar</label>
				@for($i=1;$i<4;$i++)
					<div class="form-group row">
						<input type="file" name="image{{$i}}" class="col-sm-4">
	                    @if (Storage::has('/public/img/'.$post->id . '_'.$i.'_post.jpg'))
	                        <div class="col-sm-4 @if($i==1) active @endif" id="{{"sl_".$i}}">
	                            <img style="height: 50px" src="{{ route('account.image', ['filename' => $post->id . '_'.$i.'_post_thumb.jpg']) }}" alt="{{$post->pr_name}}" class=" thumbnail">
	                        </div>
	                    @endif
                    </div>
                @endfor
			</div>
			
			<div class="form-group">
				<h6><em>*Sadece JPG formatlı maksimum 2 MB boyutlu dosya yükleyebilirsiniz</em></h6>
			</div>

			<input type="hidden" name="id" value="{{ $post->id }}">
			<input type="hidden" name="_token" value="{{ Session::token() }}">
			<button class="btn btn-primary">Onayla</button>
		</form>
		
	</div>
	<script>
        var token = "{{ Session::token() }}";
    </script>
@stop