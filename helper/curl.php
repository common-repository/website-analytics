<?php

global $MositeDirName;
$MositeDirName = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;
include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'constants.php';
include $MositeDirName . 'api'.DIRECTORY_SEPARATOR.'Mosite_Api.php';

class Mosite_URL
{
       
       function mosa_submit_contact_us( $q_email, $q_phone, $query )
		{
		$current_user = wp_get_current_user();
		$url    = Mosite_Constants::HOST_NAME . "/moas/rest/customer/contact-us";
        $query = '[WordPress Site Analytics Plugin: - V '.MO_SITE_ANALYTICS_VERSION.']: ' . $query;
		$fields = array(
					'firstName'	=> $current_user->user_firstname,
					'lastName'	=> $current_user->user_lastname,
					'company' 	=> $_SERVER['SERVER_NAME'],
					'email' 	=> $q_email,
					'ccEmail'   => '2fasupport@xecurify.com',
					'phone'		=> $q_phone,
					'query'		=> $query
				);
		 $field_string = json_encode( $fields );
		$headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
		$moSite_api =  new Mosite_Api();
        $response = $moSite_api->mosa_make_curl_call( $url, $field_string );
        return $response;

	  }

    function mosa_create_customer() {

        $url = Mosite_Constants::HOST_NAME . '/moas/rest/customer/add';
        global $user;
        $user        = wp_get_current_user();
        $this->email = get_option( 'mo2f_email' );
        $this->phone = get_option( 'mo2f_user_phone');
        $password    = get_option( 'mo2f_password' );
        $company     = get_option( 'mo2f_admin_company' ) != '' ? get_option( 'mo2f_admin_company' ) : $_SERVER['SERVER_NAME'];

        $fields       = array(
            'companyName'     => $company,
            'areaOfInterest'  => 'WordPress Site Analytics Plugin',
            'productInterest' => 'WP site analytics',
            'email'           => $this->email,
            'phone'           => $this->phone,
            'password'        => $password
        );
        $field_string = json_encode( $fields );
        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $mositeApi= new Mosite_Api();
        $content = $mositeApi->mosa_make_curl_call( $url, $field_string );

        return $content;
    }
    function mosa_check_customer() {
        $url = Mosite_Constants::HOST_NAME . "/moas/rest/customer/check-if-exists";
        $email = get_option( "mo2f_email" );
        $fields = array (
            'email' => $email
        );
        $field_string = json_encode ( $fields );

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $mosite_api =  new Mosite_Api();
        $response = $mosite_api->mosa_make_curl_call( $url, $field_string );
        return $response;

    }
    function mosa_forgot_password()
    {
    
        $url         = Mosite_Constants::HOST_NAME . '/moas/rest/customer/password-reset';
        $email       = get_option('mo2f_email');
        $customerKey = get_option('mo2f_customerKey');
        $apiKey      = get_option('mo2f_api_key');
    
        $fields      = array(
                        'email' => $email
                     );
    
        $field_string        = json_encode($fields);

        // $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $authHeader  = $this->mosa_createAuthHeader($customerKey,$apiKey);
        $mositeApi= new Mosite_Api();
        $response = $mositeApi->mosa_make_curl_call( $url, $field_string,$authHeader );
        return $response;
    }
     function mosa_get_customer_key($email,$password) {
        $url      = Mosite_Constants::HOST_NAME . "/moas/rest/customer/key";
        $mosite_api =  new Mosite_Api();
        $fields       = array(
            'email'    => $email,
            'password' => $password
        );
        $field_string = json_encode( $fields );
        
        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $mosite_api =  new Mosite_Api();
        $content = $mosite_api->mosa_make_curl_call( $url, $field_string );
        return $content;
    }
	function mosa_send_email_alert($email,$phone,$message,$feedback_option){
        $url = Mosite_Constants::HOST_NAME . '/moas/api/notify/send';
        $customerKey = Mosite_Constants::DEFAULT_CUSTOMER_KEY;
        $apiKey      = Mosite_Constants::DEFAULT_API_KEY;
        $fromEmail          = 'no-reply@xecurify.com';
        
        if ($feedback_option == 'mo_site_skip_feedback') 
        {
            $subject            = "Deactivate [Skipped Feedback]: WordPress Site Analytics Plugin -". $email;
        }
        elseif ($feedback_option == 'mo_wpns_feedback') 
        {
            $subject            = "Feedback: WordPress Site Analytics Plugin -". $email;
        }
        global $user;
        $user         = wp_get_current_user();


        $query        = '[WordPress Site Analytics Plugin: ]: ' . $message;


        $content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br><br>Query :'.$query.'</div>';


        $fields = array(
            'customerKey'   => $customerKey,
            'sendEmail'     => true,
            'email'         => array(
                'customerKey'   => $customerKey,
                'fromEmail'     => $fromEmail,
                'bccEmail'      => $fromEmail,
                'fromName'      => 'Xecurify',
                'toEmail'       => '2fasupport@xecurify.com',
                'toName'        => '2fasupport@xecurify.com',
                'subject'       => $subject,
                'content'       => $content
            ),
        );
        $field_string = json_encode($fields);
        $mosite_api =  new Mosite_Api();
        $headers = $mosite_api->get_http_header_array();
        $response = $mosite_api->mosa_make_curl_call($url, $field_string,$headers);
        return $response;

    }
    private static function mosa_createAuthHeader($customerKey, $apiKey) {
        $currentTimestampInMillis = round(microtime(true) * 1000);
        $currentTimestampInMillis = number_format($currentTimestampInMillis, 0, '', '');

        $stringToHash = $customerKey . $currentTimestampInMillis . $apiKey;
        $authHeader = hash("sha512", $stringToHash);

        $header = array (
            "Content-Type: application/json",
            "Customer-Key: $customerKey",
            "Timestamp: $currentTimestampInMillis",
            "Authorization: $authHeader"
        );
        return $header;
    }



}