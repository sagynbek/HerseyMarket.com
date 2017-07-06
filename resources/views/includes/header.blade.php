<div class="container-fluid">
    <div class="row">
        <!--start of garage sake-->
        <div class="col-md-12">
            <h1 class="text-center" style="font-family: 'Pacifico', cursive; padding-bottom: 1em; font-size: 40px;"><i>Garagesale.com.tr</i></h1>
        </div>
        <!--end of garage sake-->
        
    </div>
</div>
<div class="col-md-12" id="header">
    <!--naviigation bar-->
    <nav class="navbar navbar-default my-affix" data-spy="affix" data-offset-top="114">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @if(Auth::check())
                    {{-- @include('includes.mobile-header') --}}
                @endif
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-center">
                    <li><a href="{{route('dashboard')}}">Anasayfa</a></li>
                    @if(!Auth::check())
                        <li><a href="{{route('signup')}}">Üyelik oluştur</a></li>
                        <li><a href="{{route('signin')}}">Üye girişi</a></li>
                    @else 
                        <li><a href="{{ route('post') }}">Paylaş</a></li>
                        @if(Auth::user()->admin==1)
                            <li class="bg-info"><a href="{{route('custom_categories')}}">Yeni kategoriler</a></li>
                            
                            <li class="bg-info"><a href="{{route('allusers')}}">Bütün üyeler</a></li>
                            
                        @endif
                        <li class="visible-xs"><a href="{{route('signout')}}">Çıkış</a></li>
                    @endif
                </ul>

                <div class="nav navbar-nav navbar-right text-center">
                    @if(Auth::check())
                        <li>
                            <a class="profile-image" style="padding:2.5px" href="{{ url('users/'.Auth::user()->id) }}">
                                @if(Storage::has('/public/img/'.Auth::user()->id . '_thumb.jpg'))
                                    <img style="height: 45px; margin-left: auto;margin-right:auto" src="{{ route('account.image', ['filename' => Auth::user()->id . '_thumb.jpg']) }}" alt="{{Auth::user()->name}}" class="img-responsive img-circle">
                                @else
                                    <img style="height: 45px; margin-left: auto;margin-right:auto;" src="{{ route('account.image', ['filename' => 'nopicture.jpg']) }}" alt="{{Auth::user()->name}}" class="img-responsive img-circle">
                                @endif
                            </a>
                        </li>
                        <li class="hidden-xs">
                            <a href="{{ url('users/'.Auth::user()->id) }}">
                                {{Auth::user()->name}}
                            </a>
                        </li>
                        @include('includes.desktop-header')

                        <input type="hidden" id="token_id" name="_token" value="{{Session::token()}}">
                        
                    @endif
                </div> 
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>