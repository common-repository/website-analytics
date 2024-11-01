<?php
            

	       if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
		       exit();

			delete_site_option('mosa_dbversion');
		
			global $wpdb;
	        $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}wpsa_user_activity" );
	        $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}wpsa_page_details" );


?>