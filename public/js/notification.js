var preurl="/shop/public";
$(document).ready(function(){
	var url=window.location.href;

	if(url.indexOf("/message/")==-1)
	  (function get_message() {
		var token = $('#token_id').val();

		$.ajax({
			type: 'GET',
			url: preurl.concat('/newnotificationmessage'),
			data:
			{
				_token: token
			}
		}).success(function(data){
			if(data.length){
				//console.log(data.length);
				var num=$(".cnt_mes:first").text();
				
				if(num==null || num=="")num=0;
				else num=parseInt(num);

				for(var i = 0; i < data.length; i++) 
					$(".message_menu").prepend('<li class="notification_list unseen "><a href="'+preurl+'/message/'+ data[i].user_id +'">You got new message from '+data[i].user_name+'</a></li>');
				$('.cnt_mes').css('display','block');
				$(".cnt_mes").text(num+data.length);
				$('#chatAudio')[0].play();
			}
		}).complete(function(){
			setTimeout(get_message, 5000);
		});
	  })();
});
