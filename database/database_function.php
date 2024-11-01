<?php
class MoSite_DB{
		
function __construct(){
    global $wpdb;
    $this->sitedetails			= $wpdb->base_prefix.'wpsa_user_activity';
    $this->site_page_details	= $wpdb->base_prefix.'wpsa_page_details';
	$this->userDetailsTable    	= $wpdb->prefix . 'wpsa_user_details';
}
function mosa_plugin_activate(){
    require_once(ABSPATH . 'wp-admin'.DIRECTORY_SEPARATOR .'includes'.DIRECTORY_SEPARATOR .'upgrade.php');
    global $wpdb;
	if(!get_option('mosa_dbversion')||get_option('mosa_dbversion')<Mosite_Constants::DB_VERSION)
	{	
	    update_option('mosa_dbversion', Mosite_Constants::DB_VERSION );
		$this->mosa_generate_tables();
	}else{
		$current_db_version = get_option('mosa_dbversion');
		if($current_db_version < Mosite_Constants::DB_VERSION)
		update_option('mosa_dbversion', Mosite_Constants::DB_VERSION );
	}

}
function mosa_generate_tables(){
	global $wpdb;
	$tableName = $this->sitedetails;
	if($wpdb->get_var("show tables like '$tableName'") != $tableName){
		$sql = "CREATE TABLE " . $tableName . " (`id` int NOT NULL AUTO_INCREMENT, `ip` mediumtext NOT NULL,
		`username` mediumtext NOT NULL, `login_status` mediumtext NOT NULL , `visited_page` mediumtext NOT NULL  ,`site_referel` mediumtext NOT NULL,`device` mediumtext NOT NULL,`browser` mediumtext NOT NULL,`platform` mediumtext NOT NULL, `country` mediumtext,`created_timestamp` int NOT NULL, UNIQUE KEY id (id) );";
	    dbDelta($sql);
	}
	$tableName = $this->site_page_details;
	if($wpdb->get_var("show tables like '$tableName'") != $tableName){
		$sql = "CREATE TABLE " . $tableName . " (`id` int NOT NULL AUTO_INCREMENT, `visited_page` mediumtext NOT NULL ,`visited_page_count` int NOT NULL , UNIQUE KEY id (id) );";
	    dbDelta($sql); 
	}
}
function mosa_get_user_detail( $column_name, $user_id ) {
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '$this->userDetailsTable'")!==$this->userDetailsTable )
			return 'error';
		$user_column_detail = $wpdb->get_results(  $wpdb->prepare( "SELECT " . $column_name . " FROM " . $this->userDetailsTable . " WHERE user_id =%d" ,array($user_id) ));
		$value              = empty( $user_column_detail ) ? '' : get_object_vars( $user_column_detail[0] );
		return $value == '' ? '' : $value[ $column_name ];
}
function mosa_insert_site_detail($ip,$username,$login_status,$visited_page,$site_referel,$device,$browser,$platform,$country,$created_timestamp){
	global $wpdb;
	
	$wpdb->insert(
	    $this->sitedetails,
	    array(
	    	'ip'			=> $ip,
			'username' 		=>$username,
			'login_status' 	=>$login_status,
			'visited_page' 	=>$visited_page,
			'site_referel' 	=>$site_referel,
			'device'		=>$device,
			'browser'		=>$browser,
			'platform'		=>$platform,
			'country'		=>$country,
			'created_timestamp'=>$created_timestamp
	    ));

}


function mosa_insert_count_detail($visited_page,$visited_page_count){
	global $wpdb;
	$wpdb->query("UPDATE $this->site_page_details SET visited_page_count = $visited_page_count WHERE visited_page = '$visited_page'");
}
function mosa_insert_page_detail($visited_page,$visited_page_count)
{
	global $wpdb;
	$wpdb->insert(
	    $this->site_page_details,
	    array(
			'visited_page' =>$visited_page,
			'visited_page_count' => $visited_page_count
	    ));
}


function mosa_get_login_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT ip, username , visited_page , site_referel FROM ".$this->sitedetails." WHERE login_status='Logged in' order by id desc limit 5000" );
		}
function mosa_get_guest_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT ip, username , visited_page , site_referel FROM ".$this->sitedetails." WHERE login_status='visitor' order by id desc limit 5000" );
		}
function mosa_get_comment_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT comment_author, comment_author_email , comment_content FROM wp_comments order by comment_ID desc limit 5000" );
		}
function mosa_get_post_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT post_author, post_date , post_title, post_status, post_type, comment_count FROM wp_posts order by ID desc limit 5000" );
		}
function mosa_get_error_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT ip, username , visited_page  FROM ".$this->sitedetails." WHERE login_status='404' order by id desc limit 5000" );
		}
function mosa_get_count_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT visited_page FROM ".$this->sitedetails." order by ID desc limit 5000" );
		}
function mosa_get_page_detail_transaction_report()
		{
			global $wpdb;
			return $wpdb->get_results( "SELECT visited_page FROM ".$this->site_page_details." order by ID desc limit 5000" );
		}
function mosa_get_num_row_transaction_report()
		{
			global $wpdb;
			$wpdb->get_results( "SELECT visited_page FROM ".$this->sitedetails." order by ID desc limit 5000");
			return $wpdb->num_rows;
		}
function mosa_get_num_row1_transaction_report()
		{
			global $wpdb;
			$wpdb->get_results( "SELECT visited_page FROM ".$this->site_page_details." order by ID desc limit 5000");
			return $wpdb->num_rows;
		}
function mosa_get_page_count_report_transaction_report()
{
	global $wpdb;
			return $wpdb->get_results( "SELECT visited_page, visited_page_count FROM ".$this->site_page_details." order by ID desc limit 5000" );
}
function mosa_get_chart_transaction_report()
{
	global $wpdb;
			return $wpdb->get_results( "SELECT visited_page, visited_page_count FROM ".$this->site_page_details." order by visited_page_count desc limit 5" );
}
function mosa_get_browser_chart_report()
{
	global $wpdb;
	$row_count = $wpdb->get_results( "SELECT COUNT(browser) as data, browser FROM ".$this->sitedetails." GROUP BY browser order by browser asc limit 5" );
		return $row_count;
}
function mosa_get_platform_chart_report()
{
	global $wpdb;
	$platform_row_count = $wpdb->get_results( "SELECT COUNT(platform) as data, platform FROM ".$this->sitedetails." GROUP BY platform order by platform asc limit 5000" );
		return $platform_row_count;
}
function mosa_get_device_chart_report()
{
	global $wpdb;
	$device_row_count = $wpdb->get_results( "SELECT COUNT(device) as data, device FROM ".$this->sitedetails." GROUP BY device order by device asc limit 5000" );
		return $device_row_count;
}
function mosa_get_referel_page_chart_report()
{
	global $wpdb;
	$site_referel_row_count = $wpdb->get_results( "SELECT COUNT(site_referel) as data, site_referel FROM ".$this->sitedetails." GROUP BY site_referel order by site_referel asc limit 5" );
		return $site_referel_row_count;
}
}