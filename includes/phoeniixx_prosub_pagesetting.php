<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoen_prosub_form_action', 'phoen_prosub_form_action_form_nonce_field' ) ) {

	if(sanitize_text_field( $_POST['prosub_submit'] ) == 'Save'){
		
		$enable_plugin=isset($_POST['enable_plugin'])?$_POST['enable_plugin']:'';
		
		$enable_payment_check=isset($_POST['enable_payment_check'])?$_POST['enable_payment_check']:'';
		
		$phoen_payment_val=isset($_POST['phoen_payment_val'])?$_POST['phoen_payment_val']:'';
		
		$enable_overdue_check=isset($_POST['enable_overdue_check'])?$_POST['enable_overdue_check']:'';
		
		$phoen_overdue_val=isset($_POST['phoen_overdue_val'])?$_POST['phoen_overdue_val']:'';
		
		$enable_suspend_check=isset($_POST['enable_suspend_check'])?$_POST['enable_suspend_check']:'';
		
		$phoen_suspend_val=isset($_POST['phoen_suspend_val'])?$_POST['phoen_suspend_val']:'';
		
		$phoen_prosub_value = array(
		
			'enable_plugin'=>$enable_plugin,
			
			'enable_payment_check'=>$enable_payment_check,
			
			'phoen_payment_val'=>$phoen_payment_val,
			
			'enable_overdue_check'=>$enable_overdue_check,
			
			'phoen_overdue_val'=>$phoen_overdue_val,
			
			'enable_suspend_check'=>$enable_suspend_check,
			
			'phoen_suspend_val'=>$phoen_suspend_val,
			
			
		);
		
		update_option('phoen_prosub_value',$phoen_prosub_value);
		
	}
	
}

	$gen_settings = get_option('phoen_prosub_value');
	
	$enable_plugin=isset($gen_settings['enable_plugin'])?$gen_settings['enable_plugin']:'';
			
	
 ?>

	<div id="phoeniixx_phoe_prosub_wrap_profile-page"  class=" phoeniixx_phoe_prosub_wrap_profile_div">
	
		<style>
		.phoe_video_main {
				padding: 20px;
				text-align: center;
			}
			
			.phoe_video_main h3 {
				color: #02c277;
				font-size: 28px;
				font-weight: bolder;
				margin: 20px 0;
				text-transform: capitalize
				display: inline-block;
			}
		</style>
		
		<div class="phoe_video_main">
			<h3>How to set up plugin</h3> 
			<iframe width="800" height="360"src="https://www.youtube.com/embed/pzlWk0LKUeE" allowfullscreen></iframe>
		</div>
	
		<form method="post" id="phoeniixx_phoe_prosub_wrap_profile_form" action="" >
		
			<?php wp_nonce_field( 'phoen_prosub_form_action', 'phoen_prosub_form_action_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_phoe_prosub_wrap">
				
						<th>
						
							<label><?php _e('Enable Subscription','phoen-prosub'); ?> </label>
							
						</th>
						
						<td>
						
							<input type="checkbox"  name="enable_plugin" id="enable_plugin" value="1" <?php echo(isset($gen_settings['enable_plugin']) && $gen_settings['enable_plugin'] == '1')?'checked':'';?>>
							
						</td>
						<td></td>
						 
						
						
					</tr>
				
		
				</tbody>
				
			</table>
			
			<hr></hr>
			<h3><?php _e('Payment','phoen-prosub'); ?> </h3>
			
	<p><label><?php _e('Enable','phoen-prosub'); ?></label><span style="padding:5px;"><input name="enable_payment_check" type="checkbox"  value="1" <?php echo(isset($gen_settings['enable_payment_check']) && $gen_settings['enable_payment_check'] == '1')?'checked':'';?>></span></p>
	
	<p><label>
		<?php _e('Send E-mail before:','phoen-prosub'); ?>
	
	</label>
	
	<span><input value="<?php  echo isset($gen_settings['phoen_payment_val'])? $gen_settings['phoen_payment_val']:''; ?>" type="number" name="phoen_payment_val"><span class="phoen_label2"><?php _e('day(s) before payment due date.','phoen-prosub'); ?></span></span></p>
	
	<hr></hr><h3><?php _e('Overdue','phoen-prosub'); ?></h3>
	<p><label><?php _e('Enable','phoen-prosub'); ?></label><span style="padding:5px;"><input name="enable_overdue_check" type="checkbox" value="1" <?php echo(isset($gen_settings['enable_overdue_check']) && $gen_settings['enable_overdue_check'] == '1')?'checked':'';?>></span></p>
	<p><label><?php _e('Send E-mail till:','phoen-prosub'); ?></label><span><input value="<?php  echo isset($gen_settings['phoen_overdue_val'])? $gen_settings['phoen_overdue_val']:''; ?>" type="number" name="phoen_overdue_val"></span><span class="phoen_label2"><?php _e('day(s) after payment due date.','phoen-prosub'); ?></span></p>
	
	
	<hr></hr><h3><?php _e('Suspend','phoen-prosub'); ?></h3>
	<p><label><?php _e('Enable','phoen-prosub'); ?></label><span style="padding:5px;"><input name="enable_suspend_check" type="checkbox" value="1" <?php echo(isset($gen_settings['enable_suspend_check']) && $gen_settings['enable_suspend_check'] == '1')?'checked':'';?>></span></p>
	<p><label><?php _e('Suspend after:','phoen-prosub'); ?></label><span><input type="number" value="<?php  echo isset($gen_settings['phoen_suspend_val'])? $gen_settings['phoen_suspend_val']:''; ?>" name="phoen_suspend_val"></span><span class="phoen_label2"><?php _e('day(s) of payment if not received.','phoen-prosub'); ?></span></p>
	<hr></hr>
			<tr class="phoeniixx_phoe_prosub_wrap">
					
						<td colspan="2">
						
							<input type="submit" value="Save" name="prosub_submit" id="submit" class="button button-primary">
						
						</td>
						
					</tr>
		</form>
		
	</div>