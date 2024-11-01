<?php
	global $MositeDirName;
	include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'pluginutility.php';


	if(isset($_POST['option']) and sanitize_text_field(wp_unslash($_POST['option']))=='mosa_guest_manual_clear')
	{
		$nonce= sanitize_text_field(wp_unslash($_POST['mo_site_guest_nonce']));
		if ( ! wp_verify_nonce( $nonce, 'mo-site-guest-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }
		global $wpdb;
		$wpdb->query("DELETE FROM ".$wpdb->prefix."wpsa_user_activity WHERE login_status='Visitor' ");

	}

	$mo_login_report  = new Mosite_Handler();
	$guesttranscations = $mo_login_report->mosa_get_guest_transaction_report();
	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'user_login_status.php';

?>
		
