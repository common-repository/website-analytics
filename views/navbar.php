<?php

echo'<div class="wrap">
		<div><img  style="float:left;margin-top:5px;" src="'.esc_html($logo_url).'"></div>
	<h1>
		miniOrange Site Analytics &nbsp;
	<a class="add-new-h2 " href="'.esc_html($profile_url).'">Account</a>
	</h1><br>
    </div>';
	
	$active_tab = sanitize_text_field(wp_unslash($_GET['page']));
		if($active_tab == 'mo_site_analytics')
		{
			$active_tab = 'mo_site_analytics';
		}
		?>

	<a class="nav-tab <?php echo ($active_tab == 'mo_site_analytics' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($dashboard_url);?>"id="page_report">Dashboard</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_logged_in_report' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($page_report_url);?>"id="page_report">Logged in User</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_user_login_status' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($user_login_status_url);?>"id="upgrade">Guest User Report</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_cmt_post_report' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($cmt_post_report_url);?>"id="upgrade">Comment Report</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_post_report' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($post_report_url);?>"id="upgrade">Post Report</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_page_count_report' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($page_count_report_url);?>"id="upgrade">Page Count</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_error_report' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($error_report_url);?>"id="upgrade">Error Report</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_site_analytics_setting' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($setting_url);?>"id="upgrade">Settings</a>

	<a class="nav-tab <?php echo ($active_tab == 'mo_site_analytics_upgrade' ? 'nav-tab-active' : '')?>" 
		href="<?php echo esc_url($upgrade_url);?>"id="upgrade">Upgrade</a>
   
<br>