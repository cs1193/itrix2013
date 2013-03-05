<?

	
	class LoginController
	{
	
		var $username;
		var $password;
		var $hostname;
		var $database;
		var $connection;
		var $tablename;
		var $errormessage;
		var $from_address;
		
		function IntiateDatabase($hostname,$username,$password,$database,$tablename)
		{
			$this->hostname = $hostname;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
			$this->tablename = $tablename;
		}
		
		function HandleError($err)
    		{
        		$this->error_message .= $err."\r\n";
    		}  

    		function HandleDBError($err)
    		{
        		$this->HandleError($err."\r\n mysqlerror:".mysql_error());
    		}
    		
    		function DBLogin()
    		{
        		$this->connection = mysql_connect($this->hostname,$this->username,$this->password);
			if(!$this->connection)
        		{   
            			$this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
				return false;
			}

        		if(!mysql_select_db($this->database, $this->connection))
			{
            			$this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
				return false;
			}

        		if(!mysql_query("SET NAMES 'UTF8'",$this->connection))
			{
				$this->HandleDBError('Error setting utf8 encoding');
				return false;
			}
			
			return true;
		}    

		function Ensuretable()
    		{
        		$result = mysql_query("SHOW COLUMNS FROM $this->tablename");   
        		if(!$result || mysql_num_rows($result) <= 0)
        		{
            			return $this->CreateTable();
        		}
        		return true;
    		}
  
		function CreateTable()
    		{

        		$qry = 	"CREATE TABLE IF NOT EXISTS $this->tablename (".
				"id int(6) NOT NULL AUTO_INCREMENT,".
				"facebookid varchar(1000) NOT NULL DEFAULT '',".
				"name varchar(1000) NOT NULL DEFAULT '',".
				"email varchar(1000) NOT NULL DEFAULT '',".
				"gender varchar(1000) NOT NULL DEFAULT '',".
				"birthday varchar(1000) NOT NULL DEFAULT '',".
				"timezone varchar(1000) NOT NULL DEFAULT '',".
				"PRIMARY KEY (id),".
				"UNIQUE KEY id (id),".
				"UNIQUE KEY email (email)".
				")ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

     			if(!mysql_query($qry,$this->connection))
			{
				$this->HandleDBError("Error creating the table \nquery was\n $qry");
				return false;
			}
			return true;
		}
		
		function SanitizeForSQL($str)
		{
			if( function_exists( "mysql_real_escape_string" ) )
			{
				$ret_str = mysql_real_escape_string( $str );
			}
			else
			{
				$ret_str = addslashes( $str );
			}
			return $ret_str;
		}

    	function Sanitize($str,$remove_nl=true)
		{
			$str = $this->StripSlashes($str);
			if($remove_nl)
			{
				$injections = array('/(\n+)/i','/(\r+)/i','/(\t+)/i','/(%0A+)/i','/(%0D+)/i','/(%08+)/i','/(%09+)/i');
				$str = preg_replace($injections,'',$str);
			}
			return $str;
		}    

    	function StripSlashes($str)
		{
			if(get_magic_quotes_gpc())
			{
				$str = stripslashes($str);
			}
			return $str;
		}    
		
		function SaveToDatabase(&$formvars)
    	{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}

			if(!$this->Ensuretable())
			{
				return false;
			}
			
			if(!$this->IsFieldUnique($formvars,'email'))
			{
				$this->HandleError("This email is already registered");
				return false;
			}
       
       			if(!$this->InsertIntoDB($formvars))
			{
				$this->HandleError("Inserting to Database failed!");
				return false;
			}
			
			if(!$this->SendUserWelcomeEmail($formvars))
        		{
				return false;
			}
			
			return true;
		}
		
		function IsFieldUnique($formvars,$fieldname)
    	{
			$field_val = $this->SanitizeForSQL($formvars[$fieldname]);
			$qry = "SELECT email FROM $this->tablename WHERE $fieldname='".$field_val."'";
			$result = mysql_query($qry,$this->connection);   
			if($result && mysql_num_rows($result) > 0)
			{
				return false;
			}
			return true;
		}
		
		function InsertIntoDB(&$formvars)
    	{
			$uniqueid = $this->GetUniqueId();
        	$insert_query = 'INSERT INTO '.$this->tablename.'(itrixid, name, email, gender) VALUES ("'.$uniqueid.'","' . $this->SanitizeForSQL($formvars['name']) . '","' . $this->SanitizeForSQL($formvars['email']) . '","' . $this->SanitizeForSQL($formvars['gender']) . '")';      
			if(!mysql_query( $insert_query ,$this->connection))
			{
				$this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
				return false;
			}        
			return true;
		}
		
		function SendUserWelcomeEmail(&$user_rec)
		{
			$To=$user_rec['email'];
			$Subject = "Welcome to ITRIX 2013";
			$From = $this->GetFromAddress();        
			$Body ="<html>".
			"<head>".
			"<title>Welcome to ITRIX 2013</title>".
			"</head>".
			"<body style=\"background-color: rgba(0,0,0,0.5);\">".
			"<img src=\"http://test.itrix2013.heliohost.org/images/logo.png\" class=\"logo\" width=\"250\" height=\"100\" style=\"position: relative; display: block; float: left; width: 250px; height: 100px; padding: 10px;\"><br>".
  			"<div style=\"float: left; width:100%; min-height: 200px; overflow: auto; background-color: white; \">".
  			"Hello ".$user_rec['name'].",<br><br>".
			"Welcome! Your registration  with ITRIX 2013 is completed.<br>".
			"<br>".
			"Regards,<br>".
			"Web Coordinator<br>".
			"</div>".
			"</body>".
			"</html>";
			$Headers = "MIME-Version: 1.0\r\n"; 
    			$Headers .= "Content-type: text/html; charset=utf-8\r\n";
			$Headers .= "From: ITRIX 2013 <$From> \r\n";
			$Headers .= "Reply-To: $From \r\n";
			$Headers .= "Return-Path: $From\r\n";
			$Headers .= "X-Mailer: PHP \r\n";
			
			if(!mail($To,$Subject,$Body,$Headers))
			{
				$this->HandleError("Failed sending user welcome email.");
				return false;
			}
			return true;
		}
		
		function GetFromAddress()
    		{
        		if(!empty($this->from_address))
			{
				return $this->from_address;
			}
			$from ="webmaster@itrix.in";
			return $from;
		}
		
		function UpdateIntoField(&$formvars,$fieldname,$fieldvalue)
		{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}
			$insert_query = "UPDATE ".$this->tablename." SET ".$fieldname." = '" . $this->SanitizeForSQL($fieldvalue) . "' WHERE email='".$formvars['email']."'";      
			if(!mysql_query( $insert_query ,$this->connection))
			{
				$this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
				return false;
			}        
			return true;
		}
		
		function GetLoginCount(&$formvars)
		{
			$emailaddress = $formvars['email'];
			$get_query = "SELECT * FROM $this->tablename WHERE email = '".$emailaddress."'";
			$get_result = mysql_query( $get_query ,$this->connection);
			$get_row = mysql_fetch_assoc($get_result);
			return $get_row['logincount'];
		}
		
		function SetLoginCount(&$formvars)
		{
			$counter = $this->GetLoginCount(&$formvars);
			$emailaddress = $formvars['email'];
			$counter=$counter+1;
			$update_query = "UPDATE $this->tablename SET logincount =".$counter." WHERE email = '".$emailaddress."'";
			if(!mysql_query( $update_query ,$this->connection))
			{
				$this->HandleDBError("Error inserting data to the table\nquery:$update_query");
				return false;
			}        
			return true;
		}
		
		function GetUserData($key,$returnvalue)
		{
			$get_query = "SELECT * FROM $this->tablename WHERE email = '".$key."'";
			$get_result = mysql_query( $get_query ,$this->connection);
			$get_row = mysql_fetch_assoc($get_result);
			return $get_row[$returnvalue];
		}
		
		function RandomKey()
		{
			$guid = '';
			$uid = uniqid("", true);
			$data = $namespace;
			$data .= $_SERVER['REQUEST_TIME'];
			$data .= $_SERVER['HTTP_USER_AGENT'];
			$data .= $_SERVER['LOCAL_ADDR'];
			$data .= $_SERVER['LOCAL_PORT'];
			$data .= $_SERVER['REMOTE_ADDR'];
			$data .= $_SERVER['REMOTE_PORT'];
			$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
			$guid = '{' .   
				substr($hash,  0,  8) . 
				'-' .
				substr($hash,  8,  4) .
				'-' .
				substr($hash, 12,  4) .
				'-' .
				substr($hash, 16,  4) .
				'-' .
				substr($hash, 20, 12) .
				'}';
            
            return $guid;
		}
		
		function GetUniqueId()
		{
			$id = $this->RandomKey();
			$id = md5($id);
			$id = substr($id, 0, 5);
			$id = "ITRIX".$id;
			return $id;
		}
		
		function CheckWorkshopRegistration($emailaddress,$workshop)
		{
			$emailaddress = $this->SanitizeForSQL($emailaddress);
			$workshop = $this->SanitizeForSQL($workshop);
			$qry = "SELECT * FROM $workshop WHERE email='".$emailaddress."'";
			$result = mysql_query($qry,$this->connection);   
			if($result && mysql_num_rows($result) > 0)
			{
				return true;
			}
			return false;
		}
		
		function InsertIntoWorkshop(&$formvars,$workshopname)
		{
			$workshopname = $this->SanitizeForSQL($workshopname);
			$insert_query = 'INSERT INTO '.$workshopname.'(email, bank, branch, ddnumber, amount) VALUES ("'.$this->SanitizeForSQL($formvars['email']).'","' . $this->SanitizeForSQL($formvars['bank']) . '","' . $this->SanitizeForSQL($formvars['branch']) . '","' . $this->SanitizeForSQL($formvars['ddnumber']) . '","' . $this->SanitizeForSQL($formvars['amount']) . '")';      
			if(!mysql_query( $insert_query ,$this->connection))
			{
				$this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
				return false;
			}        
			return true;
		}
		
		function SaveToNormalLogin(&$formvars)
    	{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}

			if(!$this->IsFieldUnique($formvars,'email'))
			{
				$this->HandleError("This email is already registered");
				return false;
			}
       
       			if(!$this->InsertIntoNormalDB($formvars))
			{
				$this->HandleError("Inserting to Database failed!");
				return false;
			}
			
			if(!$this->SendUserWelcomeEmail($formvars))
        		{
				return false;
			}
			
			return true;
		}
		
		function InsertIntoNormalDB(&$formvars)
    	{
			$uniqueid = $this->GetUniqueId();
        	$insert_query = 'INSERT INTO '.$this->tablename.'(itrixid, name, email, password, gender) VALUES ("'.$uniqueid.'","' . $this->SanitizeForSQL($formvars['name']) . '","' . $this->SanitizeForSQL($formvars['email']) . '","' . $this->SanitizeForSQL($formvars['password']) . '","' . $this->SanitizeForSQL($formvars['gender']) . '")';      
			if(!mysql_query( $insert_query ,$this->connection))
			{
				$this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
				return false;
			}        
			return true;
		}
		
		function CheckLoginInDB(&$formvars)
		{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}       
			
			$formvars['email'] = $this->SanitizeForSQL($formvars['email']);
			$formvars['password'] = $this->SanitizeForSQL($formvars['password']);
			
			if(empty($formvars['email']))
			{
				$this->HandleError("Email Address not given");
				return false;
			}
			
			if(empty($formvars['password']))
			{
				$this->HandleError("Password empty");
				return false;
			}
			
			$qry = "SELECT * FROM ".$this->tablename." WHERE email='".$formvars['email']."' AND password='".$formvars['password']."'";
			$result = mysql_query($qry,$this->connection);
			if(!$result || mysql_num_rows($result) <= 0)
			{
				$this->HandleError("Error logging in. The username or password does not match");
				return false;
			}
			return true;
		}
		
		function GetNormalUserInformation(&$formvars)
		{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}       
			
			$formvars['email'] = $this->SanitizeForSQL($formvars['email']);
			$qry = "SELECT * FROM ".$this->tablename." WHERE email='".$formvars['email']."'";
			$result = mysql_query($qry,$this->connection);
			if(!$result || mysql_num_rows($result) <= 0)
			{
				$this->HandleError("Error logging in. The username or password does not match");
				return false;
			}
			$row = mysql_fetch_assoc($result);
			return $row;
		}
		
		function CheckIfProfileComplete(&$formvars)
		{
			if(!$this->DBLogin())
			{
				$this->HandleError("Database login failed!");
				return false;
			}       
			
			$formvars['email'] = $this->SanitizeForSQL($formvars['email']);
			$qry = "SELECT * FROM ".$this->tablename." WHERE email='".$formvars['email']."'";
			$result = mysql_query($qry,$this->connection);
			if(!$result || mysql_num_rows($result) <= 0)
			{
				$this->HandleError("Error logging in. The username or password does not match");
				return false;
			}
			$row = mysql_fetch_assoc($result);
			if($row['name'] == '' || $row['phonenumber'] == '' || $row['organisationname'] == '')
			{
				$this->HandleError("Error");
				return false;
			}
			
			return true;
		}
		
		function SendBigDataWorkshopEmail(&$user_rec)
		{
			$To=$user_rec['email'];
			$Subject = "Registration for Big Data Workshop | ITRIX 2013";
			$From = $this->GetFromAddress();        
			$Body ="<html>".
			"<head>".
			"<title>BIG DATA Workshop</title>".
			"</head>".
			"<body style=\"background-color: rgba(0,0,0,0.5);\">".
			"<img src=\"http://test.itrix2013.heliohost.org/images/logo.png\" class=\"logo\" width=\"250\" height=\"100\" style=\"position: relative; display: block; float: left; width: 250px; height: 100px; padding: 10px;\"><br>".
  			"<div style=\"float: left; width:100%; min-height: 200px; overflow: auto; background-color: white; \">".
  			"Hello ".$user_rec['name'].",<br><br>".
			"Thank you for registering with Big Data Workshop<br>".
			"Upon receipt of your DD, we will send confirmation mail.<br>".
			"<br>".
			"Regards,<br>".
			"Web Coordinator<sub>(for BIG DATA Workshop)</sub><br>".
			"</div>".
			"</body>".
			"</html>";
			$Headers = "MIME-Version: 1.0\r\n"; 
    			$Headers .= "Content-type: text/html; charset=utf-8\r\n";
			$Headers .= "From: ITRIX 2013 <$From> \r\n";
			$Headers .= "Reply-To: $From \r\n";
			$Headers .= "Return-Path: $From\r\n";
			$Headers .= "X-Mailer: PHP \r\n";
			
			if(!mail($To,$Subject,$Body,$Headers))
			{
				$this->HandleError("Failed sending user welcome email.");
				return false;
			}
			return true;
		}
		
		function SendCyberForensicsWorkshopEmail(&$user_rec)
		{
			$To=$user_rec['email'];
			$Subject = "Registration for Cyber Forensics Workshop | ITRIX 2013";
			$From = $this->GetFromAddress();        
			$Body ="<html>".
			"<head>".
			"<title>CYBER FORENSICS Workshop</title>".
			"</head>".
			"<body style=\"background-color: rgba(0,0,0,0.5);\">".
			"<img src=\"http://test.itrix2013.heliohost.org/images/logo.png\" class=\"logo\" width=\"250\" height=\"100\" style=\"position: relative; display: block; float: left; width: 250px; height: 100px; padding: 10px;\"><br>".
  			"<div style=\"float: left; width:100%; min-height: 200px; overflow: auto; background-color: white; \">".
  			"Hello ".$user_rec['name'].",<br><br>".
			"Thank you for registering with Cyber Forensics Workshop<br>".
			"Upon receipt of your DD, we will send confirmation mail.<br>".
			"<br>".
			"Regards,<br>".
			"Web Coordinator<sub>(for CYBER FORENSICS Workshop)</sub><br>".
			"</div>".
			"</body>".
			"</html>";
			$Headers = "MIME-Version: 1.0\r\n"; 
    			$Headers .= "Content-type: text/html; charset=utf-8\r\n";
			$Headers .= "From: ITRIX 2013 <$From> \r\n";
			$Headers .= "Reply-To: $From \r\n";
			$Headers .= "Return-Path: $From\r\n";
			$Headers .= "X-Mailer: PHP \r\n";
			
			if(!mail($To,$Subject,$Body,$Headers))
			{
				$this->HandleError("Failed sending user welcome email.");
				return false;
			}
			return true;
		}
		
		function SendWin8AppDevWorkshopEmail(&$user_rec)
		{
			$To=$user_rec['email'];
			$Subject = "Registration for Windows 8 App Development Workshop | ITRIX 2013";
			$From = $this->GetFromAddress();        
			$Body ="<html>".
			"<head>".
			"<title>WINDOWS 8 APP DEVELOPMENT Workshop</title>".
			"</head>".
			"<body style=\"background-color: rgba(0,0,0,0.5);\">".
			"<img src=\"http://test.itrix2013.heliohost.org/images/logo.png\" class=\"logo\" width=\"250\" height=\"100\" style=\"position: relative; display: block; float: left; width: 250px; height: 100px; padding: 10px;\"><br>".
  			"<div style=\"float: left; width:100%; min-height: 200px; overflow: auto; background-color: white; \">".
  			"Hello ".$user_rec['name'].",<br><br>".
			"Thank you for registering with Windows 8 App Development<br>".
			"Upon receipt of your DD, we will send confirmation mail.<br>".
			"<br>".
			"Regards,<br>".
			"Web Coordinator<sub>(for WINDOWS 8 APP DEVELOPMENT Workshop)</sub><br>".
			"</div>".
			"</body>".
			"</html>";
			$Headers = "MIME-Version: 1.0\r\n"; 
    			$Headers .= "Content-type: text/html; charset=utf-8\r\n";
			$Headers .= "From: ITRIX 2013 <$From> \r\n";
			$Headers .= "Reply-To: $From \r\n";
			$Headers .= "Return-Path: $From\r\n";
			$Headers .= "X-Mailer: PHP \r\n";
			
			if(!mail($To,$Subject,$Body,$Headers))
			{
				$this->HandleError("Failed sending user welcome email.");
				return false;
			}
			return true;
		}
	}
?>