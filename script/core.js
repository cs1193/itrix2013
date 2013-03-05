$(function() {
	
	$(window).load(function(){
		show_modal('modalwindow1');
	});
	
	$("#slideshow > div:gt(0)").hide();
	setInterval(function() { $('#slideshow > div:first').fadeOut(1000).next().fadeIn(1000).end().appendTo('#slideshow');},  3000);
	
	$("#slideshow1 > div:gt(0)").hide();
	setInterval(function() { $('#slideshow1 > div:first').fadeOut(1000).next().fadeIn(1000).end().appendTo('#slideshow1');},  3000);

	setInterval("checkAnchor()", 30);
	$(document).ready(function() {
		   
		$('.activatemodal').live('click',function(){
			var modal_id = $(this).attr('name');
			show_modal(modal_id);
		});
        
		$('.closemodal').live('click',function(){
			close_modal();
		});
	
	});
	
	$('.logout').live('click',function () {
		uri = $(this).attr('data-uri');
		$(window.location).attr('href',uri);
	});
	
	function ticker() {
        var ticker = $('ul.ticker');
		ticker.children(':first').show().siblings().hide();
        ticker.find(':visible').fadeOut(function() {
			$(this).appendTo(ticker);
			ticker.children(':first').show();
		});
    }

    setInterval(ticker, 3000);
	
	
	$('.profileform input[name="submit"]').live('click',function(){ 
		var name = $('.profileform input[name="name"]').val();
		var phonenumber = $('.profileform input[name="phonenumber"]').val();
		var organisationname = $('.profileform input[name="organisationname"]').val();
		var accomdation = $('.profileform input[name="accomdation[]"]:checked').val();
		var data = 'name='+ name + '&phonenumber=' + phonenumber +'&organisationname='+ organisationname +'&accomdation='+ accomdation;
		$.ajax({
    			type: "POST",
    			url:'include/form.profile',
    			data: data,
    			success: function(data){
        			$('.profilesavestatus').show();
    			}
		});
		
	})
	
	$('.profileform').live('keydown',function(){ 
		$('.profilesavestatus').hide();
	})
	
	$('#facebook').live('click',function(e){
			$.oauthpopup({
				path: 'login?type=facebook',
			width:600,
			height:300,
			callback: function(){
				window.location.reload();
			}
		});
		e.preventDefault();
    });
    	
    jQuery.oauthpopup = function (options) {
        options.windowName = options.windowName || 'ConnectWithOAuth';
        options.windowOptions = options.windowOptions || 'location=0,status=0,width='+options.width+',height='+options.height+',scrollbars=1';
        options.callback = options.callback || function () {
            window.location.reload();
        };
        var that = this;
        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        that._oauthInterval = window.setInterval(function () {
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 1000);
    };
	
	$('form[name="bigdata"] input[name="submit"]').live('click',function () {
		var bank = $('form[name="bigdata"] input[name="bank"]').val();
		var branch = $('form[name="bigdata"] input[name="branch"]').val();
		var ddnumber = $('form[name="bigdata"] input[name="ddnumber"]').val();
		var amount = $('form[name="bigdata"] input[name="amount"]').val();
		if(bank != '' && branch != '' && ddnumber != '' && amount != '')
		{
			var data = 'bank='+bank+'&branch='+branch+'&ddnumber='+ddnumber+'&amount='+amount;
			$.ajax({
				type: "POST",
				url: "include/form.workshop.bigdata",	
				data: data,		
				cache: false,
				success: function (data) {				
						$('form[name="bigdata"]').fadeOut('slow');					
						$('#bigdataformholder').html(data);
					}		
			});
		}
		else
		{
			alert('Some fields are empty');
		}
	});
	
	$('form[name="win8appdev"] input[name="submit"]').live('click',function () {
		var bank = $('form[name="win8appdev"] input[name="bank"]').val();
		var branch = $('form[name="win8appdev"] input[name="branch"]').val();
		var ddnumber = $('form[name="win8appdev"] input[name="ddnumber"]').val();
		var amount = $('form[name="win8appdev"] input[name="amount"]').val();
		if(bank != '' && branch != '' && ddnumber != '' && amount != '')
		{
			var data = 'bank='+bank+'&branch='+branch+'&ddnumber='+ddnumber+'&amount='+amount;
			$.ajax({
				type: "POST",
				url: "include/form.workshop.win8appdev",	
				data: data,		
				cache: false,
				success: function (data) {				
						$('form[name="win8appdev"]').fadeOut('slow');					
						$('#win8appdevformholder').html(data);
					}		
			});
		}
		else
		{
			alert('Some fields are empty');
		}
	});
	
	$('form[name="cyberforensics"] input[name="submit"]').live('click',function () {
		var bank = $('form[name="cyberforensics"] input[name="bank"]').val();
		var branch = $('form[name="cyberforensics"] input[name="branch"]').val();
		var ddnumber = $('form[name="cyberforensics"] input[name="ddnumber"]').val();
		var amount = $('form[name="cyberforensics"] input[name="amount"]').val();
		if(bank != '' && branch != '' && ddnumber != '' && amount != '')
		{
			var data = 'bank='+bank+'&branch='+branch+'&ddnumber='+ddnumber+'&amount='+amount;
			$.ajax({
				type: "POST",
				url: "include/form.workshop.cyberforensics",	
				data: data,		
				cache: false,
				success: function (data) {				
						$('form[name="cyberforensics"]').fadeOut('slow');	
						$('#cyberforensicsformholder').html(data);				
					}		
			});
		}
		else
		{
			alert('Some fields are empty');
		}
	});
	
	$('button[name="registerforworkshop"]').live('click',function () {
		uri = $(this).attr('data-uri');
		$(window.location).attr('href',uri);
	});
	
	$('form[name="registrationform"] input[name="submit"]').live('click',function () {
		var name = $('input[name="name"]').val();
		var email = $('form[name="registrationform"] input[name="emailaddress"]').val();
		var password = $('form[name="registrationform"] input[name="password"]').val();
		var gender = $('input[name="gender[]"]:checked').val();
		
		if(name != '' && email != '' && password != '' && gender != '')
		{
			if(validateEmail(email))
			{
			var data = 'name='+name+'&email='+email+'&password='+password+'&gender='+gender;
			$.ajax({
				type: "POST",
				url: "include/form.registration",	
				data: data,		
				cache: false,
				success: function (data) {				
						if(data == 1)
						{
							$('.registrationmessage').html('<p class="paragraph1">You have successfully registered. Click here to <a href="javascript:void(0)" class="logintab">Log In</a></p>');			
							$('form[name="registrationform"]').hide();
						}
						else if(data == 2)
						{
							$('.registrationmessage').html('<p class="paragraph1">It seems you\'re email address has already been registered with us. Click here to <a href="javascript:void(0)" class="logintab">Log In</a></p>');
							$('form[name="registrationform"]').hide();
						}
						else if(data == 0)
						{
							$('.registrationmessage').html('<p class="paragraph1">We have detected a technical problem. Be back soon.</p>');
						}
					}		
			});
			}
			else
			{
				$('.registrationmessage').html('<p class="paragraph1">Invalid Email Address</p>');
			}
		}
		else
		{
			$('.registrationmessage').html('Some fields are empty');
		}
	});
	/*
	$('form[name="loginform"] input[name="submit"]').live('click',function () {
		var email = $('form[name="loginform"] input[name="email"]').val();
		var password = $('form[name="loginform"] input[name="password"]').val();
		
		if(email != '' && password != '')
		{
			var data = 'email='+email+'&password='+password;
			$.ajax({
				type: "POST",
				url: "login?type=normal",	
				data: data,		
				cache: false,
				success: function (data) {				
						$('#mask,#modalwindow').hide();
						$(window.location).attr('href','#!/home');	
						location.reload();
					}		
			});
		}
		else
		{
			$('.loginmessage').html('Some fields are empty');
		}
	});
	*/
	$('.profileform input[name="organisationname"]').autocomplete("include/autocomplete.institution", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});
});


