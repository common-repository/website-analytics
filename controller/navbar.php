<?php
	
	global $MositeDirName;
	$logo_url       = plugin_dir_url(dirname(__FILE__)) . 'includes'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR .'miniorange_logo.png';
	$profile_url	= add_query_arg( array('page' => 'mo_site_analytics_account'		), sanitize_text_field($_SERVER['REQUEST_URI'] ));
	$setting_url	= add_query_arg( array('page' => 'mo_site_analytics_setting'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$dashboard_url	= add_query_arg( array('page' => 'mo_site_analytics'		),sanitize_text_field( $_SERVER['REQUEST_URI']) );
	$user_login_status_url	= add_query_arg( array('page' => 'mo_user_login_status'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$page_report_url	= add_query_arg( array('page' => 'mo_logged_in_report'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$cmt_post_report_url = add_query_arg( array('page' => 'mo_cmt_post_report'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$post_report_url = add_query_arg( array('page' => 'mo_post_report'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$error_report_url = add_query_arg( array('page' => 'mo_error_report'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$page_count_report_url = add_query_arg( array('page' => 'mo_page_count_report'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	$upgrade_url	= add_query_arg( array('page' => 'mo_site_analytics_upgrade'		), sanitize_text_field($_SERVER['REQUEST_URI']) );
	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'navbar.php';
