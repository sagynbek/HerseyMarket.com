var preurl="/shop/public";
$(document).ready(function(){

	$("textarea#message-area").keyup(function(){

		var d = $("textarea#message-area").val();
		var show=$(".show-characters");
		//console.log(d.length);
		if(d.length<3)
			show.text(3-d.length + ' karekter daha');
		else
		if(d.length<500)
			show.text(500-d.length + ' karekter kaldi');
		else
			show.text('lutfen 500 karakteri gecmeyin');
    });


	$('#sub-mes').on('click',function(event){
		event.preventDefault();
		var d = $("textarea#message-area").val();
		
		if(d!="" && d.length>2 && d.length<500){
			var to_user = $('#to_user').val();
			var token = $('#token_id').val();
			var btn = $("#sub-mes");
			btn.text("Gonderiliyor...");
			$.ajax({
				type: 'POST',
				url: preurl.concat('/sendingMessage'),
				data: 
					{
						message: d,
						to_user_id: to_user,
						_token: token
					}
			}).success(function(data){
				if(data['success']=='1'){
					if($("#chat-part").length){
						var e = $("#chat-part");
						e.append("<blockquote class='blockquote blockquote-reverse'>"+ d +"</blockquote>");
						//var k = $('#chat-part');
						e.scrollTop(e.prop("scrollHeight"));
					}
					if($("#message-status").length){
	
						$.notify(
						    "Mesajiniz gonderildi :)",
						    { position:"bottom-right",className:"success", }
						);
					}
				}
				else{
					$.notify(
					    "Bir sey yanlis gitti :(",
					    { position:"bottom-right",className:"error", }
					);
				}
			}).error(function(){
				$.notify(
					    "Bir sey yanlis gitti :(",
					    { position:"bottom-right",className:"error", }
					);
			}).always(function() {
				$("textarea#message-area").val("");
				$(".show-characters").text("");
				btn.html("<span class='glyphicon glyphicon-send'></span> Gonder");
			});
		}
	});

	$("textarea#comment-area").keyup(function(){

		var d = $("textarea#comment-area").val();
		var show=$(".show-characters-comment");
		//console.log(d.length);
		if(d.length<3)
			show.text(3-d.length + ' karekter daha');
		else
		if(d.length<500)
			show.text(500-d.length + ' karekter kaldi');
		else
			show.text('lutfen 500 karakteri gecmeyin');
    });


	if($("#chat-part").length){
		(function worker() {
			
			var to_user = $('#to_user').val();
			var token = $('#token_id').val();

			$.ajax({
				type: 'GET',
				url: preurl.concat('/newmessage'),
				data:
				{
					user: to_user,
					_token: token
				}
				
			}).success(function(data){
				var e = $("#chat-part");
				
				for(var i = 0; i < data.length; i++) {
				    var obj = data[i].message;
				    e.append("<blockquote class='blockquote'>"+ obj +"</blockquote>");
					e.scrollTop(e.prop("scrollHeight"));
				}
				if(data.length){
					$('#chatAudio')[0].play();
				}
			}).complete(function(){
				setTimeout(worker, 5000);
			});

		})();
	}

});