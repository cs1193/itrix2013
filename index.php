<?
	ob_start();
	session_start();
	header('Content-Type: text/html; charset=utf-8'); 
	header('X-UA-Compatible: IE=Edge,chrome=1');
	require_once('include/utilities/class.utilities.inc');
	require_once('include/utilities/class.timer.inc');
	require_once('include/utilities/class.browser.inc');	
	require_once('include/login/controller/class.logincontroller.inc');
	
	$_utilities = new Utilities;
	$_timer = new Timer;
	$_browser = new Browser;
	$_logincontroller = new LoginController;
	
	$_utilities->CacheControl("Mon, 26 Jul 2030 05:00:00 GMT");
	$_timer->start_time();
	
	
	$_logincontroller->IntiateDatabase("localhost","itrixpv1_users","itrixceg","itrixpv1_users","registeredusers");
	$_logincontroller->DBLogin();
	
	

	if(!isset($_SESSION['User']) && empty($_SESSION['User']))   
	{
	
	}
	else
	{
		$registration =  array();
		$registration['name'] = $_SESSION['User']['name'];
		$registration['email'] = $_SESSION['User']['email'];
		$registration['gender'] = $_SESSION['User']['gender'];
		$_logincontroller->SaveToDatabase($registration);
		if(($_logincontroller->GetLoginCount($registration)) < 1)
		{
			$_utilities->RedirectToUrl('#!/home');
		}
		$_logincontroller->SetLoginCount($registration);
	}
	
	$ch = curl_init("http://graph.facebook.com/itrixceg");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$raw = curl_exec($ch);
	curl_close($ch);

	$data = json_decode($raw);
	
?>

<!--
	
	 __     ______   ______     __     __  __       
	/\ \   /\__  _\ /\  == \   /\ \   /\_\_\_\      
	\ \ \  \/_/\ \/ \ \  __<   \ \ \  \/_/\_\/_     
	 \ \_\    \ \_\  \ \_\ \_\  \ \_\   /\_\/\_\    
	  \/_/     \/_/   \/_/ /_/   \/_/   \/_/\/_/    

	ITRIX 2013
	  
	Copyright © 2013 Information Science and Technology Association. 
	
	Department of Information Science and Technology, 
	University Departments of Anna University - College of Engineering, Guindy,
	Anna University, Chennai.
	
								सूचना विज्ञान और प्रौद्योगिकी विभाग,
								अन्ना विश्वविद्यालय के विश्वविद्यालय विभागों - कॉलेज ऑफ इंजीनियरिंग, गिंडी,
								अन्ना विश्वविद्यालय, चेन्नई.
								
								தகவல் அறிவியல் மற்றும் தொழில்நுட்ப துறை,
								அண்ணா பல்கலைக்கழகத்தின் பல்கலைக்கழக துறைகள் - பொறியியல் கல்லூரி, கிண்டி,
								அண்ணா பல்கலைக்கழகம், சென்னை.
						
	@developersinfo			
	{
	
		CHANDRESH R.M.					
		6th Semester, 2010 - 2014.
																चंद्रेश आर.एम.
																६ सेमेस्टर, २०१० - २०१४.
																
		KRISHNAN K.
		8th Semester, 2009 - 2013.
																कृष्णन क.
																८ सेमेस्टर, २००९ - २०१३.
																
		YUVARAJA B.
		8th Semester, 2009 - 2013
																युवराज ख.
																८ सेमेस्टर, २००९ - २०१३.
																
																
		B.Tech
																बी. टेक
		Information Technology
																इनफार्मेशन टेक्नोलॉजी
	}

	<? echo $_utilities->getBaseUrl()."\n"; ?>
	
	@developmentdetails
	{
		Technologies Involved:
			*	Apache HTTPD Server Project
			* 	PHP 5.4
			*	HTML 5
			*	CSS 3
			*	XML
			*	MySQL 5 Enterprise
			*	JQuery 1.8.3
			*	Javascript 
			*	AJAX
	
		Supported Browser Engine:
			*	WebKit
			*	Gecko
			*	IE > 7 (Chrome Frame)
			
		Development Tools:
			*	Notepad++
			*	Adobe Photoshop CS5
			*	Adobe Illustrator CS5
			*	Adobe Fireworks CS5
	}

		
