<?

	class Utilities
	{
		public $date;
		
		public function __construct() 
		{
			$this->date = "Mon, 26 Jul 2030 05:00:00 GMT";
		}
		
		public function CacheControl($date)
		{
			header("Expires: ".$date);
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
			header("Cache-Control: no-store, no-cache, must-revalidate"); 
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
		}
		
		public function DateTime()
		{
			return date("l, d F(m) Y, H:i:s T(O)");
		}
		
		public function RedirecttoURL($url)
		{
			header('Location: '.$url.'');
		}
		
		public function GetSelfScript()
	    {
        	return htmlentities($_SERVER['PHP_SELF']);
    	}    
		
		public function getCurrentPageUrl() 
		{
  			$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  			$url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
  			$url .= $_SERVER["REQUEST_URI"];
  			return $url;
		}
		
		public function getBaseUrl()
		{
			return "http://".$_SERVER['HTTP_HOST'];
		}
		
		public function getRequestHeaders() 
		{
    			$headers = array();
    			foreach($_SERVER as $key => $value) 
    			{
        			if(strpos($key, 'HTTP_') === 0) 
        			{
            				$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
        			}
    			}
    			return $headers;
		}
		
		public function getGreetings()
		{	
			$morning = "Good Morning";
			$afternoon = "Good Afternoon";
			$evening = "Good Evening";
			$night = "Good Night";
			$offset = 0; 
	
			$greetings = "";
			$now = time() + (60 * 60 * $offset);
			if(date("G", $now) >= "5" && date("G", $now) <= "11")
			{
				$greetings = $morning;
			}
			elseif(date("G", $now) >= "12" && date("G", $now) <= "17")
			{
				$greetings = $afternoon;
			}
			elseif(date("G", $now) >= "18" && date("G", $now) <= "20")
			{
				$greetings = $evening;
			}
			else
			{
				$greetings = $night;
			}
			
			return $greetings;
		}
		
		public function GetIPAddress()
		{
			$header_checks = array(
									'HTTP_CLIENT_IP',
									'HTTP_PRAGMA',
									'HTTP_XONNECTION',
									'HTTP_CACHE_INFO',
									'HTTP_XPROXY',
									'HTTP_PROXY',
									'HTTP_PROXY_CONNECTION',
									'HTTP_VIA',
									'HTTP_X_COMING_FROM',
									'HTTP_COMING_FROM',
									'HTTP_X_FORWARDED_FOR',
									'HTTP_X_FORWARDED',
									'HTTP_X_CLUSTER_CLIENT_IP',
									'HTTP_FORWARDED_FOR',
									'HTTP_FORWARDED',
									'ZHTTP_CACHE_CONTROL',
									'REMOTE_ADDR'
								);

			foreach ($header_checks as $key)
				if (array_key_exists($key, $_SERVER) === true)
					foreach (explode(',', $_SERVER[$key]) as $ip)
					{
						$ip = trim($ip);
						if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
							return $ip;
					}
		}
	}
	
	
?>