<?php if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_loaded', 'phoen_prosub_custom_cron_job' );

add_action('phoen_prosub_mail_cron_hook','phoen_prosub_send_mail');
//add_action('wp_loaded','phoen_prosub_send_mail');

function phoen_prosub_custom_cron_job() {
 
if ( ! wp_next_scheduled( 'phoen_prosub_mail_cron_hook' ) ) {
		
		
		wp_schedule_event( $_SERVER['REQUEST_TIME'], 'daily', 'phoen_prosub_mail_cron_hook' );
		
	}
}
		    
function phoen_prosub_send_mail()	{
	
	$gen_settings=get_option('phoen_prosub_value');
	
	$enable_plugin= isset($gen_settings['enable_plugin'])? $gen_settings['enable_plugin']:'0'; 
	
	$enable_payment_check= isset($gen_settings['enable_payment_check'])? $gen_settings['enable_payment_check']:'0'; 
	
	$phoen_payment_val= isset($gen_settings['phoen_payment_val'])? $gen_settings['phoen_payment_val']:'0'; 
	
	$enable_overdue_check= isset($gen_settings['enable_overdue_check'])? $gen_settings['enable_overdue_check']:'0'; 
	
	$phoen_overdue_val= isset($gen_settings['phoen_overdue_val'])? $gen_settings['phoen_overdue_val']:'0'; 
	
	$enable_suspend_check= isset($gen_settings['enable_suspend_check'])? $gen_settings['enable_suspend_check']:'0'; 
	
	$phoen_suspend_val= isset($gen_settings['phoen_suspend_val'])? $gen_settings['phoen_suspend_val']:'0'; 
	
	$phoen_payment=0;
	$phoen_overdue=0;
	$phoen_suspend=0;
	$today_is=date('Y-M-d');
	
	if($enable_payment_check=='1')
				{
					
					$phoen_payment=$phoen_payment_val;
				}
				
				
				if($enable_overdue_check=='1')
				{
						$phoen_overdue=$phoen_overdue_val;
					
				}
				
				if($enable_suspend_check=='1')
				{
					$phoen_suspend=$phoen_suspend_val;
					
				}
	
	
	
	$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
			
			$products_order = get_posts( $argsm ); 
			
		 foreach($products_order as $val) 	{
			
			$products_detail=get_post_meta($val->ID); 
			
			$phoen_subs_id=get_post_meta( $val->ID , 'phoen_subscription_id', true );
			
			$subscribe=get_post_meta( $val->ID , 'phoen_subscription', true );
			
			$price_is_per=get_post_meta( $phoen_subs_id , 'price_is_per', true );// per day or month
			
			$subscription_count=get_post_meta( $phoen_subs_id , 'subscription_count', true ); // how many days or month
			
			$billing_email=get_post_meta( $phoen_subs_id , 'billing_email', true );
			
			$max_length=get_post_meta( $phoen_subs_id , 'max_length', true ); // maximum no of days or month
			
			$actual_expire_length=$max_length." ".$price_is_per;
			
			$dd= strtotime($actual_expire_length, strtotime($products_detail['_completed_date'][0]));
			
				$dd = strftime ( '%Y-%m-%d' , $dd );
				
					$dt = new DateTime($dd);

					$date = $dt->format('Y-M-d');
					
					
			
			if($val->post_status=="wc-completed"){
				$oredrid=$val->ID;
				
				$expire_length=$phoen_suspend." day " .$max_length." ".$price_is_per;
				
				$expiredate = strtotime($expire_length, strtotime($products_detail['_completed_date'][0]));
				
				$expiredate = strftime ( '%Y-%m-%d' , $expiredate );
				
				if($subscribe=='yes'){
					
					
					$dt = new DateTime($expiredate);
					
					$expiredate = $dt->format('Y-M-d');
					
					if($today_is==$expiredate)
					{
						$subex='Expiration of Order #'.$oredrid;
						$order = new WC_Order($val->ID);
						$order->update_status('failed', '' );
						$msgex="Your subscription #".$oredrid." has expired today";
						mail($billing_email,$subex,$msgex ,$headers, '');	
					}
					
					
					
					$due_length=$phoen_overdue." day " .$max_length." ".$price_is_per;
					$duedate = strtotime($due_length, strtotime($products_detail['_completed_date'][0]));
				
					$duedate = strftime ( '%Y-%m-%d' , $duedate );
					$dt = new DateTime($duedate);
					
					$duedate = $dt->format('Y-M-d');
					
					if(($today_is>$date)&&($today_is<=$duedate))
					{
						//$msgdue='due date is'.$duedate;
						$msgdue='Your payment is pending. Please pay before '.$expiredate;
						$subdue='Payment Due of order # '.$oredrid;
						mail($billing_email,$subdue,$msgdue ,$headers, '');
					}
					
					
					
					
					 $before_due_length="-".$phoen_payment." day +" .$max_length." ".$price_is_per;
					$beforeduedate = strtotime($before_due_length, strtotime($products_detail['_completed_date'][0]));
				
					$beforeduedate = strftime ( '%Y-%m-%d' , $beforeduedate );
					$dt = new DateTime($beforeduedate);
					
					$beforeduedate = $dt->format('Y-M-d');
					
					if(($today_is<$date)&&($today_is>=$beforeduedate))
					{
						$subbefore='Payment Date of Order #'.$oredrid;
						$msgbefore='payment date is '.$date. "please pay your subscription.";
						//$msgbefore.="email starts from".$beforeduedate;
						mail($billing_email,$subbefore,$msgbefore ,$headers, '');
					}
					
					
				}
				
				
			}
		}

		
		
} 
?>