<?php
global $MositeDirName; 
$controller = $MositeDirName . 'controller'.DIRECTORY_SEPARATOR;
include $controller . 'navbar.php';

if( isset( $_GET[ 'page' ])) {
	$page = sanitize_text_field(wp_unslash($_GET['page']));
	switch($page)
	{
		case 'mo_site_analytics':
		    include $controller . 'dashboard.php';           	break;

		case 'mo_page_count_report':
		    include $controller . 'page_count.php';           	break;
		
		case 'mo_user_login_status':
		    include $controller . 'guest_user.php';    	break;				
		
		case 'mo_cmt_post_report':
			include $controller . 'cmt_post_report.php';		break;			
		
		case 'mo_post_report':
		    include $controller . 'post_report_tab.php';		break;
		case 'mo_logged_in_report':
		    include $controller . 'logged_in_user_report.php';	break;
		case 'mo_error_report':
			include $controller . 'error_report.php';	  		break;	
		case 'mo_site_analytics_account':
			include $controller . 'account.php';	  			break;	
		case 'mo_site_analytics_upgrade':
			include $controller . 'upgrade.php';	  			break;
		case 'mo_site_analytics_setting':
			include $controller . 'setting.php';	  			break;
	}
}

include $controller . 'support.php';