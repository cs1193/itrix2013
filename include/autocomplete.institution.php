<?php

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
	
	$_logincontroller->IntiateDatabase("localhost","itrixpv1_db","itrixceg","itrixpv1_db","registeredusers");
	$_logincontroller->DBLogin();

	$q = strtolower($_GET["q"]);
	if (!$q) return;

	$sql = "SELECT DISTINCT in_name AS in_name FROM institution WHERE in_name LIKE '%$q%'";
	$rsd = mysql_query($sql);
	while($rs = mysql_fetch_array($rsd)) 
	{
		$cname = $rs['in_name'];
		echo "$cname\n";
	}
?>