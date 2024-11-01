<?php  if ( ! defined( 'ABSPATH' ) ) exit;

	
add_action( 'init', 'phoen_prosub_create_post_type' );

function phoen_prosub_create_post_type() {
	
	
	 $labels = array(
                'name'               => _x( 'Subscriptions', 'Post Type General Name', 'phoen-prosub' ),
                'singular_name'      => _x( 'Subscription', 'Post Type Singular Name', 'phoen-prosub' ),
                'menu_name'          => __( 'Subscription', 'phoen-prosub' ),
                'parent_item_colon'  => __( 'Parent Item:', 'phoen-prosub' ),
                'all_items'          => __( 'All Subscriptions', 'phoen-prosub' ),
                'view_item'          => __( 'View Subscriptions', 'phoen-prosub' ),
                'add_new_item'       => __( 'Add New Subscription', 'phoen-prosub' ),
                'add_new'            => __( 'Add New Subscription', 'phoen-prosub' ),
                'edit_item'          => __( 'Edit Subscription', 'phoen-prosub' ),
                'update_item'        => __( 'Update Subscription', 'phoen-prosub' ),
                'search_items'       => __( 'Search Subscription', 'phoen-prosub' ),
                'not_found'          => __( 'Not found', 'phoen-prosub' ),
                'not_found_in_trash' => __( 'Not found in Trash', 'phoen-prosub' ),
				
            );

            $args = array(
                'label'               => __( 'phoen_subscription', 'phoen-prosub' ),
                'description'         => __( 'Subscription Description', 'phoen-prosub' ),
                'labels'              => $labels,
                'supports'            => array( '' ),
                'hierarchical'        => false,
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => false,
                'exclude_from_search' => true,
                'capability_type'     => 'post',
                'map_meta_cap'        => true
            );
	
	 
	
  register_post_type( 'phoen_subscription',$args);
}

	add_action("add_meta_boxes", "phoen_prosub_admin_init");
	
	
	
function phoen_prosub_admin_init(){
	  global $post;
	//print_r($post);
	
	$prod_detail=get_post_meta($post->ID);
	$id=$post->ID;
	$name='Subscriprtion ID #'.$id;
	
	
	add_meta_box("phoen_subscription_option_meta",'Subscription Action', "phoen_subscription_option", "phoen_subscription", "side", "low");
	add_meta_box("phoen_subscription_detail_meta", $name, "phoen_subscription_detail", "phoen_subscription", "normal", "high");
	add_meta_box("phoen_product_detail_meta", 'Product Detail', "phoen_product_detail", "phoen_subscription", "normal", "low");
	//add_meta_box("postcustom",'E-mail Reminders',"phoen_prosub_custom_field", "phoen_subscription", "normal","low"); 
}  

function phoen_prosub_custom_field()
{
	?> <h3>Payment</h3>
	<p><label>Enable</label><span style="padding:5px;"><input type="checkbox"></span></p>
	<p><label>Send E-mail before:</label><span><input type="text"><span  class="phoen_label2">day(s) before payment due date.</span></span></p>
	
	<hr></hr><h3>Overdue</h3>
	<p><label>Enable</label><span style="padding:5px;"><input type="checkbox"></span></p>
	<p><label>Send E-mail till:</label><span><input type="text"></span><span class="phoen_label2">day(s) after payment due date.</span></p>
	
	
	<hr></hr><h3>Suspend </h3>
	<p><label>Enable</label><span style="padding:5px;"><input type="checkbox"></span></p>
	<p><label>Suspend after:</label><span><input type="text"></span><span class="phoen_label2">day(s) of payment if not received.</span></p>
 	<hr></hr>
	<?php 
}

function phoen_subscription_option()
{
	
?>
<select>
<option>Select</option>
<option>Cancel Subscription</option>

</select>
<?php 
}





