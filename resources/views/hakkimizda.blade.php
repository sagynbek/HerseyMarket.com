@extends('layouts.master')

@section('title')
    İletişim
@stop

@section('content')
    <div class="container">
        @include('includes.message-block')
        <div class="text-center" style="margin-bottom: 2em">
            <h2>Bize mesaj bırakın</h2>
        </div>
        <form action="{{route('leave_message')}}" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">Konu</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" placeholder="Konu" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Ad</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="Ad" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Mesaj</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="message" rows="5" placeholder="Mesaj..." required></textarea>
                </div>
            </div>
            <input type="hidden" name="_token" id ="token_id" value="{{ Session::token() }}">
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Geri bildirim</button>
                </div>
            </div>
        </form>
    </div>
@stop