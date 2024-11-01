<?php

	global $MositeDirName;
	include $MositeDirName . 'helper'.DIRECTORY_SEPARATOR.'pluginutility.php';


	$mo_login_report  = new Mosite_Handler();
	$commenttranscations = $mo_login_report->mosa_get_comment_transaction_report();

	include $MositeDirName . 'views'.DIRECTORY_SEPARATOR.'cmt_post_report.php';
