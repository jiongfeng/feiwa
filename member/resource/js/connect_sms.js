	function get_sms_captcha(type){
        if($("#phone").val().length == 11 && $("#image_captcha").val().length == 4){
            var ajaxurl = 'index.php?app=connect_sms&feiwa=get_captcha&nchash=1&type='+type;
            ajaxurl += '&captcha='+$('#image_captcha').val()+'&phone='+$('#phone').val();
			$.ajax({
				type: "GET",
				url: ajaxurl,
				async: false,
				success: function(rs){
                    if(rs == 'true') {
                    	$("#sms_text").html('短信动态码已发出');
                    } else {
                        showError(rs);
                    }
			    }
			});
    	}
	}
	function check_captcha(){
        if($("#phone").val().length == 11 && $("#sms_captcha").val().length == 6){
            var ajaxurl = 'index.php?app=connect_sms&feiwa=check_captcha';
            ajaxurl += '&sms_captcha='+$('#sms_captcha').val()+'&phone='+$('#phone').val();
			$.ajax({
				type: "GET",
				url: ajaxurl,
				async: false,
				success: function(rs){
            	    if(rs == 'true') {
            	        $.getScript('index.php?app=connect_sms&feiwa=register'+'&phone='+$('#phone').val());
            	        $("#register_sms_form").show();
            	        $("#post_form").hide();
            	    } else {
            	        showError(rs);
            	    }
			    }
			});
    	}
	}