<?php 
	global $moWpnsUtility,$MositeDirName,$SiteDbQueries;
	global $MositeDirName;

	if ( current_user_can( 'manage_options' ) and isset( $_POST['option'] ) )
	{
		$option = sanitize_text_field(wp_unslash($_POST['option']));
		switch($option)
		{
			case "mosa_register_customer":
				mosa_register_customer($_POST);			break;
			case "mosa_verify_customer":
				mosa_verify_customer($_POST);			break;
			case "mosa_cancel":
				mosa_cancel($_POST);						break;
			case "mosa_reset_password":
				mosa_reset_password($_POST); 			break;
		    case "mosa_goto_verifycustomer":
		        mosa_goto_verifycustomer($_POST);   		break;
		}
	} 

	 $user   = wp_get_current_user();
	$status = $SiteDbQueries->mosa_get_user_detail( 'mo_2factor_user_registration_status', $user->ID);
	 $mo2f_current_registration_status = get_option('mo_2factor_user_registration_status');
	if($status == 'error')	
	{
		 $mo2f_current_registration_status = get_option('mo_2factor_user_registration_status');
		 if ((get_option ( 'mosa_verify_customer' ) == 'true' || (get_option('mo2f_email') && !get_option('mo2f_customerKey'))) && $mo2f_current_registration_status == "MO_2_FACTOR_VERIFY_CUSTOMER")
		 {
		 	$admin_email = get_option('mo2f_email') ? get_option('mo2f_email') : "";		
		 	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'login.php';
		 }
		 else if (!mosa_is_customer_register()) 
		 {
		 	delete_option ( 'password_mismatch' );
		 	update_option ( 'mo_wpns_new_registration', 'true' );
	    update_option('mo_2factor_user_registration_status', 'REGISTRATION_STARTED');
	 		include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'register.php';
		 }
		else if(get_option('mo_2factor_admin_registration_status')=='MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS')
		{
			$email = get_option('mo2f_email');
			$key   = get_option('mo2f_customerKey');
			$api   = get_option('mo2f_api_key');
			$token = get_option('mo2f_customer_token');
			include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'profile.php';
		}
	}  
	else if(get_option('mo_2factor_admin_registration_status')=='MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS')
	{
		$email = get_option('mo2f_email');
		$key   = get_option('mo2f_customerKey');
		$api   = get_option('mo2f_api_key');
		$token = get_option('mo2f_customer_token');
		include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'profile.php';
	}
	else if ((get_option ( 'mosa_verify_customer' ) == 'true' || (get_option('mo2f_email') && !get_option('mo2f_customerKey'))) && $mo2f_current_registration_status == "MO_2_FACTOR_VERIFY_CUSTOMER")
		 {
		 	$admin_email = get_option('mo2f_email') ? get_option('mo2f_email') : "";		
		 	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'login.php';
		 }
	else
	{
			delete_option ( 'password_mismatch' );
			update_option ( 'mo_wpns_new_registration', 'true' );
	    update_option('mo_2factor_user_registration_status', 'REGISTRATION_STARTED');
			include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'register.php';
	}
	
	function mosa_is_customer_register() 
	{
		$email 			= get_option('mo2f_email');
		$customerKey 	= get_option('mo2f_customerKey');
		if( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) )
			return 0;
		else
			return 1;
	}

	function mosa_register_customer($post)
	{
		global $moWpnsUtility, $SiteDbQueries;
		$nonce = sanitize_text_field(wp_unslash($post['mo_site_register_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo-site-register-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        } 

		$user   				 = wp_get_current_user();
		$email 			 		 = sanitize_email($post['email']);
		$company 		 		 = sanitize_text_field($_SERVER["SERVER_NAME"]);
		$password 		 	 = sanitize_text_field($post['password']);
		$confirmPassword = sanitize_text_field($post['confirmPassword']);

		if( strlen( $password ) < 6 || strlen( $confirmPassword ) < 6)
		{
			do_action('mo_site_show_message',Mosite_Messages::showMessage('PASS_LENGTH'),'ERROR');
			return;
		}
		
		if( $password != $confirmPassword )
		{
			do_action('mo_site_show_message',Mosite_Messages::showMessage('PASS_MISMATCH'),'ERROR');
			return;
		}
		if( mosa_check_empty_or_null( $email ) || mosa_check_empty_or_null( $password ) 
			|| mosa_check_empty_or_null( $confirmPassword ) ) 
		{
			do_action('mo_site_show_message',Mosite_Messages::showMessage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 

		update_option( 'mo2f_email', $email );	
		update_option( 'mo_wpns_company'    , $company );		
		update_option( 'mo_wpns_password'   , $password );

		$customer = new Mosite_URL();
		$content  = json_decode($customer->mosa_check_customer($email), true);
		update_option('user_id', $user->ID );
		switch ($content['status'])
		{
			case 'CUSTOMER_NOT_FOUND':
			      $customerKey = json_decode($customer->mosa_create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = ''), true);
			  if(strcasecmp($customerKey['status'], 'SUCCESS') == 0) 
				{
					mosa_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
				}
				
				break;

			case 'SUCCESS':	
			{
			do_action('mo_site_show_message','User already exist. Please SIGN IN','ERROR');
			}
			break;
			default:
				mosa_get_current_customer($email,$password);
				break;
		}

	}

	function mosa_check_empty_or_null( $value )
	{
		if( ! isset( $value ) || empty( $value ) )
			return true;
		return false;
	}

   function mosa_goto_verifycustomer($post){
   	   global  $SiteDbQueries;
   	   $nonce = sanitize_text_field(wp_unslash($post['mo2f_goto_verifycustomer_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo2f-goto-verifycustomer-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }
   	   $user   = wp_get_current_user();
   	   update_option('mosa_verify_customer','true');
	   	 update_option( 'mo_2factor_user_registration_status','MO_2_FACTOR_VERIFY_CUSTOMER' );
   }

	function mosa_cancel($post)
	{

		$nonce = sanitize_text_field(wp_unslash($post['mo_site_cancel_nonce']));
         if ( ! wp_verify_nonce( $nonce, 'mo-site-cancel-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }

		$user   = wp_get_current_user();
		delete_option('mo2f_email');
		delete_option('mo_wpns_registration_status');
		delete_option('mosa_verify_customer');
		update_option('mo_2factor_user_registration_status' , '' );
	}


	function mosa_reset_password($post)
	{
		$nonce = sanitize_text_field(wp_unslash($post['mo_site_forget_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-site-forget-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        } 

		$customer = new Mosite_URL();
		$forgot_password_response = json_decode($customer->mosa_forgot_password());
		if($forgot_password_response->status == 'SUCCESS')
			do_action('mo_site_show_message',Mosite_Messages::showMessage('RESET_PASS'),'SUCCESS');
	}


	function mosa_verify_customer($post)
	{
		global $moWpnsUtility;

		$nonce = sanitize_text_field(wp_unslash($post['mo_site_login_nonce']));
		 if ( ! wp_verify_nonce( $nonce, 'mo-site-login-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        } 

		$email 	  = sanitize_email( $post['email'] );
		$password = sanitize_text_field( $post['password'] );

		if( mosa_check_empty_or_null( $email ) || mosa_check_empty_or_null( $password ) ) 
		{
			do_action('mo_site_show_message',Mosite_Messages::showMessage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 
		mosa_get_current_customer($email,$password);
	}

	function mosa_get_current_customer($email,$password)
	{
		global $SiteDbQueries;
		$user   = wp_get_current_user();
		$customer 	 = new Mosite_URL();
		$content     = $customer->mosa_get_customer_key($email, $password);
		$customerKey = json_decode($content, true);
		if(json_last_error() == JSON_ERROR_NONE) 
		{
			if($customerKey==NULL || $customerKey=='ERROR')
			do_action('mo_site_show_message','ERROR','ERROR');	
		    else
		    {
			if(isset($customerKey['phone'])){
				update_option( 'mo_wpns_admin_phone', $customerKey['phone'] );
				update_option( 'mo2f_user_phone' , $customerKey['phone']  );
			}
			update_option('mo2f_email',$email);
			mosa_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
			do_action('mo_site_show_message',Mosite_Messages::showMessage('REG_SUCCESS'),'SUCCESS');
			}
		} 
		else 
		{
			update_option('mosa_verify_customer', 'true');
			delete_option('mo_wpns_new_registration');
			do_action('mo_site_show_message',Mosite_Messages::showMessage('INVALID_CREDENTIALS'),'ERROR');
		}
	}
	
		
	function mosa_save_success_customer_config($email, $id, $apiKey, $token, $appSecret)
	{
		global $SiteDbQueries;

		$user   = wp_get_current_user();
		update_option( 'mo2f_customerKey'  , $id 		  );
		update_option( 'mo2f_api_key'       , $apiKey    );
		update_option( 'mo2f_customer_token'		 , $token 	  );
		update_option( 'mo2f_app_secret'			 , $appSecret );
		update_option( 'mo_wpns_enable_log_requests' , true 	  );
		update_option( 'mo2f_miniorange_admin', $user->ID );
		update_option( 'mo_2factor_admin_registration_status', 'MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS' );
		delete_option('mosa_verify_customer');
		delete_option('mo2f_current_registration_status');
		delete_option( 'mo_wpns_password'						  ); 	
	}