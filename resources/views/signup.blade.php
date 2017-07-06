@extends('layouts.master')


@section('title')
    Kayıt ol
@stop

@section('content')
    @include('includes.message-block')
    <div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Kayıt ol</div>
                <div class="panel-body">

                    <form class="form-horizontal" action="{{ route('signup') }}" method="post" enctype="multipart/form-data">
                        <div class="form-group ">
                            <label for="name" class="col-md-4 control-label">İsim</label>

                            <div class="col-md-6">
                                <input class="form-control has-error" required type="text" name="name" value="{{ Request::old('name')}}">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="email" class="col-md-4 control-label">Email adres</label>
                            <div class="col-md-6">
                                <input class="form-control " type="email" required name="email" value="{{ Request::old('email')}}">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Şifre</label>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="password" minlength="5" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Şehir seç</label>
                            <div class="col-md-6">
                                <select id="select-city" class="form-control" name="select_city">
                                    <option>Şehir seç</option>
                                    @foreach($cities as $city)
                                        <option>{{$city->name}}</option>
                                    @endforeach
                                </select>

                                <select id="select-province" class="form-control" name="select_province" style="@if(Request::get('select_city')==null)display: none @endif">
                                </select>

                                <div id="loader" style="display: none">
                                    <img style="width: 30px;" src= "{{asset('img/loader.gif')}}" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Profil fotoğrafı seçin (seçmeli)</label>
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control" value="{{Request::old('image')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Telefon numaranızı girin (seçmeli)</label>
                            <div class="col-md-6">
                                <input pattern=".{11}" class="form-control" type="text" name="mobile" placeholder="0555 123 45 67" value="{{ Request::old('mobile')}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <h6><em>*Sadece JPG formatlı maksimum 2 MB boyutlu dosya yükleyebilirsiniz</em></h6>
                            </div>
                        </div>
                        
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button class="btn btn-primary" name="signup" type="submit">Kayıt ol</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var token = "{{ Session::token() }}";
    </script>
@stop