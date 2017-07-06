<div class="container" style="margin-bottom: 2em">
  <div class="row">
      {{-- <div class="col-md-12">
        <div class="text-center">
        <ul class="nav nav-pills categories category-navbar">
          @foreach($categories as $category)
            @if($category->name!="DİĞER" && $category->name!="HEPSİ" )
            <li class="category-dropdown">
              <a href="/category/{{$category->id}}" >{{$category->name}} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                @foreach($sub_categories as $sub)
                  @if($sub->category_id == $category->id)
                      <li><a href="/category/{{$category->id}}_{{$sub->id}}">{{$sub->name}}</a> </li>
                  @endif
                @endforeach
              </ul>
            </li>
            @endif
          @endforeach
        </ul>
        </div>
      </div> --}}
       <div class="col-xs-12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            @foreach($categories as $i=>$category)
              @if($category->name!="DİĞER" && $category->name!="HEPSİ" )
              <li @if($i==1) class="active" @endif>
                <a href="#category_{{$category->id}}" data-toggle="tab">
                  {{ucfirst(strtolower($category->name))}}
                </a>
              </li>
              @endif
            @endforeach
          </ul>
          <div class="tab-content">
            @foreach($categories as $i=>$category)
              @if($category->name!="DİĞER" && $category->name!="HEPSİ" )
                <div id="category_{{$category->id}}" @if($i==1) class="tab-pane active" @else class="tab-pane" @endif>
                  <ul>
                    <li class="list-items"><a href="{{url('category/'.$category->id)}}">Hepsi</a> </li>
                    @foreach($sub_categories as $sub)
                      @if($sub->category_id == $category->id)
                          <li class="list-items"><a href="{{url('category/'.$category->id)}}_{{$sub->id}}">{{ucfirst(strtolower($sub->name))}}</a> </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>
  </div>
</div>