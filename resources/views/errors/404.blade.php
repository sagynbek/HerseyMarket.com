@extends('layouts.master')


@section('title')
	Sayfa bulunmadı
@stop

@section('content')
    <div class="container" style="margin-bottom: 5em">
        <div class="col-sm-12 text-center">
            <h2 style="font-size:26em; font-family: sans-serif;font-weight: bold;" class="text-info">
                404
            </h2>
            <h2>
                Sayfa bulunamadı ana sayfaya geri dön
            </h2>
            <h3 >
                <a href="{{route('dashboard')}}" class="text-primary btn btn-info">Ana sayfa</a>
            </h3>
        </div>
    </div>
@stop