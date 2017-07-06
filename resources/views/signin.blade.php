@extends('layouts.master')


@section('title')
    Giriş yap
@stop

@section('content')
	@include('includes.message-block')
	<div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Giriş</div>
                <div class="panel-body">
                
			        <form  class="form-horizontal" action=" {{ route('signin') }}" method="post">
			            <div class="form-group">
			                <label for="email" class="col-md-4 control-label">E-Mail adres</label>

                            <div class="col-md-6">
			                	<input class="form-control" type="email" name="email" value="{{ Request::old('email')}}" placeholder="Email">
			                </div>
			            </div>
			            <div class="form-group">
			                <label for="password" class="col-md-4 control-label">Şifre</label>
			                <div class="col-md-6">
				                <input class="form-control" type="password" name="password" placeholder="Password">
				            </div>

			                <input type="hidden" name="_token" value="{{ Session::token() }}">

			            </div>
			            <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                        <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Beni hatırla
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary" type="submit">Giriş yap</button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Şifrenizi mi unuttunuz?
                                </a>
                            </div>
                        </div>
			        </form>
	        	</div>
	        </div>
	    </div>
	</div>
@stop