function close_modal()
{
	$('#mask').fadeOut(500);
    $('.modalwindow').fadeOut(500);
}

function show_modal(modal_id)
{
	$('#mask').css({ 'display' : 'block', opacity : 0});
    $('#mask').fadeTo(500,0.8);
    $('#'+modal_id).fadeIn(500);
}

var currentAnchor = null;

function checkAnchor() 
{
	if (currentAnchor != document.location.hash) 
	{
		currentAnchor = document.location.hash;
		if (!currentAnchor) 
		{
			section = "home";
		}
		else 
		{
			var splits = currentAnchor.substring(3).split('&');
			var section = splits[0];
			delete splits[0];
		}
		
		loadcontent(section);
	}
}

function loadcontent(section)
{
	$("div#container div.page-wrap figure.primaryloading").show();
	$.getJSON("content", {
		section: section,
		format: 'json'
	}, function (json)
	{
		$.each(json, function (key, value) {
			$(key).html(value);
		});
		$("div#container div.page-wrap figure.primaryloading").hide();
		
		$('div#container div.page-wrap nav.primarynavigation ul li').removeClass('active');
		$("#menu" + section).addClass('active');
	});
}

$('.tab1').live('click',function() {
    $('#tab1').toggle(); 
    $('#tab2,#tab3,#tab4,#tab5,#tab6,#tab7').hide();
});

