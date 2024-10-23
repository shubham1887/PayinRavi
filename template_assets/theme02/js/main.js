jQuery( document ).ready(function($) {
"use strict" 
	$(".sticky").sticky({topSpacing:0});
	$("#loader").delay(500).fadeOut("slow");
	$('.tp-banner-fix').show().revolution({
		dottedOverlay:"none",
		delay:10000,
		startwidth:1170,
		startheight:670,
		navigationType:"bullet",
		navigationArrows:"solo",
		navigationStyle:"preview4",
		parallax:"mouse",
		parallaxBgFreeze:"on",
		parallaxLevels:[7,4,3,2,5,4,3,2,1,0],												
		keyboardNavigation:"on",						
		fullWidth:"off",
		fullScreen:"off"
	});
});

function checkmail(input) {
	var pattern1 = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  	if(pattern1.test(input)) { 
		return true;
	} else { 
		return false; 
	}
} 

function proceed() {
	var name = document.getElementById("name");
	var email = document.getElementById("email");
	var phone = document.getElementById("phone");
	var service = document.getElementById("service");
	var msg = document.getElementById("message");
	var errors = "";
	if(name.value == "") { 
		name.className = 'error';
	  	return false;
	} else if(email.value == "") {
	  	email.className = 'error';
	  	return false;
	} else if(checkmail(email.value)==false) {
		alert('Please provide a valid email address.');
		return false;
	} else if(phone.value == "") {
		phone.className = 'error';
		return false;
	} else if(service.value == "") {
		service.className = 'error';
		return false;
	} else if(msg.value == "") {
		msg.className = 'error';
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "submit.php",
			data: $("#contact_form").serialize(),
			success: function(msg) {
				if(msg) {
					//alert(msg);
					$('#contact_form').fadeOut(1000);
					$('#contact_message').fadeIn(1000);
					$('#contact_message').html(msg);
					//document.getElementById("contact_message");
					return true;
				}
			}
		});
	}
}