@extends('layouts.master')


@section('title')
	{{ucwords(strtolower($post->pr_name))}}
@stop


@section('content')
    @include('includes.message-block')
	<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!--start of body content-->

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-9">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    @for($i=1;$i<4;$i++)
                                        @if (Storage::has('/public/img/'.$post->id . '_'.$i.'_post.jpg'))
                                            <div class="tab-pane @if($i==1) active @endif" id="{{"sl_".$i}}">
                                                <img style="height: 300px" src="{{ route('account.image', ['filename' => $post->id . '_'.$i.'_post.jpg']) }}" alt="{{$post->pr_name}}" class="img-responsive thumbnail">
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-right">
                                    @for($i=1;$i<4;$i++)
                                        @if (Storage::has('/public/img/'.$post->id . '_'.$i.'_post_thumb.jpg'))
                                            <li @if($i==1) class="active" @endif><a href="#{{"sl_".$i}}" data-toggle="tab">
                                            <img style="height: 50px" src="{{ route('account.image', ['filename' => $post->id . '_'.$i.'_post_thumb.jpg']) }}" alt="{{$post->pr_name}}" class="img-responsive thumbnail">
                                            </a></li>
                                        @endif
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h1> {{ title_case($post->pr_name) }}</h1>

                                @if($post->sold==1)
                                    <h3>
                                        <span class="label label-danger pull-right">Satıldı</span>
                                    </h3>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <h6><span class="label label-primary"> {{ $post->category->name }}</span></h6> 
                                        <span class="monospaced"><b>Adres:</b> {{$post->province->name}} / {{$post->city->name}} / Türkiye</span>
                                        <br>
                                        <span class="monospaced"><b>İsim:</b> <a href="{{url('users/'.$post->user_id)}}">{{$post->user->name}} </span></a>
                                    </div>
                                </div><!-- end row -->
                                <br>
                                <div class="row">
                                    @if(Auth::user() && Auth::user()->id != $post->user_id)
                                        @if(empty($like))
                                        <form action="{{ route('like') }}" method="post"> 
                                            <input type="integer" name="like" min="0" max="5" required>
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="_token" value="{{Session::token()}}">
                                            <input class="btn btn-primary" type="submit" value="Vote">
                                        </form>
                                        <form action="{{ route('like') }}" method="post"> 
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="like" value="6">
                                            <input type="hidden" name="_token" value="{{Session::token()}}">
                                            <input class="btn btn-primary" type="submit" value="Report">
                                        </form>
                                        

                                        @endif
                                        @if(!empty($like))
                                            @if($like->like<6)
                                                <p>Siz <b>{{$like->like}}</b> yıldız vermişsiniz</p>
                                            @endif
                                            @if($like->like==6)
                                                <p>Siz <b>raporlamışsınız</b></p>
                                            @endif
                                            <form action="{{ route('cancel_like') }}" method="post"> 
                                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                                <input type="hidden" name="_token" value="{{Session::token()}}">
                                                @if($like->like<6)
                                                    <input class="btn btn-primary" type="submit" value="Cancel Vote">
                                                @endif
                                                @if($like->like==6)
                                                    <input class="btn btn-primary" type="submit" value="Cancel Report">
                                                @endif
                                                
                                            </form>
                                        @endif
                                    @endif
                                    <p>Bu mal @if($post->vote_num>0){{number_format($post->vote_sum/$post->vote_num,1)}} @else 0 @endif derecesi var, <span class="label label-success">@if($post->vote_num!=null){{$post->vote_num}} @else 0 @endif kişi oylamasınan</span></p>
                                    <p>Ve {{$post->report}} raporu var</p>
                                    
                                    <br><br>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                        <span class="sr-only">Four out of Five Stars</span>
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                        <span class="label label-success">61</span>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#coment">
                                            <span style="font-family: 'Ubuntu Mono, monospaced;'">Write a Review</span>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="panel with-nav-tabs panel-default">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab1default" data-toggle="tab">Açıklama</a></li>
                                            <li><a href="#tab2default" data-toggle="tab">Eleştiri</a></li>
                                            <li><a href="#tab3default" data-toggle="tab">Başka</a></li>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab1default">
                                                <p class="monospaced">
                                                    {{str_limit($post->pr_description,500)}}
                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="tab2default">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span class="sr-only">Four out of Five Stars</span>
                                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                        <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                                        <span class="label label-success">61</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab3default">Şuan burası boş durumda</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 bottom-rule">
                                        <h2 class="product-price">{{$post->price}}.00 &#8378;</h2>
                                        <span>
                                            @if(Auth::user() && Auth::user()->id==$post->user_id)
                                                
                                            @endif
                                        </span>
                                    </div>
                                </div><!-- end row -->

                                <div class = "btn-group">
                                    <a class="btn btn-lg btn-brand btn-full-width btn-primary" href="tel:555-666-7777"><span class="glyphicon glyphicon-earphone">&nbsp;</span>Ara</a>

                                    @if(Auth::user() &&  (Auth::user()->id == $post->user_id || Auth::user()->admin==1))
                                        <a class="btn btn-lg btn-brand btn-full-width btn-info" href="{{url('/edit/'.$post->id)}}"><span class="glyphicon glyphicon-edit">&nbsp;</span>Değiştir</a>

                                        <a class="btn btn-lg btn-brand btn-full-width btn-danger" id="delete_post" href="{{ url('delete/'.$post->id) }}"><span class="glyphicon glyphicon-remove">&nbsp;</span>Sil</a>
                                    @else
                                        <button type="button" class="btn btn-lg btn-brand btn-full-width btn-info" data-toggle="collapse" data-target="#message-field2">Mesaj at</button>

                                        <div class="message-field collapse" id="message-field2">
                                            <form class="send-message-box" action="{{ route('send_message') }}" method="post">
                                                
                                                <textarea name="message" class="form-control" id="message-area" placeholder="Mesajinizi yazin..." rows="3"></textarea>
                                                
                                                <input type="hidden" name="to_user_id" id="to_user" value="{{ $post->user_id }}">
                                                <input type="hidden" name="_token" id ="token_id" value="{{ Session::token() }}">
                                                <em class="show-characters"></em>
                                                <button type="submit" name="submit" id="sub-mes" class="btn btn-primary send-message-btn">
                                                    <span class="glyphicon glyphicon-send"></span> Gönder
                                                </button>
                                                <em id="message-status"></em>
                                            </form>
                                        </div>
                                    @endif
                                    

                                    @if(Auth::user() && Auth::user()->id==$post->user_id)
                                        <a class="btn btn-lg btn-brand btn-full-width btn-success" href="{{url('sold/'.$post->id)}}">
                                            @if($post->sold==1)<span class="glyphicon glyphicon-ok">&nbsp;</span>İptal et
                                            @else
                                                <span class="glyphicon glyphicon-tag">&nbsp;</span>Satıldı?
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="container" id="comments">
                    <h2>Yorumlar:</h2>
                    <ul class="nav nav-tabs" id="comment">
                        <li class="active"><a data-toggle="tab" href="#home">Yorumlar</a></li>
                        <li><a data-toggle="tab" href="#menu1">Yorum ekle</a></li>
                    </ul>

                    <div class="tab-content">
                        <!--commment body-->
                        <br>
                        @if($comments->isEmpty())
                            <div id="home" class="tab-pane fade in active">
                                <div class="col-xs-2 col-md-2 col-md-offset-1">
                                    <div class="thubnail">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-8">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Başlık yok
                                        </div>
                                        <div class="panel-body">
                                            Yorum yok
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div id="home" class="tab-pane fade in active">
                            @foreach($comments as $comment)
                                <div class="row">
                                    <div class="col-xs-2 col-md-2 col-md-offset-1">
                                        <div class="thubnail">
                                            @if(Storage::has('/public/img/'.$comment->user_id.'_thumb.jpg'))
                                                <img src="{{route('account.image', ['filename' => $comment->user_id.'_thumb.jpg']) }}" alt="{{$comment->user->name}}. profile"}}" class="img-circle">
                                            @endif
                                            @if(!Storage::has('/public/img/'.$comment->user_id.'_thumb.jpg'))
                                                <img src="{{route('account.image', ['filename' => 'nopicture.jpg']) }}" alt="{{$comment->user->name}}. profile"}}" class="img-circle">
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-xs-offset-1 col-sm-offset-0" >
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <a href=" {{url('/users/'.$comment->user->id) }} "><strong>{{$comment->user->name}}</strong></a>
                                                <span class="text-muted">{{$comment->created_at->diffForHumans()}}</span>

                                                @if(Auth::user()->id==$comment->user->id) | 
                                                    <a href=" {{ url('/delete comment/'.$comment->id) }} " class="text-right"><span>Sil</span></a>
                                                @endif
                                            </div>
                                            <div class="panel-body">
                                                {{$comment->text}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        <div id="menu1" class="tab-pane fade">
                            <!--add comment body-->
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <form method="post" action="{{ route('make_comment') }}">
                                        <div class="form-group ">
                                            <label class="control-label requiredField" for="message">
                                                Yorum
                                                <span class="asteriskField">*</span>
                                            </label>
                                            <textarea name="text" class="form-control " id="comment-area" placeholder="Yorum..." rows="5"></textarea>
                                            <em class="show-characters-comment"></em>
                                        </div>
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="user_id" @if(Auth::user()) value="{{ Auth::user()->id }}" @endif >
                                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                                        
                                        <div class="form-group">
                                            <div>
                                                <button class="btn btn-primary " id="sub-com" name="submit" type="submit">
                                                    Onayla
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--main div cont and row-->
            </div>


            <!--end of body content-->

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
@stop