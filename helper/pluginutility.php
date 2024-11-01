<?php
class Mosite_Handler
{
	function mosa_get_login_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_login_transaction_report();
	}
	function mosa_get_guest_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_guest_transaction_report();
	}
	function mosa_get_comment_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_comment_transaction_report();
	}
	function mosa_get_post_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_post_transaction_report();
	}
	function mosa_get_error_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_error_transaction_report();
	}
	function mosa_get_chart_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_chart_transaction_report();
	}
	function mosa_get_page_count_report_transaction_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_page_count_report_transaction_report();
	}
	function mosa_get_browser_chart_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_browser_chart_report();
	}
	function mosa_get_platform_chart_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_platform_chart_report();
	}
	function mosa_get_device_chart_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_device_chart_report();
	}
	function mosa_get_referel_page_chart_report()
	{
		global $wpnsDbQueries;
		$wpnsDbQueries= new MoSite_DB;
		return $wpnsDbQueries->mosa_get_referel_page_chart_report();
	}
}
?>