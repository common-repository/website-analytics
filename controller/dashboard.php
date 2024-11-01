<?php
	global $MositeDirName;

	include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'pluginutility.php';

	$mo_login_report  = new Mosite_Handler();
	$result 				= $mo_login_report->mosa_get_chart_transaction_report();
	$browser_chart 			= $mo_login_report->mosa_get_browser_chart_report();
	$platform_chart 		= $mo_login_report->mosa_get_platform_chart_report();
	$device_chart			= $mo_login_report->mosa_get_device_chart_report();
	$referel_page_chart		= $mo_login_report->mosa_get_referel_page_chart_report();

	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'dashboard.php';

?>
		
