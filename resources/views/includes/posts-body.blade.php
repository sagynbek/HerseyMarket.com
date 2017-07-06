@foreach($posts as $post)
    <div class="col-xs-12 col-ss-6 col-sm-4 col-md-3">
        <div class="thumbnail">
        	<a href="{{ route('product',['id'=>$post->id]) }}">
        	@if (Storage::has('/public/img/'.$post->id . '_1_post.jpg'))
                <img style="height: 200px" src="{{ route('account.image', ['filename' => $post->id . '_1_post.jpg']) }}" alt="{{$post->pr_name}}" class="img-responsive">
		    @else
                <img style="height: 200px" src="{{ route('account.image', ['filename' => 'moving-box.jpg']) }}" alt="{{$post->pr_name}}" class="img-responsive">
		    @endif
		    </a>
		    
            <div class="caption">
                <h3>{{ str_limit($post['pr_name'],12)}}</h3>
                <p>{{ str_limit($post['pr_description'],23) }}</p>
                <p class="text-right">
                	@if($post['price']>0)
                    	{{ $post['price'] }} &#8378;
                    @elseif($post['price']==0)
                    	<span class="text-primary">Bedava</span>
                    @endif
                </p>
                
                <p> 

                <div class="row">
                	<div class="col-xs-4 col-sm-4 col-md-4">
                		<a href="{{ route('product',['id'=>$post->id]) }}" class="btn btn-primary" role="button">Detay</a>
                	</div>
                	<div class="col-xs-8 col-sm-8 col-md-8"> 
                		@if($post->sold==1)
                        	<span  class="label label-danger pull-right">
                    			Satıldı
                    		</span>
                    	@else
                		<span class="label label-info pull-right">
                        	@if($post->category!=null) {{ str_limit($post->category->name,20)}}
                        	@else Digerler
                        	@endif
                    	</span>
                    	<span class="label label-success pull-right">
                        	@if($post->vote_num>0){{number_format($post->vote_sum/$post->vote_num,1)}} 
                        	@else 0 
                        	@endif
                    	</span> 
                    	@endif
                	</div>
                </div> 

                </p>
                {{-- <EM>Created <u>{{$post['created_at']->diffForHumans()}}</u>, by <a href="{{ url('users/'.$post->user->id)}}"><b>{{str_limit($post->user->name,20)}}</b></a></EM> --}}

            </div>
        </div>
    </div>
@endforeach