{{-- Notification --}}
<div class="btn-group notification-group ">
    @php $cnt_not=0;$i=0;@endphp
    @foreach(Auth::user()->notifications->reverse() as  $notification) 
    @php $i++; @endphp 
    @if($i<15) @if($notification->seen==0) @php $cnt_not++; @endphp @endif
   @else @break @endif @endforeach

   <div type="button" class="dropdown-toggle header_notification not_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <a href="javascript:void(0)"><img class="notification_icon hidden-xs" src="{{asset('img/notification-icon.png')}}">
         <li class="visible-xs">
            Bildirim
         </li>
      </a>
      @if($cnt_not>0)<span class="button_badge cnt_not">{{$cnt_not}}</span> 
      @endif
  </div>

  <ul class="dropdown-menu" style="padding-top: 0px">
    @php
      $cnt_not=0;
      $i=0;
    @endphp
    @if(count(Auth::user()->notifications)>0)
      
      @foreach(Auth::user()->notifications->reverse() as  $notification)
        @if($i<15)
          @php $i++; $s_not=""; @endphp 
          <li class="notification_list @if($notification->seen==0) unseen @endif">
          <a href="{{url('/product/'.$notification->post_id)}}#comments"> 
          @if($notification->seen==0)
            @php $cnt_not++;
            @endphp
          @endif
          @php $s_not=""; @endphp
          
          @if($notification->commented==1)
              @php $s_not.="Yorum "; @endphp
          @endif
          @if($notification->liked!=NULL)
              @if($notification->liked==6)
                  @php $s_not.="1 rapor "; @endphp
              @endif
              @if($notification->liked<6)
                  @php $s_not.=$notification->liked . " yıldız "; @endphp
              @endif 
          @endif
           @php $s_not.="aldınız"; @endphp
           {{$s_not}}
          </a></li>
        @else
            @break
        @endif
      @endforeach
        
    @else
        <li>Bir bilgilendirmeniz yok</li>
    @endif  
  </ul>
</div>

<br class="visible-xs">
{{-- li clodes because to seperate message and notification from header.blade file --}}
{{-- </li>
<li>  --}}
{{-- Message --}}
<div class="btn-group notification-group">  
   @php
      $cnt_mes=0;
      $i=0;
      $ar = array();
    @endphp

    
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
          @endif
        @else
            @break
        @endif
      @endforeach 


   <div type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="header_notification">
      <a href="javascript:void(0)"><img class="notification_icon hidden-xs" src="{{asset('img/message_icon.png')}}"><p class="visible-xs">Mesajlar</p> </a>
      <span class="button_badge cnt_mes" @if($cnt_mes==0) style="display:none;" @endif>{{$cnt_mes}}</span> 
  </div>
  <ul class="dropdown-menu message_menu" style="padding-top: 0px">
    <li class="bg-info">
      <a href="{{url('/message')}}">
            Bütün mesajlarım
      </a>
    </li>
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
            {{$message->user->name}}'dan mesaj 
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
</div>
<div class="btn-group notification-group hidden-xs "> 
  <div type="button" class="header_notification">
    <a href="{{route('signout')}}">
        <img class="notification_icon" src="{{asset('img/exit-icon.png')}}">
    </a>
  </div>        
</div>