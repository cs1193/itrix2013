<?php 

ob_start();
require 'config.php';
require 'include/login/facebook/facebook.php';
require 'include/utilities/class.utilities.inc';
require 'include/login/controller/class.logincontroller.inc';
	

$_utilities = new Utilities();
$_logincontroller = new LoginController;
$_logincontroller->IntiateDatabase("localhost","itrixpv1_users","itrixceg","itrixpv1_users","registeredusers");
$_logincontroller->DBLogin();

	$facebook = new Facebook(array('appId'		=>  $appID,'secret'	=> $appSecret,));
	$user = $facebook->getUser();

	if($user)
	{
		try
		{
			$user_profile = $facebook->api('/me');
			$params = array('next' => $base_url.'logout.php');
			$logout =$facebook->getLogoutUrl($params);
			$_SESSION['User']=$user_profile;
			$_SESSION['logout']=$logout;
		
			$registration = array();
			$registration['email'] = $_SESSION['User']['email'];

		}
		catch(FacebookApiException $e)
		{
			error_log($e);
			$user = NULL;
		}		
	}
	
	if(empty($user))
	{
		$loginurl = $facebook->getLoginUrl(array(
													'scope'			=> 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
													'redirect_uri'	=> $base_url.'login.php',
													'display'=>'popup'
												));
		$_utilities->RedirecttoUrl($loginurl);

	}





?>
<script type="text/javascript">

window.close();

</script>