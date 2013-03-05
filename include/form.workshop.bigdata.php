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
	
	$datacollection = array();
	$datacollection['email'] = $registration['email'];
	$datacollection['bank'] = $_POST['bank'];
	$datacollection['branch'] = $_POST['branch'];
	$datacollection['ddnumber'] = $_POST['ddnumber'];
	$datacollection['amount'] = $_POST['amount'];
	
	if(empty($datacollection['email']))
	{
		echo "Email is empty";
		return false;
	}	
	
	if(empty($datacollection['bank']))
	{
		echo "Bank Name is empty";
		return false;
	}	
	
	if(empty($datacollection['branch']))
	{
		echo "Branch Name is empty";
		return false;
	}	
	
	if(empty($datacollection['ddnumber']))
	{
		echo "DD Number is empty";
		return false;
	}	
	
	if(empty($datacollection['amount']))
	{
		echo "Amount is empty";
		return false;
	}	
	
	
	if($_logincontroller->IsFieldUnique($formvars,'email'))
	{
		echo "You have already registered";
	}
	else
	{
		if($_logincontroller->InsertIntoWorkshop($datacollection,"w_bigdata"))
		{
			$_logincontroller->SendBigDataWorkshopEmail($datacollection);
			echo "<p class='paragraph1'>Successfully Submitted</p>";
		}
		else
			echo "<p class='paragraph1'>You would have registered already</p>";
	}
?>