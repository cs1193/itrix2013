<?

	ob_start();
	session_start();
	header('Content-Type: text/html; charset=utf-8'); 
	header('X-UA-Compatible: IE=Edge,chrome=1');
	require_once('utilities/class.utilities.inc');
	require_once('utilities/class.timer.inc');
	require_once('utilities/class.browser.inc');	
	require_once('login/controller/class.logincontroller.inc');
	
	$_utilities = new Utilities;
	$_timer = new Timer;
	$_browser = new Browser;
	$_logincontroller = new LoginController;
	
	$_utilities->CacheControl("Mon, 26 Jul 2030 05:00:00 GMT");
	$_timer->start_time();
	
	$_logincontroller->IntiateDatabase("localhost","itrixpv1_users","itrixceg","itrixpv1_users","registeredusers");
	$_logincontroller->DBLogin();
	
	$registration =  array();
	$registration['email'] = $_SESSION['User']['email'];
	
	$name = $_POST['name'];
	$phonenumber = $_POST['phonenumber'];
	$organisationname = $_POST['organisationname'];
	$accomdation = $_POST['accomdation'];
	
	$_logincontroller->UpdateIntoField($registration,"name",$name);
	$_logincontroller->UpdateIntoField($registration,"phonenumber",$phonenumber);
	$_logincontroller->UpdateIntoField($registration,"organisationname",$organisationname);
	$_logincontroller->UpdateIntoField($registration,"accomdation",$accomdation);
?>