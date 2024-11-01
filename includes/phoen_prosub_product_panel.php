<?php if ( ! defined( 'ABSPATH' ) ) exit;

	function phoen_prosub_custom_tab_options() {
		
		global $product;
		
		global $post;
		
		$gen_settings= get_post_meta($post->ID,'phoen_prosub_productbase_value', true); 
		
		$price_is_per =	isset($gen_settings['price_is_per'])?$gen_settings['price_is_per']:'';
		 $max_length =		isset($gen_settings['max_length'])?$gen_settings['max_length']:''; 
		 $no_days =		isset($gen_settings['no_days'])?$gen_settings['no_days']:'';
		 
		  ?>

		<div id="phoeniixx_arbpw_calander_div" >
			<h3> <?php _e('SUBSCRIPTION SETTING','phoen-prosub'); ?></h3>
				<div class="phoeniixx_arbpw_calander_content_div">

					<p class="form-field _regular_price_field "><label for="_regular_price"><?php _e('Subscribe','phoen-prosub'); ?></label>
							<input type="checkbox"  name="subscribe" id="subscribe" value="1" <?php echo(isset($gen_settings['subscribe']) && $gen_settings['subscribe'] == '1')?'checked':'';?>>
						
					</p>
					
					
					<p class="form-field _regular_price_field "><label for="_regular_price"><?php _e('Price is per','phoen-prosub'); ?></label>
					<input type="number"  name="no_days" id="enable_book" value="<?php echo $no_days ;?>">
						
					<select name="price_is_per">
					<option value="Days" <?php if($price_is_per == 'Days') echo 'selected';?>>Days</option>
					
					<option value="Week" <?php if($price_is_per== 'Week') echo 'selected';?>>Week</option>
					
					</select>
					</p>
					
					
					<p class="form-field _regular_price_field "><label for="_regular_price"><?php _e('Max Length','phoen-prosub'); ?></label>
					<input type="number"  name="max_length" id="enable_book" value="<?php echo $max_length ;?>">
						
					</p>
					
						
				
				</div>
				
			</div>

		<?php	
	}

	

	
	function phoen_prosub_process_product_meta_custom_tab( $post_id ) {

	  
		$price_is_per	  = sanitize_text_field( $_POST['price_is_per'] ) ;
		$no_days	  = sanitize_text_field( $_POST['no_days'] ) ;
		 
		$max_length    = sanitize_text_field( $_POST['max_length'] ) ;
		
		 
		$subscribe    = sanitize_text_field( $_POST['subscribe'] ) ;
			
		$phoen_prosub_productbase_value	=	array(
		
								'price_is_per'=>$price_is_per,
								'no_days'=>$no_days,
								
								'max_length'=>$max_length,
								'subscribe'=>$subscribe,
								
								
															
							); 
											
												
		update_post_meta( $post_id, 'phoen_prosub_productbase_value', $phoen_prosub_productbase_value );
	
	
		
	}
	


	add_action('woocommerce_process_product_meta', 'phoen_prosub_process_product_meta_custom_tab');
	
	
	add_action( 'woocommerce_product_options_general_product_data', 'phoen_prosub_custom_tab_options', 10, 0 );
	
?>