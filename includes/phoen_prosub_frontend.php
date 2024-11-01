<?php if ( ! defined( 'ABSPATH' ) ) exit;


	function phoen_prosub_add_price_html( $price = '', $product) {
			
			$price_html='';
				
			global $product;
			
			$gen_settings=get_post_meta( $product->id, 'phoen_prosub_productbase_value', true );
			
			$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
			
			$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
			
		 if($price!='')
		 {
				if($price_is_per!=''){
					
				$price_html = __('/'.$no_days." ".$price_is_per, 'phoen-prosub');
				
				$price .=  '<span class="phoen_prosub_price-format">' . $price_html . '</span>';
				
				}
		 }
			return $price;

		}

	
		function phoen_prosub_filter_subtotal_price( $price, $values ) {
			
			global $woocommerce;
			
			$gen_settings=get_post_meta( $values['product_id'], 'phoen_prosub_productbase_value', true );
			
			$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
			
			$max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
			
			$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
			
			$subscribe =		isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';
					
			if($subscribe==1)
			{
				if($no_days=='')
				{
					$h="";
				}
				else if($no_days==1)
				{
					$h="/".$price_is_per;
				}
				else{
					$h="/".$no_days." ".$price_is_per;
				}
			}
					return "<span class='discount-info' title='$type_curr'>" .
					"<span>$price</span>" .
					"<span class='new-price' style='color:red;'>$h</span></span>";

				}
		
		

		function phoen_prosub_filter_item_price( $price, $values ) {
			  
			global $woocommerce;
			
			global $product;
			
			
			$h='';
			
			$gen_settings=get_post_meta( $values['product_id'], 'phoen_prosub_productbase_value', true );
				
			$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
				 $max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
				 $no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
					$subscribe =		isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';
					
			if($subscribe==1)
			{
			
			
			if($no_days=='')
				{
					$h="";
				}
				else if($no_days==1)
				{
					$h="/".$price_is_per;
				}
				else{
					$h="/".$no_days." ".$price_is_per;
				}
			
			}
			
			return "<span class='discount-info' title=''>" .
					"<span>$price</span>" .
					"<span class='new-price' style='color:red;'>$h</span></span>";
		
		
		} 
		
		function phoen_prosub_filter_subtotal_order_price( $price, $values, $order )
		{
			global $product;
			
			global $woocommerce;

			$amt='';
			
			$type_curr='';
			
			$curr=get_woocommerce_currency_symbol();
			
			$gen_settings=get_post_meta( $values['product_id'], 'phoen_prosub_productbase_value', true );
			
			$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
			
			$max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
				
			$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
			
			$subscribe =		isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';
					
			if($subscribe==1)
			{
			
			if($no_days=='')
				{
					$h="";
				}
				else if($no_days==1)
				{
					$h="/".$price_is_per;
				}
				else{
			$h="/".$no_days." ".$price_is_per;
				}
			}
					return "<span class='discount-info' title='$type_curr'>" .
				"<span>$price</span>" .
				"<span class='new-price' style='color:red;'> $h</span></span>";
			
						
			}
			
			
			function phoen_prosub_add_to_cart_text() {
  
				return __( 'Subscribe', 'woocommerce' );
  
			}


			function phoen_prosub_call_func_tochange_text() {
				
				global $post;
				
				$gen_settings= get_post_meta($post->ID,'phoen_prosub_productbase_value', true); 
				
				$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
				
				$max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
				
				$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
					
				$subscribe =		isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';
					
					if($subscribe==1)
					{
									
						add_filter( 'woocommerce_product_add_to_cart_text', 'phoen_prosub_add_to_cart_text',10,2 );  
						
						add_filter( 'woocommerce_product_single_add_to_cart_text', 'phoen_prosub_add_to_cart_text' );  	
			
					}
					else{
						
						remove_filter( 'woocommerce_product_add_to_cart_text', 'phoen_prosub_add_to_cart_text',10,2 );  
						
					}
				
			}
 	


		function phoen_prosub_btn_changetext()
		{
				
			add_action('woocommerce_after_shop_loop_item_title','phoen_prosub_call_func_tochange_text',1);
				
			add_action('woocommerce_single_product_summary','phoen_prosub_call_func_tochange_text',1);
		}
	
		function phoen_prosub_click_on_checkout_action( $order_id ){
			
			//get order id
			 $order = wc_get_order( $order_id );
			 
			 //get item id in order
            $order_items = $order->get_items();

            if( empty( $order_items)){
                return;
            }
				
			
			$post_data = array(
				'post_title'    => '',
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_type'     => 'phoen_subscription',
				'post_author'   => '1',
				'post_category' => 1,
				'page_template' => NULL
			);
			
			//create post as subscription
			
			$child_data=array();
			
         foreach ( $order_items as $key => $order_item  ) {

            $product_id = $order_item['product_id'];
            
			$variation_id = ( isset( $order_item['variation_id'] ) && !empty( $order_item['variation_id'] ) ) ? $order_item['variation_id'] : '';
               		
			$gen_settings= get_post_meta($product_id,'phoen_prosub_productbase_value', true); 
					
			$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
					
			$max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
					
			$no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
					
			$subscribe =		isset($gen_settings['subscribe'])?$gen_settings['subscribe']:'';
					
			if($subscribe==1)
			{
				$child_id=	wp_insert_post( $post_data, $error_obj );
			
				update_post_meta( $order_id, 'phoen_subscription', 'yes' );	
			
				update_post_meta( $order_id, 'phoen_subscription_id', $child_id );
			
					$child_data = array(
                       'product_id'             => $order_item['product_id'],
                        'variation_id'           => $variation_id,
                        'product_name'           => $order_item['name'],
                        'user_id'                => get_post_meta( $order_id, '_customer_user', true ),
                        'customer_ip_address'    => get_post_meta( $order_id, '_customer_ip_address', true ),
                        'customer_user_agent'    => get_post_meta( $order_id, '_customer_user_agent', true ),
                        'quantity'               => $order_item['qty'],
                        'phoen_order_id'               => $order_id,
                        'phoen_order_ids'              => array($order_id),
                        'order_total'            => get_post_meta( $order_id, '_order_total', true ),
                        'order_currency'         => get_post_meta( $order_id, '_order_currency', true ),
                        'prices_include_tax'     => get_post_meta( $order_id, '_prices_include_tax', true ),
                        'payment_method'         =>  get_post_meta( $order_id, '_payment_method', true ),
						'payment_method_title'   =>  get_post_meta( $order_id, '_payment_method_title', true ),
						// 'subscriptions_shippings'=> $shipping_method,
                        'line_subtotal'         => $order_item['line_subtotal'],
                        'line_total'            => $order_item['line_total'],
                        'line_subtotal_tax'     => $order_item['line_subtotal_tax'],
                        'line_tax'              => $order_item['line_tax'],
                        'line_tax_data'         => $order_item['line_tax_data'],
                        'cart_discount'         => WC()->cart->get_cart_discount_total(),
                        'cart_discount_tax'     => WC()->cart->get_cart_discount_tax_total(),
						'price_is_per'           => $price_is_per,
						'subscription_count'      => $no_days,
                        'max_length'            => $max_length,
                        'billing_first_name'     => get_post_meta( $order_id, '_billing_first_name', true ),
                        'billing_last_name'      => get_post_meta( $order_id, '_billing_last_name', true ),
                        'billing_company'        => get_post_meta( $order_id, '_billing_company', true ),
                        'billing_address_1'      => get_post_meta( $order_id, '_billing_address_1', true ),
                        'billing_address_2'      => get_post_meta( $order_id, '_billing_address_2', true ),
                        'billing_city'           => get_post_meta( $order_id, '_billing_city', true ),
                        'billing_state'          => get_post_meta( $order_id, '_billing_state', true ),
                        'billing_postcode'       => get_post_meta( $order_id, '_billing_postcode', true ),
                        'billing_country'        => get_post_meta( $order_id, '_billing_country', true ),
                        'billing_email'          => get_post_meta( $order_id, '_billing_email', true ),
                        'billing_phone'          => get_post_meta( $order_id, '_billing_phone', true ),
                        'shipping_first_name'    => get_post_meta( $order_id, '_shipping_first_name', true ),
                        'shipping_last_name'     => get_post_meta( $order_id, '_shipping_last_name', true ),
                        'shipping_company'       => get_post_meta( $order_id, '_shipping_company', true ),
                        'shipping_address_1'     => get_post_meta( $order_id, '_shipping_address_1', true ),
                        'shipping_address_2'     => get_post_meta( $order_id, '_shipping_address_2', true ),
                        'shipping_city'          => get_post_meta( $order_id, '_shipping_city', true ),
                        'shipping_state'         => get_post_meta( $order_id, '_shipping_state', true ),
                        'shipping_postcode'      => get_post_meta( $order_id, '_shipping_postcode', true ),
                        'shipping_country'       => get_post_meta( $order_id, '_shipping_country', true ),
                    );	
					
					foreach($child_data as $key=>$val)	{
						update_post_meta( $child_id,$key,$val); 
						
					}
					}
				
				 }
		}
		
		function phoen_prosub_newwoo_custom_add_to_cart( $cart_item_data ) {

				global $woocommerce;
				
				$woocommerce->cart->empty_cart();

				return $cart_item_data;
			}	
			
		$gen_settings=get_option('phoen_prosub_value');
			
		$enable_plugin= isset($gen_settings['enable_plugin'])? $gen_settings['enable_plugin']:'0'; 

		if($enable_plugin==1)
		{

		    // define the woocommerce_proceed_to_checkout callback 
  
			add_action( 'init', 'phoen_prosub_btn_changetext', 2);
	
			add_filter( 'woocommerce_cart_item_price', 'phoen_prosub_filter_item_price', 10, 2 );

			add_filter( 'woocommerce_get_price_html', 'phoen_prosub_add_price_html' , 10, 2 ); 
	
			add_filter( 'woocommerce_cart_item_subtotal', 'phoen_prosub_filter_subtotal_price' , 10, 2 );
			
			add_filter( 'woocommerce_checkout_item_subtotal', 'phoen_prosub_filter_subtotal_price' , 10, 2 ); 
			
			add_filter( 'woocommerce_order_formatted_line_subtotal', 'phoen_prosub_filter_subtotal_order_price' , 10, 3 );
			
			add_action( 'woocommerce_checkout_order_processed', 'phoen_prosub_click_on_checkout_action',  1, 1  );
			
			// allow only one product in cart
			add_filter( 'woocommerce_add_cart_item_data', 'phoen_prosub_newwoo_custom_add_to_cart' );
}
			
					
	?>