-->

<html lang="en" dir="ltr" data-remote-address="<? echo $_utilities->GetIPAddress(); ?>" data-useragent="<? echo $_browser->getBrowser()." ".$_browser->getVersion(); ?>" data-platform="<? echo $_browser->getPlatform(); ?>" data-uri="<? echo $_utilities->getBaseUrl(); ?>"  itemscope itemtype="http://schema.org/EducationalOrganization" prefix="og: http://ogp.me/ns#">
	<head data-label="head">
	
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=egde,chrome=1"/>
		<meta http-equiv="imagetoolbar" content="false"/>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="robots" content="index,follow,all"/>
		<meta name="author" content=""/>
		<meta name="description" itemprop="description" content="ITRIX is an International Technical Symposium organised by Information Science and Technology Association formed by Department of Information Science and Technology, University Departments of Anna University - College of Engineering, Guindy, Anna University, Chennai."/>
		<meta itemprop="image" content="<? echo $_utilities->GetBaseUrl(); ?>/images/logo.png" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
		<meta name="google-site-verification" content="6WL_Bqq9vY8AW3XPV954w2kzMoQSBo1MRESr359Vl6g" />
		<meta name="msvalidate.01" content="46CE5D18E7E91CD1E18B1CFE9B4CD676" />
		
		<title itemprop="name" property="og:title">ITRIX 2013</title>
		
		<link rel="shortcut icon" href="images/favicon.png" />
		<link rel="shortlink" href="" />
		
		<link rel="stylesheet" type="text/css" media="all" href="style/reset.css" />
		<link rel="stylesheet" type="text/css" media="all" href="style/normalize.css" />
		<link rel="stylesheet" type="text/css" media="all" href="style/style.css" />
		
		<link rel="sitemap" type="application/xml" title="Sitemap" href="sitemap.xml">
		<link rel="canonical" itemprop="url" property="og:url" href="<? echo $_utilities->GetBaseUrl(); ?>">
		
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script language="javascript" type="text/javascript" charset="utf-8" src="script/jquery-1.8.3.js"></script>
		<script language="javascript" type="text/javascript" charset="utf-8" src="script/jquery.lint.js"></script>
		<script language="javascript" type="text/javascript" charset="utf-8" src="script/jquery.autocomplete.js"></script>
		<script language="javascript" type="text/javascript" charset="utf-8" src="script/modernizr.js"></script>
		<script language="javascript" type="text/javascript" charset="utf-8" src="script/core.js"></script>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div id="container">
			<div class="page-wrap">
				<header class="primaryheader">
					<hgroup class="primaryhgroup">
						<a href='http://itrix.in/'><figure class="logo"></figure></a>
						<figure class="eventdate"></figure>
						
						<aside class="sponsorholder" rel="noindex,nofollow">
							<span>SPONSORS</span>
							<figure id="slideshow1">
								<div>
									<img src="images/sponsors/current/events/amazon.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/events/emo2.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/events/indix.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/events/jctrust.png" rel="nofollow"/>
								</div>
								<div>
									<a href="http://www.uniqtechnologies.co.in/" target="_blank"><img src="images/sponsors/current/events/uniq.png" rel="nofollow"/></a>
								</div>
								<div>
									<img src="images/sponsors/current/workshops/microsoft.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/workshops/ibm.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/workshops/techbharat.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/media/aahaa.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/hospitality/ntl.png" rel="nofollow"/>
								</div>
								<div>
									<img src="images/sponsors/current/stall/iob.png" rel="nofollow"/>
								</div>
							</figure>
						</aside>
						<figure class="facebookcount">
							<div class="topcontent">We've just hit</div>
							<div class="countcontent"><? echo $data->likes; ?></div>
							<div class="bottomcontent">likes on <font style="color: #3b5999;">Facebook</font></div>
							<div style="float: left; text-align: center; padding: 10px;" class="fb-like" data-href="https://www.facebook.com/itrixceg?ref=ts&fref=ts" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="segoe ui"></div>
						</figure>
					</hgroup>
				</header>
				<nav class="primarynavigation">
					<ul>
						<li id="menuhome"><a href="#!/home" style="border-right: 1px solid rgba(0,0,0,0.5);">Home</a></li>
						<li id="menuaboutus"><a href="#!/aboutus" style="border-right: 1px solid rgba(0,0,0,0.5);">About Us</a></li>
						<li id="menuevents"><a href="#!/events" style="border-right: 1px solid rgba(0,0,0,0.5);">Events</a></li>
						<li id="menuworkshops"><a href="#!/workshops" style="border-right: 1px solid rgba(0,0,0,0.5);">Workshops</a></li>
						<li id="menusponsors"><a href="#!/sponsors" style="border-right: 1px solid rgba(0,0,0,0.5);">Sponsors</a></li>
						<li id="menucontactus"><a href="#!/contactus">Contact Us</a></li>
					</ul>
				</nav>
				<figure id='mask' class='closemodal'></figure>
				<figure id="modalwindow" class="modalwindow">
					<div class="levelholder">
						<nav class="sidebarnavigation">
							<ul>
								<li class="menulogintab"><a href="javascript:void(0)" class="logintab">Login</a></li>
								<li class="menuregistrationtab"><a href="javascript:void(0)" class="registrationtab">Sign Up</a></li>
							</ul>
						</nav>
						<aside class="contentblock">
							<div id="logintab">
								<div class="levelholder">
									<div class="buttonholder">
										<a class="btn-auth btn-facebook" id="facebook" href="javascript:void(0);">Sign in with <b>Facebook</b></a>
									</div>
									<div class="buttonholder">
										<div class="loginmessage"></div>
									</div>
									<form action="http://itrix.in/normallogin" class="formstyle1" name="loginform" method="POST">
										<input type="email" placeholder="Email" name="email" value="" required title="Email Address"/>
										<input type="password" placeholder="Password" name="password" value="" required title="Password"/>
										<input type="submit" name="submit" value="Submit"/>
									</form>
									<div class="buttonholder">
										<div class="fb-like" data-href="https://www.facebook.com/itrixceg?ref=ts&fref=ts" data-send="true" data-layout="standard" data-width="250" data-show-faces="true" data-font="segoe ui" data-colorscheme="light" data-action="like"></div>
									</div>
								</div>
							</div>
							<div id="registrationtab" class="none">
								<div class="levelholder">
									<div class="buttonholder">
										<div class="registrationmessage"></div>
									</div>
									<form action="javascript:void(0)" class="formstyle1" name="registrationform" method="POST">
										<input type="text" placeholder="Your Full Name" name="name" required title="Name"/>
										<input type="email" placeholder="Email" name="emailaddress" required title="Email Address"/>
										<input type="password" placeholder="Password" name="password" required title="Password"/>
										<section class="radioholder">
											<input type="radio" name="gender[]" value="male" title="Male" checked/><label>Male</label>
											<input type="radio" name="gender[]" value="female" title="Female"/><label>Female</label>
										</section>
										<input type="submit" name="submit" value="Submit"/>
									</form>
								</div>
							</div>
						</aside>
					</div>
				</figure>
				<figure id="modalwindow1" class="modalwindow">
					<div style="float: left; width: 100%; padding: 20px;">
						<h1 style="float: left; font-size: 30px; color: #cc3000;">Important Notice !</h1>
						<p style="position: relative; display: block; float: left; width: 100%; font-size: 18px; padding: 10px 5px; color: #222; line-height: 25px; text-align: justify;">
							The Last date for sending the DD is over
						</p>
						<p style="position: relative; display: block; float: left; width: 100%; font-size: 18px; padding: 10px 5px; color: #222; line-height: 25px; text-align: justify;">
							If you want accomodation please update it in your profile.
						</p>
						<!--p style="float: left; font-size: 18px; padding: 10px 5px; color: #222; line-height: 25px; text-align: justify;">
							Problems regarding <b style="font-weight: bold;">FACEBOOK LOGIN</b>. Please kindly upgrade your browser to the latest version to support HTML5.
						</p>
						<p style="float: left; font-size: 18px; padding: 10px 5px; color: #222; line-height: 25px; text-align: justify;">
							<a href="https://www.google.com/intl/en/chrome/browser/" target="_blank"><img src="images/browsers/chrome.png" title="Chrome"/></a>
							<a href="http://www.mozilla.org/en-US/firefox/new/" target="_blank"><img src="images/browsers/firefox.png" title="Firefox"/></a>
							<a href="http://www.opera.com/" target="_blank"><img src="images/browsers/opera.png" title="Opera"/></a>
							<a href="http://www.apple.com/safari/" target="_blank"><img src="images/browsers/safari.png" title="Safari"/></a>
						</p>
						<p style="float: left; font-size: 18px; padding: 10px 5px; color: #222; line-height: 25px; text-align: justify;">
							If problems persists, kindly get in touch with the WEB TEAM (or) mail at <a href="mailto:webmaster@itrix.in">webmaster@itrix.in</a>
						</p-->
						<p style="float: left; font-size: 15px; padding: 10px 5px; color: #999; line-height: 25px; text-align: justify;">
							Click anywhere outside this box to close.
						</p>
					</div>
				</figure>
				<figure class="primaryloading">
					<div>
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
						</ul>
					</div>
				</figure>
				<section class="primarysection">
					<div class="pageholder">
						<!--This space has been intentionally left blank-->
					</div>
				</section>
			</div>
		</div>
		<footer>
			<div class="inner">
				<a href="http://www.annauniv.edu/" target="_blank"><figure class="universitylogo" title="Anna University, Chennai"></figure></a>	
				<a href="http://www.ceg.edu.in/" target="_blank"><figure class="collegelogo" title="College of Engineering, Guindy"></figure></a>
				<figure class="associationlogo" title="Information Science and Technology Association"></figure>
				<figure class="socialicons">
					<a href="https://www.facebook.com/itrixceg" target="_blank" class="facebook" title="Facebook">Facebook</a>
					<a href="https://twitter.com/ITrix13" target="_blank" class="twitter" title="Twitter">Twitter</a>
					<a href="" target="_blank" class="youtube" title="Youtube">Youtube</a>
				</figure>
				<article class="addressholder">
					<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
						<span class="blocklevel" itemprop="streetAddress">Sardar Patel Road, Guindy</span>
						<span class="blocklevel" itemprop="addressLocality">Chennai, <span itemprop="addressRegion">TamilNadu - <span itemprop="postalCode">600025</span></span></span>
						<span class="blocklevel" itemprop="addressCountry">India</span>
					</div>
				</article>
				<nav class="footernavigation">
					<ul>
						<li><a href="#!/home">Home</a></li>
						<li><a href="#!/aboutus">About Us</a></li>
						<li><a href="#!/events">Events</a></li>
						<li><a href="#!/workshops">Workshops</a></li>
						<li><a href="#!/sponsors">Sponsors</a></li>
						<li><a href="#!/contactus">Contact Us</a></li>
						<li><a href="sitemap.html" class="sitemap" title="Sitemap">g</a></li>
					</ul>
				</nav>
			</div>
			<div class="inner">
				<div class="copyrighttext">
					 Copyright © 2013. Information Science and Technology Association.
				</div>
			</div>
		</footer>
	</body>
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-38158524-1']);
		_gaq.push(['_setDomainName', 'itrix.in']);
		_gaq.push(['_trackPageview', location.hash.slice(3, location.hash.length)]);

		(function() {
			var ga = document.createElement('script'); 
			ga.type = 'text/javascript'; 
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; 
			s.parentNode.insertBefore(ga, s);
		})();

	</script>
</html>
<?
	$_timer->end_time();
?>
<!--

	Script executed in <? echo $_timer->elapsed_time(); ?> seconds.
	
	© ISTA | DIST | CEG.AU
								
-->