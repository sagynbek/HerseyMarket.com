<div class="navbar-right visible-xs">
    {{-- Notifications --}} 
    <div class="btn-group notification-group">
        <ul class="dropdown-menu">
            @php
                $cnt_not=0;
                $i=0;
            @endphp
            @if(count(Auth::user()->notifications)>0) 
                @foreach(Auth::user()->notifications->reverse() as  $notification)
                    
                    @if($i<15)
                        @php $i++; @endphp

                        <li class="notification_list @if($notification->seen==0) unseen @endif">
                        <a href="{{url('/product/'.$notification->post_id)}}#comments">

                        @if($notification->seen==0)
                            @php $cnt_not++;
                            @endphp
                        @endif
                         
                        @if($notification->commented==1)
                            Yorum 
                        @endif
                        @if($notification->liked!=NULL)
                            @if($notification->liked==6)
                                1 rapor 
                            @endif
                            @if($notification->liked<6)
                                {{$notification->liked}} yıldız 
                            @endif 
                        @endif
                         aldınız
                        </a></li>
                    @else
                        @break
                    @endif
                @endforeach
                
            @else
                <li>Bir bilgilendirmeniz yok</li>
            @endif  
        </ul>
        <div type="button" class="dropdown-toggle header_notification not_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <a href="javascript:void(0)"><img class="notification_icon" src="{{asset('img/notification-icon.png')}}"> </a>
            @if($cnt_not>0)<span class="button_badge cnt_not">{{$cnt_not}}</span> 
            @endif
        </div> 
    </div>

{{-- Messages --}}
    <div class="btn-group notification-group ">          
        <ul class="dropdown-menu message_menu">
        
            @php
                $cnt_mes=0;
                $i=0;
                $ar = array();
            @endphp

            @if(count(Auth::user()->messages)>0) 
                @foreach(Auth::user()->messages as  $message)
                    @php $i++; @endphp
                    @if($i<15)
                        @if(array_key_exists($message->user_id, $ar))
                        @else
                            @if($message->seen==0)
                                @php
                                    $cnt_mes++;
                                @endphp
                            @endif 
                            @php $ar[$message->user_id] = 1;
                            @endphp
                            <li class="notification_list @if($message->seen==0) unseen @endif"><a href="{{url('/message/'.$message->user_id)}}">
                             
                            {{$message->user->name}}'dan mesaj aldınız
                            </a></li>
                        @endif
                    @else
                        @break
                    @endif
                @endforeach 

            @else
                <li>Bir mesajınız yok</li>
            @endif  
        </ul>

        <div type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="header_notification">
            <a href="javascript:void(0)"><img class="notification_icon" src="{{asset('img/message_icon.png')}}"> </a>
            <span class="button_badge cnt_mes" @if($cnt_mes==0) style="display:none;" @endif>{{$cnt_mes}}</span> 
        </div>
    </div>
    
    <div class="btn-group notification-group">
        <div type="button" class="header_notification">
            <a href="{{route('signout')}}">
                <img class="notification_icon" src="{{asset('img/exit-icon.png')}}">
            </a>
        </div>        
    </div>    
</div>  

