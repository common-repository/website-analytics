<?php

	global $MositeDirName;
	include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'pluginutility.php';

	if(isset($_POST['option']) and sanitize_text_field(wp_unslash($_POST['option']))=='mo_wpns_manual_clear_page_count')
	{
		$nonce= sanitize_text_field(wp_unslash($_POST['mo_site_page_count_nonce']));
		if ( ! wp_verify_nonce( $nonce, 'mo-site-page-count-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }
		global $wpdb;
		$wpdb->query("DELETE FROM  wp_wpsa_page_details ");

	}

	$mo_login_report  = new Mosite_Handler();
	$page_count_transcations = $mo_login_report->mosa_get_page_count_report_transaction_report();

	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'page_count.php';
