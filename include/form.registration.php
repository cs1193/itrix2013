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
	
	
	$datacollection = array();
	$datacollection['name'] = $_POST['name'];
	$datacollection['email'] = $_POST['email'];
	$datacollection['password'] = $_POST['password'];
	$datacollection['gender'] = $_POST['gender'];
	
	if(empty($datacollection['name']))
	{
		echo 0;
	}
	
	if(empty($datacollection['email']))
	{
		echo 0;
	}
	
	if(empty($datacollection['password']))
	{
		echo 0;
	}
	
	if(empty($datacollection['gender']))
	{
		echo 0;
	}
	

	if(!$_logincontroller->IsFieldUnique($datacollection,'email'))
	{
		echo 2;
	}
	else
	{
		if($_logincontroller->SaveToNormalLogin($datacollection))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
?>