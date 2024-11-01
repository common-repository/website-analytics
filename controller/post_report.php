<?php

	global $MositeDirName;
	include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'pluginutility.php';


	$mo_login_report  = new Mosite_Handler();
	$posttranscations = $mo_login_report->mosa_get_post_transaction_report();
	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'post_report.php';
