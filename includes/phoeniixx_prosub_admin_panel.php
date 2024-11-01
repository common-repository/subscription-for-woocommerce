<?php if ( ! defined( 'ABSPATH' ) ) exit; 

global $post;

/* $gen_settings= 	get_post_meta($post->ID,'phoen_prosub_productbase_value', true); 

$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';

$max_length =	isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 

$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';

$subscribe =	isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';

*/

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
	
?>

<div align="center"  class="phoen_rewpts_order_report_table_div"><h3><?php _e('SUBSCRIPTION DETAIL','phoen_prosub'); ?></h3></div>

<table class="wp-list-table widefat fixed striped customers">
				
	<thead>
		
		<tr class="phoen_rewpts_user_reward_point_tr">
			
			<th class=" column-customer_name " scope="col"><span><?php _e('Order Id','phoen_prosub'); ?>
				
			</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('Status','phoen_prosub'); ?>
				
			</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('Product','phoen_prosub'); ?>
				
			</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('User','phoen_prosub'); ?>
				
			</th>

			<th class=" column-customer_name " scope="col"><span><?php _e('Recurring','phoen_prosub'); ?>
				
			</th>

			<th class=" column-email" scope="col"><span><?php _e('Subscription Length','phoen_prosub'); ?>
				
			</th>

			<th class=" column-orders" scope="col"><span><?php _e('Subscriptions','phoen_prosub'); ?>
				
			</th>

		<th class=" column-spent" scope="col"><span><?php _e('Started On','phoen_prosub'); ?></th>	
		
		
			
			
			<th class=" column-spent" scope="col"><span><?php _e('Due Date','phoen_prosub'); ?></th>
			
				<th class=" column-spent" scope="col"><span><?php _e('Expired On','phoen_prosub'); ?></th>
			

		</tr>
		
	</thead>	
	
	<tbody>	
		<?php 
		global $woocommerce;
			
		$curr=get_woocommerce_currency_symbol(); // currency symbol
		
		$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
		
		$products_order = get_posts( $argsm ); 
		
		$user_detail=get_users();
						
		for($a=0;$a<count($products_order);$a++) 	{
			
				
			echo '<tr>';
				
				$products_detail=get_post_meta($products_order[$a]->ID); // PARENT order Id
					
				$products_detailmmm=get_post_meta($products_order[$a]->ID,'phoen_subscription',true); //if subscription is enabled,m value is yes
						
				$phoen_subs_id=get_post_meta( $products_order[$a]->ID , 'phoen_subscription_id', true ); //child subscription id
				
				$price_is_per=get_post_meta( $phoen_subs_id , 'price_is_per', true );// per day or month
				
				$subscription_count=get_post_meta( $phoen_subs_id , 'subscription_count', true ); // how many days or month
				
				$product_name=get_post_meta( $phoen_subs_id , 'product_name', true ); // how many days or month
				
				$dd=$products_detail['_completed_date'][0];
				
				$dt = new DateTime($dd);

				$startdate = $dt->format('Y-M-d'); //start date of subscription
				
				$billing_email=get_post_meta( $phoen_subs_id , 'billing_email', true ); // billing email where email has to send
				
				$max_length=get_post_meta( $phoen_subs_id , 'max_length', true ); // maximum no of days or month
				
				$actual_expire_length=$max_length." ".$price_is_per; // actual expiry length
				
				$dd= strtotime($actual_expire_length, strtotime($products_detail['_completed_date'][0])); // actual expiry date
				
				$dd = strftime ( '%Y-%m-%d' , $dd );
				
				$dt = new DateTime($dd);

				$date = $dt->format('Y-M-d');
					
				$user_name=get_user_meta($products_detail['_customer_user'][0]);
					
				$order = new WC_Order( $products_order[$a]->ID ); // to get items in that shop order
					
				$items = $order->get_items();
					
					if($products_detailmmm=='yes')
					{	
						
					echo '<td><a  href='.admin_url().'post.php?post='.$products_order[$a]->ID.'&action=edit>#'.$products_order[$a]->ID.'</a></td>'; //oredr number 
					
					echo  '<td>';
					
					//echo $time = current_time( $type, $gmt = 0 );
					
					$last_order_id=get_post_meta( $phoen_subs_id,'phoen_order_id',true);
			
				 $argsm    = array('post_type' => 'shop_order' );
				
				$last_order = get_post( $last_order_id, $argsm); 
				
					switch($last_order->post_status)
					{
						case 'wc-completed': echo "<div class='phoen_prosub_active'>Active</div>";
						continue;
						case 'wc-failed': echo "<div class='phoen_prosub_expire'>Expired</div>";
						continue;
						case 'wc-processing': echo "<div class='phoen_prosub_processing'>Processing</div>";
						continue;
						case 'wc-cancelled': echo "<div class='phoen_prosub_default'>Cancelled</div>";
						continue;
						case 'wc-pending': echo "<div class='phoen_prosub_default'>Pending</div>";
						continue;
						case 'wc-on-hold': echo "<div class='phoen_prosub_default'>On-hold</div>";
						continue;
						case 'wc-refunded': echo "<div class='phoen_prosub_default'>Refunded</div>";
						continue;
						
					}
					
					echo '</td>'; 
					
					echo '<td>'.$product_name .'</td>';	// product name
																
					echo '<td>'.$user_name['first_name'][0]." ".$user_name['last_name'][0].'</td>';  // customer name
					
					echo '<td>'.$curr.$products_detail['_order_total'][0].'</td>';   // order price
					
					echo '<td>'.$max_length." ".$price_is_per.'</td>';  // subscription length
					
					echo '<td>#'.$phoen_subs_id.'</td>'; // subscription id
					
					echo '<td>'.$startdate.'</td>'; // subscription started on
					
					echo '<td>';	
						
						if($products_order[$a]->post_status=="wc-completed") {
							
							$length=$phoen_overdue." day " .$max_length." ".$price_is_per;
								
							$effectiveDate = strtotime($length, strtotime($products_detail['_completed_date'][0]));
							
							$effectiveDate = strftime ( '%Y-%m-%d' , $effectiveDate );
							
							$dt = new DateTime($effectiveDate);

							$effectiveDate = $dt->format('Y-M-d');
							
							echo $effectiveDate;   // subscription payment due date
						
						}
						
					echo '</td>';	
					
					echo '<td>';	
						
						if(($products_order[$a]->post_status=="wc-completed")||($products_order[$a]->post_status=="wc-failed")	)			{
							
							$length=$phoen_suspend." day " .$max_length." ".$price_is_per;
						 
							$effectiveDate = strtotime($length, strtotime($products_detail['_completed_date'][0]));
						
							$effectiveDate = strftime ( '%Y-%m-%d' , $effectiveDate );
							
							$dt = new DateTime($effectiveDate);

							$effectiveDate = $dt->format('Y-M-d');
							
							echo $effectiveDate;   /// subscription suspend or expire date
							
						}
						
					echo '</td>';	
					
				}
				
			echo '</tr>';
							
		}
					
				?>
	</tbody>
	
	<tfoot>
					
			<tr class="phoen_rewpts_user_reward_point_tr">
			
				<th class=" column-customer_name " scope="col"><span><?php _e('Order Id','phoen_prosub'); ?>
				
			</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('Status','phoen_prosub'); ?>
				
			</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('Product','phoen_prosub'); ?>
				
		 	</th>
			<th class=" column-customer_name " scope="col"><span><?php _e('User','phoen_prosub'); ?>
				
			</th>

			<th class=" column-customer_name " scope="col"><span><?php _e('Recurring','phoen_prosub'); ?>
				
			</th>

			<th class=" column-email" scope="col"><span><?php _e('Subscription Length','phoen_prosub'); ?>
				
			</th>

			<th class=" column-orders" scope="col"><span><?php _e('Subscriptions','phoen_prosub'); ?>
				
			</th>

			<th class=" column-spent" scope="col"><span><?php _e('Started On','phoen_prosub'); ?></th>
		
			<th class=" column-spent" scope="col"><span><?php _e('Due Date','phoen_prosub'); ?></th>
			
				<th class=" column-spent" scope="col"><span><?php _e('Expired On','phoen_prosub'); ?></th>

		</tr>
		
	</thead>	
		
	</tfoot>	
</table>