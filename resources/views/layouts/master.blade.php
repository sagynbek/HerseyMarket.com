<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>@yield('title') | GarageSale Kullanmadığın Malı Sat yada Bedava Ver</title>

        <!-- Bootstrap -->
        {{-- <link href="css/bootstrap.min.css" rel="stylesheet"> --}}
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/logo.png')}}" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="{{asset('css/message.css')}}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

        <link href='https://fonts.googleapis.com/css?family=Ubuntu+Mono' rel='stylesheet' type='text/css'>
    </head>

    <body style="min-height: 100%">
        <div id="loading" style="display:block">
            <img style="width: 100px;" src= "{{asset('img/loader.gif')}}" >
        </div>
        <div id="body" style="opacity:0.2;">
        	@include('includes.header')

        	@yield('content')
        </div>
        
        @include('includes.footer')


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src=" {{ asset('js/main.js') }} "></script>
        @if(Auth::check())
        <script type="text/javascript" src="{{ asset('js/message.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/notify.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/notification.js') }}"></script>
        @endif
        <script src=" {{ asset('js/googleanalytics.js') }} "></script>
        
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        {{-- <script src="js/bootstrap.min.js"></script> --}}
    </body>
</html>