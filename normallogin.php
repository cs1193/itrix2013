<?
	ob_start();
	session_start();
	require 'include/utilities/class.utilities.inc';
	require 'include/login/controller/class.logincontroller.inc';
	

	$_utilities = new Utilities();
	$_logincontroller = new LoginController;
	$_logincontroller->IntiateDatabase("localhost","itrixpv1_users","itrixceg","itrixpv1_users","registeredusers");
	$_logincontroller->DBLogin();

	$base_url = "http://itrix.in/";
	
	$userinput = array();
	$userinput['email'] = isset($_POST['email']) ? $_POST['email'] : '';
	$userinput['password'] = isset($_POST['password']) ? $_POST['password'] : '';
	
	if(empty($userinput['email']))
	{
		$_utilities->RedirecttoUrl($base_url);
	}
	
	if(empty($userinput['password']))
	{
		$_utilities->RedirecttoUrl($base_url);
	}
	
	
	if($_logincontroller->CheckLoginInDB($userinput))
	{
		$_SESSION['User'] = $_logincontroller->GetNormalUserInformation($userinput);
		$_SESSION['logout'] = $base_url.'logout.php';
		
		$registration = array();
		$registration['email'] = $_SESSION['User']['email'];
		$_utilities->RedirecttoUrl($base_url);
	}
	else
	{
		echo "Invalid Password";
		sleep(10);
		$_utilities->RedirecttoUrl($base_url);
	}
?>