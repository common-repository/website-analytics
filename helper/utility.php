<?php  
global $flag;
$flag=1;
class MoSite_Utility
{

function mosa_get_current_url()
	{
		$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') == false) {
		   $url	   = $protocol . sanitize_text_field($_SERVER['HTTP_HOST']) .sanitize_text_field($_SERVER['REQUEST_URI']);
		   return $url;
		}
		else{
			
			return 'Admin Dashboard';
		  
		}	
	}

function mosa_get_client_ip() 
	{
		if(isset($_SERVER['REMOTE_ADDR']))
           return $_SERVER['REMOTE_ADDR'];
       else
       	   return '';
	}

	function mosa_get_site_referel()
	{	
		if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['REQUEST_URI'], 'wp-admin') == false) {
		  $referel_page = sanitize_text_field($_SERVER['HTTP_REFERER']);
			return $referel_page;
		}
		else{
			return 'Admin Dashboard';
		  
		}	
		
	}

	  function mosa_browser() 
	 {
	    $user_agent 	= sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
	    $browser        =   "Unknown Browser";
	    $browser_array  = array('/Trident/i'    =>  'Internet Explorer',
	                            '/firefox/i'    =>  'Firefox',
	                            '/safari/i'     =>  'Safari',
	                            '/chrome/i'     =>  'Chrome',
	                            '/opera/i'      =>  'Opera',
	                            '/netscape/i'   =>  'Netscape',
	                            '/maxthon/i'    =>  'Maxthon',
	                            '/konqueror/i'  =>  'Konqueror',
	                            '/mobile/i'     =>  'Handheld Browser',
	    						'/edge/i'		=>  'Microsoft Edge');

	    foreach ($browser_array as $regex => $value) 
	    { 
	        
	        if (preg_match($regex, $user_agent)) 
	        {
	            $browser    =   $value;
	        }
	    }
	    return $browser;
	 }

	 function mosa_created_time()
	 {
	 	$mt = explode(' ', microtime());
    	return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
	 }
	 function mosa_device()
	 {
		$tablet_browser = 0;
		$mobile_browser = 0;
		 
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $tablet_browser++;
		}
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $mobile_browser++;
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		    $mobile_browser++;
		} 
		$mobile_ua = strtolower(substr(sanitize_text_field($_SERVER['HTTP_USER_AGENT']), 0, 4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower(sanitize_text_field($_SERVER['HTTP_USER_AGENT'])),'opera mini') > 0) {
		    $mobile_browser++;
		    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?sanitize_text_field($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']):(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?sanitize_text_field($_SERVER['HTTP_DEVICE_STOCK_UA']):''));
		    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
		      $tablet_browser++;
		    }
		}
		 
		if ($tablet_browser > 0) {
		  
		   return 'tablet';
		}
		else if ($mobile_browser > 0) {
		   
		   return 'mobile';
		}
		else {
		   
		   return 'desktop';
		}   
		 
	 }
}

?>