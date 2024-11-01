<?php
/**
 * Plugin Name: Website Analytics
 * Description: Wordpress Webite Analytics for monitoring wordpress site. Wordpress Site Analytics shows most visited pages, browser, device and platform used.
 * Version: 2.0.1
 * Author: miniOrange
 * Author URI: https://miniorange.com
 * License: GPL2
 */
define( 'MO_SITE_ANALYTICS_VERSION', '2.0.1' );
define( 'MO_SITE_ANALYTICS_HOST_NAME', 'https://login.xecurify.com' );
	class Miniorange_site_analytics{

		function __construct()
		{
			register_activation_hook  (__FILE__	, array( $this, 'mosa_activate'));
		    add_action( 'admin_menu'		    , array( $this, 'mosa_widget_menu'));
			add_action( 'admin_enqueue_scripts'	, array( $this, 'mosa_settings_style'	));
			add_action( 'admin_enqueue_scripts'	, array( $this, 'mosa_settings_script'	  )	 );
			add_action( 'mo_site_show_message', array( $this, 'mosa_show_message' ), 1 , 2 );
			$this->mosa_includes();
            add_action( 'admin_footer', array( $this, 'mosa_feedback_request' ) );
            add_action( 'template_redirect', array( $this, 'mosa_log_404' ) );
            add_action( 'plugins_loaded', array( $this,'mosa_site_details') );
		}

		function mosa_log_404()
		{
			global $mo_MoWpsaUtility,$SiteDbQueries,$mo_site_config;
			$mo_site_config = new MoSite_Utility();
			$platform 		= PHP_OS_FAMILY;
			$userIp 		= $mo_site_config->mosa_get_client_ip();
			$url			= $mo_site_config->mosa_get_current_url();
			$user  			= wp_get_current_user();
			$username		= is_user_logged_in() ? $user->user_login : 'GUEST';
			$country 		= @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip),true);
			$country 		= $country["geoplugin_countryName"];
			$site_referel   = $url;
			$login_status	= Mosite_Constants::ERROR_404;
			$browser 		= $mo_site_config->mosa_browser();
			$device 		= $mo_site_config->mosa_device();
			$created_timestamp 	= $mo_site_config->mosa_created_time();
			$SiteDbQueries=new MoSite_DB;
			$SiteDbQueries->mosa_insert_site_detail($userIp,$username,$login_status,$url,$site_referel,$device,$browser,$platform,$country,$created_timestamp);
		} 
	function mosa_site_details()
	{
		$platform 		= PHP_OS_FAMILY;
		$mo_site_config = new MoSite_Utility();
		$ip 			= $mo_site_config->mosa_get_client_ip();
		$country 		= @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip),true);
		$country 		= $country["geoplugin_countryName"];
		$browser 		= $mo_site_config->mosa_browser();
		$device 		= $mo_site_config->mosa_device();
		$created_timestamp 	= $mo_site_config->mosa_created_time();
		$current_user   = wp_get_current_user();
		$username 		= $current_user->user_login;
		if ( is_user_logged_in() ) 
		{
		    $logged_in_user='Logged in';
		}
		else 
		{	
			$logged_in_user='Visitor';
			$username='Guest';
		}
		$site_referel = $mo_site_config->mosa_get_site_referel();
		$visited_page = $mo_site_config->mosa_get_current_url();

		global $SiteDbQueries;
		$SiteDbQueries=new MoSite_DB;
		$SiteDbQueries->mosa_insert_site_detail($ip,$username, $logged_in_user,$visited_page,$site_referel, $device,$browser,$platform,$country,$created_timestamp);
		$count=new MoSite_DB;
		$count_report=$count->mosa_get_count_transaction_report();
		$num_row=$count->mosa_get_num_row_transaction_report();
		$page_count=0;
		
		$unique_visited_page=[''];
		for($i=0;$i<$num_row;$i++)
		{
			$unique_visited_page[$i]=$count_report[$i]->visited_page;
		}
		$result1 = array_unique($unique_visited_page);
		$unique_page[]='';
		foreach ($result1 as $key => $value) {
			$result[]=$value;
		}
		$result_count = sizeof($result);
		$num_row1=$count->mosa_get_num_row1_transaction_report();
		if ($num_row1==0)
		{
			foreach ($result as $key => $value) 
			{
					global $SiteDbQueries;
					$SiteDbQueries=new MoSite_DB;
					$visit_page_count='1';
					$SiteDbQueries->mosa_insert_page_detail($value,$visit_page_count);						
			}
		}	
		else
		{
			$visit_page_count='1';
			$Total_page=$count->mosa_get_page_detail_transaction_report();
			$Total_unique_visited_page=[''];
			for($i=0;$i<$num_row1;$i++)
			{
				$Total_unique_visited_page[$i]=$Total_page[$i]->visited_page;
			}
			
				for($i=0;$i<$result_count;$i++)
				{
					if (!(in_array($result[$i],$Total_unique_visited_page))) 
					{
						$SiteDbQueries->mosa_insert_page_detail($result[$i],$visit_page_count);							
					}
				}
		}
		for($i=0;$i<$num_row;$i++)
		{
			for($j=0;$j<$num_row;$j++)
			{
				if($count_report[$i]->visited_page == $count_report[$j]->visited_page)
				{
					$page_count=$page_count+1;
					$page_link = $count_report[$j]->visited_page;

				}
			}
	 		global $SiteDbQueries;
			$SiteDbQueries=new MoSite_DB;
			$SiteDbQueries->mosa_insert_count_detail($page_link,$page_count);
			$page_count=0;
		}
	}
	function mosa_feedback_request() {
            if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
                return;
            }
            global $MositeDirName;           
            $email = get_site_option("mo2f_email");
            if(empty($email)){
                $user = wp_get_current_user();
                $email = $user->user_email;
            }
            $imagepath=plugins_url( DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR, __FILE__ );
            wp_enqueue_style( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
            wp_enqueue_script( 'utils' );
            wp_enqueue_style( 'mo_wpns_admin_plugins_page_style', plugins_url( DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR .'style_settings.css?ver=1.0.0', __FILE__ ) );
			include $MositeDirName .'views'.DIRECTORY_SEPARATOR.'feedback_form.php';
		}
	function mosa_activate(){

		    global $SiteDbQueries;
		    $SiteDbQueries=new MoSite_DB;
			$SiteDbQueries->mosa_plugin_activate();	 
	}	
	function mosa_widget_menu(){
		$menu_slug = 'mo_site_analytics';

			add_menu_page (	'Site Analytics' , 'Site Analytics' , 'activate_plugins', $menu_slug , array( $this, 'mosa_site'), plugin_dir_url(__FILE__).'includes/images/miniorange_icon.png' );
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Dashboard','administrator',$menu_slug			, array( $this, 'mosa_site'),1);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Logged in User Report','administrator','mo_logged_in_report'			, array( $this, 'mosa_site'),2);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Guest User Report','administrator','mo_user_login_status'			, array( $this, 'mosa_site'),3);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Comments','administrator','mo_cmt_post_report'			, array( $this, 'mosa_site'),4);
			add_submenu_page( $menu_slug	,'Site Analytics'	,' Posts','administrator','mo_post_report'			, array( $this, 'mosa_site'),5);
			add_submenu_page( $menu_slug	,'Site Analytics'	,' Page Count','administrator','mo_page_count_report'			, array( $this, 'mosa_site'),6);
			add_submenu_page( $menu_slug	,'Site Analytics'	,' Error Report','administrator','mo_error_report'			, array( $this, 'mosa_site'),7);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Account','administrator','mo_site_analytics_account'			, array( $this, 'mosa_site'),8);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Settings','administrator','mo_site_analytics_setting'			, array( $this, 'mosa_site'),9);
			add_submenu_page( $menu_slug	,'Site Analytics'	,'Upgrade','administrator','mo_site_analytics_upgrade'			, array( $this, 'mosa_site'),10);

	}

	function mosa_site()
	{
	include 'controller'.DIRECTORY_SEPARATOR .'main_controller.php';
	}

	function mosa_settings_style($hook){
		if(strpos($hook, 'page_mo')){
		wp_enqueue_style( 'mo_wpns_admin_settings_style'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR .'style_settings.css', __FILE__));
		
		wp_enqueue_style( 'mo_wpns_admin_settings_datatable_style'	, plugins_url('includes'.DIRECTORY_SEPARATOR .'css'.DIRECTORY_SEPARATOR.'jquery.dataTables.min.css', __FILE__));
	}
			
	}
	function mosa_settings_script($hook)
		{
				if(strpos($hook, 'page_mo')){
				wp_enqueue_script( 'mo_wpns_admin_datatable_script'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'js'.DIRECTORY_SEPARATOR .'jquery.dataTables.min.js', __FILE__ ), array('jquery'));
				wp_enqueue_script( 'mo_wpns_chart1_script'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'js'.DIRECTORY_SEPARATOR .'jsapi.js', __FILE__ ), array('jquery'));
				wp_enqueue_script( 'mo_wpns_chart2_script'			, plugins_url('includes'.DIRECTORY_SEPARATOR .'js'.DIRECTORY_SEPARATOR .'uds_api_contents.js', __FILE__ ), array('jquery'));
			}
		}

    function mosa_show_message($content,$type) 
		{
			if($type=="CUSTOM_MESSAGE")
				echo esc_html($content);
			if($type=="NOTICE")
				echo '	<div class="is-dismissible notice notice-warning"> <p>'.esc_html($content).'</p> </div>';
			if($type=="ERROR")
				echo '	<div class="notice notice-error is-dismissible"> <p>'.esc_html($content).'</p> </div>';
			if($type=="SUCCESS")
				echo '	<div class="notice notice-success"> <p>'.esc_html($content).'</p> </div>';
		}

    function mosa_includes(){
    	require('helper'.DIRECTORY_SEPARATOR .'utility.php');
    	require('helper'.DIRECTORY_SEPARATOR .'messages.php');

    	require('helper'.DIRECTORY_SEPARATOR .'curl.php');
    	require('handler'.DIRECTORY_SEPARATOR .'feedback_form.php');
    	
    }

} new Miniorange_site_analytics;
?>