$('.tab2').live('click',function() {
    $('#tab2').toggle(); 
    $('#tab1,#tab3,#tab4,#tab5,#tab6,#tab7').hide();
});

$('.tab3').live('click',function() {
    $('#tab3').toggle(); 
    $('#tab1,#tab2,#tab4,#tab5,#tab6,#tab7').hide();
});

$('.tab4').live('click',function() {
    $('#tab4').toggle(); 
    $('#tab1,#tab2,#tab3,#tab5,#tab6,#tab7').hide();
});

$('.tab5').live('click',function() {
    $('#tab5').toggle(); 
    $('#tab1,#tab2,#tab3,#tab4,#tab6,#tab7').hide();
});

$('.tab6').live('click',function() {
    $('#tab6').toggle(); 
    $('#tab1,#tab2,#tab3,#tab4,#tab5,#tab7').hide();
});

$('.tab7').live('click',function() {
    $('#tab7').toggle(); 
    $('#tab1,#tab2,#tab3,#tab4,#tab5,#tab6').hide();
});

$('.logintab').live('click',function() {
	$('.menuregistrationtab').removeClass('active');
	$('.menulogintab').addClass('active');
    $('#logintab').toggle(); 
    $('#registrationtab').hide();
});

$('.registrationtab').live('click',function() {
	$('.menulogintab').removeClass('active');
	$('.menuregistrationtab').addClass('active');
    $('#registrationtab').toggle(); 
    $('#logintab').hide();
});

$('ul.accordion > ul:eq(0)').show();
$("ul.accordion > li").live('click',function(){

	if(false == $(this).next().is(':visible')) 
	{
		$('ul.accordion > ul').slideUp(300);
	}
	$(this).next().slideToggle(300);
});



function redirect(url) 
{
	window.location = url;
}

function validateEmail(email)
{
	email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
	if(!email_regex.test(email))
	{ 
		$('.registrationmessage').html('<p class="paragraph1">Invalid Email Address</p>');
		e.preventDefault(); 
		return false;  
	}
	return true;
}

$(".logo").live('mouseover',function(){
	$(function(){
    	$({ A : 0 }).animate({ A : 250 },{ step : function(A){
        	var dA = 15;
        	$(".logo").css("-webkit-mask","-webkit-gradient(radial, 40 52, "+A+", 40 52, "+(A+dA)+", from(rgb(0, 0, 0)), color-stop(0.5, rgba(0, 0, 0, 0.2)), to(rgb(0, 0, 0)))");
    	}, duration : 2000});
	})
});