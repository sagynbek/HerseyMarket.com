var preurl="/shop/public";
window.onload = function(){
	$('#loading').fadeOut();
	$('#body').css('opacity',1);

	if($("#chat-part").length){
		var d = $('#chat-part');
		d.scrollTop(d.prop("scrollHeight"));
		$('html,body').animate({
	        scrollTop: $("#header").offset().top},
	        'slow');
	}
}

$(document).ready(function () {
	$("#search_details").on('click',function(){
		var e = $("#search_details");
		if(e.text()=="Daha fazla")e.text("Daha az");
		else e.text("Daha fazla");
	});
	$('#sub-com').on('click',function(event){
		$('#sub-com').addClass('disabled');
	});
	$(document).unload(function(){
		$('#sub-post').addClass('disabled');
	});

	// Choosing category for searching 
    $("#category").change(function () {
        var val = $(this).val();
        $("#loader").css("display","block");

        $('.custom_category').hide();

        var x = $("#category2");
        x.hide();
		x.empty();

		$.ajax({
			type: 'POST',
			url: preurl.concat('/getCategory'),
			data: 
				{
					category: val,
					_token: token
				}
		}).success(function(data){
			for(var i = 0; i < data.length; i++) {
			    var obj = data[i].name;
			    //console.log(obj);
			    x.append('<option>'+ obj +'</option>');
			    x.show();
			}
		}).always(function() {
			//$("#loader").hide();
			$("#loader").css("display","none");
		});
	});
	$("#category2").change(function () {
        var val = $(this).val();
        if(val=="Diğer"){
        	$('.custom_category').show();
        }
        else
        	$('.custom_category').hide();
	});
	/*
	// Search and show in one page 
    $("#search").click(function(){
    	var category = $("#category").val();
    	var category2 = $("#category2").val();
    	var description = $("#search-description").val();
    	console.log(category);
		console.log(category2);
    	console.log(description);

    	$.ajax({
    		type: 'POST',
    		url:'/shop/public/searchPost',
    		data:
    		{
    			category: category,
    			category2: category2,
    			description: description,
    			_token: token
    		}
    	}).success(function(data){
    		console.log(data['posts'].length);
    		console.log(data.success)
    		for(var i = 0; i < data['posts'].length; i++) {
			    var obj = data[i].pr_name;
			    console.log(obj+" "+ data[i].pr_description);
			}

    	}).always(function(){

    	});
    });*/
    
    $("#select-city").change(function () {
    	var val = $(this).val();
        $("#loader").show();

        var x = $("#select-province");
        x.hide();
		x.empty();
		
		$.ajax({
			type: 'POST',
			url: preurl.concat('/getProvince'),
			data: 
				{
					city: val,
					_token: token
				}
		}).success(function(data){
			//console.log('HEPSİ');
			var url = "http://mywebsite/folder/file";
			var array = url.split('/');

			if(array[array.length-1]=="signup")
				x.append('<option>HEPSİ</option>');
			for(var i = 0; i < data.length; i++) {
			    var obj = data[i].name;
			    //console.log(obj);
			    x.append('<option>'+ obj +'</option>');
			    x.show();
			}
		}).always(function() {
			$("#loader").hide();
		});

    });

    //Notification make read
    $(".not_btn").on('click',function(){
    	//var cnt_not = $("#cnt_not").text();
    	var cnt_not = $(".cnt_not:first" ).text();
    	
    	if(cnt_not!="" && cnt_not!="0" ){
    		//console.log("I am in clean notification AJAX");
    		$.ajax({
    			type:'GET',
    			url: preurl.concat('/cleanNotification')
    		}).success(function(data){
    			//$("#cnt_not").text("");
    			
    			$( ".cnt_not" ).each(function( index, element ) { 
    				$(element).text("");
    				$(element).css("padding","0px");
    			});
    			

    			//console.log("Notifications has been cleaned, " + data.success);
    		}).error(function(){
    			//console.log("Something went wrong");
    		});
    	}
    	else{
    		//console.log(cnt_not + "NOT in clean notification AJAX" );
    	}

    });
    
    $('<audio id="chatAudio"><source src="'+ preurl+'/sound/message.ogg" type="audio/ogg"><source src="'+ preurl+'/sound/message.mp3" type="audio/mpeg"><source src="'+ preurl +'/sound/message.wav" type="audio/wav"></audio>').appendTo('body');

});

/*
$('#delete_post').on('click',function(event)){
	if(confirm('Do you want to delete this post?'))
		return 1;
	else
		event.preventDefault();
}*/

