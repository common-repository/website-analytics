<?php
global $MositeDirName;
if(current_user_can( 'manage_options' )  && isset($_POST['option'])){
    switch(sanitize_text_field(wp_unslash($_POST['option'])))
	{
        case "mo_wpns_send_query":
		    mosa_handle_support_form(sanitize_email($_POST['query_email']), sanitize_text_field($_POST['query']), sanitize_text_field($_POST['query_phone']),sanitize_text_field(wp_unslash($_POST['mo_site_support_nonce'])));
		    break;
		}
	}
	$current_user 	= wp_get_current_user();
	$email 			= get_site_option("mo2f_email");
	$phone 			= get_site_option("mo_wpns_admin_phone");
	if($phone =='false')
		$phone='';
	if(empty($email))
		$email 		= $current_user->user_email;

	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'support.php';

function mosa_handle_support_form($email,$query,$phone,$nonce){
	
	if ( ! wp_verify_nonce( $nonce, 'mo-site-support-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        } 
	if( empty($email) || empty($query) )
	{
	    do_action('mo_site_show_message',Mosite_Messages::showMessage('SUPPORT_FORM_VALUES'),'SUCCESS');
		return;
	}

	if(!empty($phone) && !is_numeric($phone))
	{
		do_action('mo_site_show_message',Mosite_Messages::showMessage('INVALID_PHONE'),'SUCCESS');
		return;
	}
	$contact_us = new Mosite_URL();
	$submited = json_decode($contact_us->mosa_submit_contact_us($email, $phone, $query),true);
    if(json_last_error() == JSON_ERROR_NONE) 
	{
		do_action('mo_site_show_message',Mosite_Messages::showMessage('SUPPORT_FORM_SENT'),'SUCCESS');
		return;
	}
	do_action('mo_site_show_message',Mosite_Messages::showMessage('SUPPORT_FORM_SENT'),'SUCCESS');
}