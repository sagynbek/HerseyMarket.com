
<!--navigation bar end-->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <div class="row"> --}}
                {{-- <div class="col-md-12"> --}}
                    <form method="post" action="{{route('make_search')}}" class="navbar-form text-center" role="search" style="padding-bottom: 1em;">
                        <div class="input-group form-group col-md-6 col-xs-12">
                            <input type="text" class="form-control" name="search-description" id="search-description" size="40" style="width:50%;" placeholder="Ara...">
                            <select name="select_category" id ="category" class="form-control" style="width:50%;">
                                @foreach($categories as $category)
                                    <option>{{$category->name}}</option>
                                @endforeach
                            </select>

                                
                            <input type="hidden" name="_token" value="{{Session::token()}}">
                            <span class="input-group-btn">
                                <button id="search" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span>&nbsp;Ara</button>
                            </span>
                        </div> 
                        <div class="input-group form-group col-md-6 col-xs-12">
                            {{-- <select class="form-control" name="select_category2" id="category2" style="display:none">
                            </select> --}}
                            <div id="city_detail" class="collapse">
                                <select name="select_city" id="select-city" class = "form-control" style="width:50%;"
                                >   
                                    <option>Bütün şehirler</option>
                                    @foreach($cities as $city)
                                        <option  @if(Auth::check() && Auth::user()->city->id==$city->id) selected="selected"  @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <select name="select_province" id="select-province" class="form-control" style="width:50%;">
                                    <option>HEPSİ</option>
                                    @if($provinces!=null)
                                    @foreach($provinces as $province)
                                        <option  @if(Auth::check() && Auth::user()->province->id==$province->id) selected="selected"  @endif>{{$province->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="checkbox" style="margin-bottom: 1em;margin-top: 0.3em">
                                  <label><input type="checkbox" name="bedava"> Bedava</label>
                                </div>
                            </div>
                            
                            <div class="text-center clear">
                                <a href="javascript:void(0)">
                                    <p class="clear" data-toggle="collapse" data-target="#city_detail" id="search_details">Daha fazla</p>
                                </a>
                                <span id="loader" class="loading" style="display: none">
                                    <img style="width: 30px;" src= "{{asset('img/loader.gif')}}" >
                                </span>

                            </div>
                                
                        </div>
                    </form>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>
<script>
    var token = "{{ Session::token() }}"
</script>