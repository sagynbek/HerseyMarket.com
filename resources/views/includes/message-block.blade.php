@if(count($errors)>0)
	<div class="row">
        <div class="col-md-6 col-offset-md-3">
            <ol class="text-warning"  style="">
                @foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
            </ol>
        </div>
    </div>

@endif

@if(Session::has('warning'))
	<div class="container">
        <div class="col-md-6 col-offset-md-3">
            <p class="text-danger">{{Session::get('warning')}}</p>
        </div>
    </div>
@endif
@if(Session::has('success'))

    <div class="container">
        <div class="col-md-6 col-offset-md-3">
            <p class="text-success">{{Session::get('success')}}</p>
        </div>
    </div>
@endif