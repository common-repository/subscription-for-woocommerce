<?php 

/*
** Plugin Name: Subscription For Woocommerce

** Plugin URI: http://www.phoeniixx.com/

** Description: The plugin helps you to create the subscription plan for your products.

** Version: 2.4

** Author: phoeniixx

** Text Domain:phoen-prosub

** Author URI: http://www.phoeniixx.com/

** License: GPLv2 or later

** License URI: http://www.gnu.org/licenses/gpl-2.0.html

** WC requires at least: 2.6.0

** WC tested up to: 3.9.1

**/  

if ( ! defined( 'ABSPATH' ) ) exit;
	
	
  	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		include(dirname(__FILE__).'/libs/execute-libs.php');

		define('PHOEN_PROSUBPLUGURL',plugins_url(  "/", __FILE__));
	
		define('PHOEN_PROSUBPLUGPATH',plugin_dir_path(  __FILE__));
			
		function phoe_prosub_menu_func() {
			
			add_menu_page('Phoeniixx_Product_Subs',__( 'Subscription', 'phoen-prosub' ) ,'nosuchcapability','Phoeniixx_Product_Subs',NULL, PHOEN_PROSUBPLUGURL.'assets/images/aa2.png' ,'57.1');
			
			add_submenu_page( 'Phoeniixx_Product_Subs', 'Phoeniixx_prosub_settings', 'Settings','manage_options', 'Phoeniixx_prosub_settings',  'Phoeniixx_prosub_settings_func' );
			
			add_submenu_page( 'Phoeniixx_Product_Subs', 'Phoeniixx_prosub_report', 'Reports','manage_options', 'Phoeniixx_prosub_report',  'Phoeniixx_prosub_report_func' );
			
			
		}
		register_activation_hook( __FILE__, 'phoe_prosub_activation_func');
		
		function phoe_prosub_activation_func() 	{
			
			$phoen_setting_data = get_option('phoen_prosub_value');
			
			if(empty($phoen_setting_data)){
				
				$phoen_prosub_value = array(
		
					'enable_plugin'=>1,
				
					'enable_payment_check'=>1,
			
			'phoen_payment_val'=>1,
			
			'enable_overdue_check'=>1,
			
			'phoen_overdue_val'=>1,
			
			'enable_suspend_check'=>1,
			
			'phoen_suspend_val'=>1,
				
				);
									
					update_option('phoen_prosub_value',$phoen_prosub_value);
				
			}			
				
			
		}
		add_action('admin_menu', 'phoe_prosub_menu_func');
		
		include_once(PHOEN_PROSUBPLUGPATH.'includes/phoen_subscription_panel.php');
	
		include_once(PHOEN_PROSUBPLUGPATH.'includes/phoen_cron.php');
		
		include_once(PHOEN_PROSUBPLUGPATH.'includes/phoen_prosub_product_panel.php');
		
		include_once(PHOEN_PROSUBPLUGPATH.'includes/phoen_prosub_frontend.php');
	
		function Phoeniixx_prosub_report_func(){
				
			include_once(PHOEN_PROSUBPLUGPATH.'includes/phoeniixx_prosub_admin_panel.php');
				
		}

			
		
		function phoe_prosub_enquenu_func()
		{
			
			wp_enqueue_style( 'phoen_prosub_backend_func_css', PHOEN_PROSUBPLUGURL. "assets/css/phoen_prosub_backend.css" );	
	
			
		}
			
		add_action('admin_head', 'phoe_prosub_enquenu_func');

		//setting Tab
		
		function Phoeniixx_prosub_settings_func() 	{ ?>
				
			<div id="profile-page" class="wrap">
		
				<?php
					if(isset($_GET['tab']))
						
					{
						$tab = sanitize_text_field( $_GET['tab'] );
						
					}
					else
						
					{
						
						$tab="";
						
					}
					
				?>
				<h2> <?php _e('Subscription For Woocommerce','phoen-prosub'); ?></h2>
				
				<?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>
				
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
				
					<a class="nav-tab <?php if($tab == 'phoen_prosub_setting' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Phoeniixx_prosub_settings&amp;tab=phoen_prosub_setting"><?php _e('Settings','phoen-prosub'); ?></a>
					<a class="nav-tab <?php if($tab == 'phoen_prosub_premium'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=Phoeniixx_prosub_settings&amp;tab=phoen_prosub_premium"><?php _e('Premium','phoen-prosub'); ?></a>
					
					
					
				</h2>
				
			</div>
			
			<?php
			
			if($tab == 'phoen_prosub_setting'|| $tab == ''){
				
				include_once(PHOEN_PROSUBPLUGPATH.'includes/phoeniixx_prosub_pagesetting.php');
				
			}
			
			
			if($tab == 'phoen_prosub_premium'){
				
				include_once(PHOEN_PROSUBPLUGPATH.'includes/phoeniixx_prosub_admin_premium.php');
				
			}
			
		}
		
	}else{
		
		add_action('admin_notices', 'phoen_prosub_admin_notice');

		function phoen_prosub_admin_notice() {
			
			global $current_user ;
				
				$user_id = $current_user->ID;
				
				/* Check that the user hasn't already clicked to ignore the message */
			
			if ( ! get_user_meta($user_id, 'phoen_prosub_ignore_notice') ) {
				
				echo '<div class="error"><p>'; 
				
				printf(__('Woocommerce Subscription  could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?phoen_prosub_nag_ignore=0');
				
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'phoen_prosub_nag_ignore');

		function phoen_prosub_nag_ignore() {
			
			global $current_user;
				
				$user_id = $current_user->ID;
				
				/* If user clicks to ignore the notice, add that to their user meta */
				
				if ( isset($_GET['phoen_prosub_nag_ignore']) && '0' == $_GET['phoen_prosub_nag_ignore'] ) {
					
					add_user_meta($user_id, 'phoen_prosub_ignore_notice', 'true', true);
				}
		}
		
		
	} ?>