function phoen_subscription_detail(){
    global $post;
//print_r($post);
	$p=get_post($post->ID);
	$prod_detail=get_post_meta($post->ID);
	$id=$post->ID;
	//echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
	
	$order_det=get_post($prod_detail['phoen_order_id'][0]);
 		$order_det_meta=get_post_meta($prod_detail['phoen_order_id'][0]);
		
		
		$user_id=$prod_detail['user_id'][0];
	$u=get_user_by('id',$user_id);
	$ju=get_user_meta($u->ID);
	
	echo "<h4>".$ju['first_name'][0]." ".$ju['last_name'][0]. " ( ".$u->user_email." )"."</h4>";
		
		//echo time()+3*60*60;
	?>
	<div class="phoen_general_detail">
	<h3>General Details</h3>
	
	
	<p><label>Started Date:</label>
	<span><?php  
		$dd=$order_det_meta['_completed_date'][0];
		$dt = new DateTime($dd);
		$date = $dt->format('d-M-Y');
		echo $date; 
	?></span></p>
	<p>
		<label>Expired Date:</label>
		<span>
			
			
		
		<?php  
		
		
				//$gen_settings=get_post_meta( $item['product_id'], 'phoen_prosub_productbase_value', true );
				
				  $max_length =		 $prod_detail['max_length'][0];
				  $price_is_per =	 $prod_detail['price_is_per'][0];
				  
				  $length="+".$max_length." ".$price_is_per;
					$effectiveDate = strtotime($length, strtotime($order_det_meta['_completed_date'][0]));
					$effectiveDate = strftime ( '%Y-%m-%d' , $effectiveDate );
						$dt = new DateTime($effectiveDate);
					$effectiveDate = $dt->format('d-M-Y');
					echo $effectiveDate;
				
					
						
					
		
		
		?>
			
			
		</span>
	</p>
	<p><label>Payment Due date:</label><span></span></p>
	<p><label>List of paid Orders:</label><span></span></p>
	<p><label>Payment methods:</label><span><?php  echo $prod_detail['payment_method_title'][0];?></span></p>
	</div>
	
	
	
	<div class="phoen_billing_detail">
	<h3>Billing Details</h3>
		
	<p><label>Address:</label><span><?php echo $prod_detail['billing_first_name'][0]." " .$prod_detail['billing_last_name'][0].'<br/>';
	echo $prod_detail['billing_company'][0].'<br/>';
	echo $prod_detail['billing_address_1'][0]." ".$prod_detail['billing_address_2'][0].'<br/>';
	echo $prod_detail['billing_city'][0]." ".$prod_detail['billing_state'][0].'<br/>';
	echo $prod_detail['billing_postcode'][0]." ".$prod_detail['billing_country'][0].'<br/>'; ?></span></p>
	<p><label>Email:</label><span><?php echo $prod_detail['billing_email'][0]; ?></span></p>
	<p><label>phone:</label><span><?php echo $prod_detail['billing_phone'][0]; ?></span></p>
	</div>
	
	
	
	<div class="phoen_shipping_detail">
	<h3>Shipping Details</h3>
	
	
	<p><label>Address:</label><span><?php echo $prod_detail['shipping_first_name'][0]." " .$prod_detail['shipping_last_name'][0].'<br/>';
	echo $prod_detail['shipping_company'][0].'<br/>';
	echo $prod_detail['shipping_address_1'][0]." ".$prod_detail['shipping_address_2'][0].'<br/>';
	echo $prod_detail['shipping_city'][0]." ".$prod_detail['shipping_state'][0].'<br/>';
	echo $prod_detail['shipping_postcode'][0]." ".$prod_detail['shipping_country'][0].'<br/>'; ?></span></p>
	
	<p><label>Email:</label><span><?php echo $prod_detail['shipping_email'][0]; ?></span></p>
	<p><label>phone:</label><span><?php echo $prod_detail['shipping_phone'][0]; ?></span></p>
	
	</div>
	<?php 

}

function phoen_product_detail()
{
	
	global $post;
	$p=get_post($post->ID);
	$prod_detail=get_post_meta($post->ID);
	?><div class="product_subs_head"><span>Item</span><span>quantity</span><span>Total</span></div>
	<div class="product_subs_data"><span> <?php 	echo $prod_detail['product_name'][0]; ?></span>
	<span><?php echo $prod_detail['quantity'][0]; ?></span>
	<span><?php echo $prod_detail['order_currency'][0].$prod_detail['order_total'][0]; ?></span>
	</div>
	 	  
	<?php

	
	
	//print_r($prod_detail);
}

?>