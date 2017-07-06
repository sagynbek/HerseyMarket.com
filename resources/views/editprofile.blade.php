@extends('layouts.master')


@section('title')
    Profili değiştir
@stop

@section('content')
    @include('includes.message-block')
    <div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profili değiştir</div>
                <div class="panel-body">

                    <form class="form-horizontal" action="{{ route('editprofile') }}" method="post" enctype="multipart/form-data">
                        <div class="form-group ">
                            <label for="name" class="col-md-4 control-label">İsim</label>

                            <div class="col-md-6">
                                <input class="form-control has-error" required type="text" name="name" value="{{ Auth::user()->name}}">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Yeni şifre</label>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="new_password" minlength="5" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Şehir seç</label>
                            <div class="col-md-6">

                                <select id="select-city" class="form-control" name="select_city">
                                    <option>Şehir seç</option>
                                    @foreach($cities as $city)
                                        <option @if(Auth::user()->city->id==$city->id) selected="selected"  @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>

                                <select id="select-province" class="form-control" name="select_province">
                                    @foreach($provinces as $province)
                                        <option @if(Auth::user()->province->id==$province->id) selected="selected"  @endif>{{$province->name}}</option>
                                    @endforeach
                                </select>

                                <div id="loader" style="display: none">
                                    <img style="width: 30px;" src= "{{asset('img/loader.gif')}}" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Yeni fotoğraf</label>
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Telefon numara (seçmeli)</label>
                            <div class="col-md-6">
                                <input pattern=".{11}" class="form-control" type="text" name="mobile" placeholder="0555 123 45 67" value="{{Auth::user()->mobile}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">

                                <h6><em>*Sadece JPG formatlı maksimum 2 MB boyutlu dosya yükleyebilirsiniz</em></h6>

                                <h6><em>*Şifreyi değiştirmek istemiyorsanız, boş bırakabilirsiniz</em></h6>

                            </div>
                        </div>
                        
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button class="btn btn-primary" name="signup" type="submit">Değişiklikleri kaydet</button>
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