<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

/**
 * Form data
 */

if(isset($_POST['pccfBasicSetting']) ){
	if( isset( $_POST['pccf_setting_form_nonce_field'] ) || wp_verify_nonce( $_POST['pccf_setting_form_nonce_field'], 'pccf_setting_form_nonce' ) ){
		if(isset($_POST['pccf_setting_option']) ){
			foreach( $_POST['pccf_setting_option'] as $key => $val ){
				$setting_form_post_data[$key] = sanitize_text_field($val);
			}
			update_option( 'pccf_setting_options', $setting_form_post_data );
		}
		echo "<div class='updated notice'>".__('Settings saved successfully', PCCF_TEXT_DOMAIN )."</div>";
	}
}

$pccf_setting_options   = '';
$pccf_setting_options   = get_option('pccf_setting_options');
?>

<div id="poststuff">
	<form action="" method="post" >
		<div class="postbox">
			<h3 class="hndle"><span><?php esc_html_e('Display options', PCCF_TEXT_DOMAIN );?> </span></h3>
			<div class="inside">
				<table class="form-table">
					<tbody>

						<tr class="pccf-form-fields">
							<th>
								<label>
									<?php esc_html_e('Title field', PCCF_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="radio" name="pccf_setting_option[pccf_title]" value="1" <?php checked( $pccf_setting_options['pccf_title'], 1 ); ?> ><?php esc_html_e('Yes', PCCF_TEXT_DOMAIN );?>
								<input type="radio" name="pccf_setting_option[pccf_title]" value="0" <?php checked( $pccf_setting_options['pccf_title'], 0 ); ?> ><?php esc_html_e('No', PCCF_TEXT_DOMAIN );?>
							</td>
						</tr>

						<tr class="pccf-form-fields">
							<th>
								<label>
									<?php esc_html_e('Phone field', PCCF_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="radio" name="pccf_setting_option[pccf_phone]" value="1" <?php checked( $pccf_setting_options['pccf_phone'], 1 ); ?> ><?php esc_html_e('Yes', PCCF_TEXT_DOMAIN );?>
								<input type="radio" name="pccf_setting_option[pccf_phone]" value="0" <?php checked( $pccf_setting_options['pccf_phone'], 0 ); ?> ><?php esc_html_e('No', PCCF_TEXT_DOMAIN );?>
							</td>
						</tr>

						<tr class="pccf-form-fields">
							<th>
								<label>
									<?php esc_html_e('Country field', PCCF_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="radio" name="pccf_setting_option[pccf_country]" value="1" <?php checked( $pccf_setting_options['pccf_country'], 1 ); ?> ><?php esc_html_e('Yes', PCCF_TEXT_DOMAIN );?>
								<input type="radio" name="pccf_setting_option[pccf_country]" value="0" <?php checked( $pccf_setting_options['pccf_country'], 0 ); ?> ><?php esc_html_e('No', PCCF_TEXT_DOMAIN );?>
							</td>
						</tr>

						<tr class="pccf-form-fields">
							<th>
								<label>
									<?php esc_html_e('Rating field', PCCF_TEXT_DOMAIN );?> 
								</label>
							</th>
							<td>
								<input type="radio" name="pccf_setting_option[pccf_rating]" value="1" <?php checked( $pccf_setting_options['pccf_rating'], 1 ); ?> ><?php esc_html_e('Yes', PCCF_TEXT_DOMAIN );?>
								<input type="radio" name="pccf_setting_option[pccf_rating]" value="0" <?php checked( $pccf_setting_options['pccf_rating'], 0 ); ?> ><?php esc_html_e('No', PCCF_TEXT_DOMAIN );?>
							</td>
						</tr>
						
						<tr class="pccf-form-fields">
							<th>
								<label>
									<?php esc_html_e('Editor field', PCCF_TEXT_DOMAIN );?>
								</label>
							</th>
							<td>
								<input type="radio" name="pccf_setting_option[pccf_editor]" value="1" <?php checked( $pccf_setting_options['pccf_editor'], 1 ); ?> ><?php esc_html_e('Yes', PCCF_TEXT_DOMAIN );?>
								<input type="radio" name="pccf_setting_option[pccf_editor]" value="0" <?php checked( $pccf_setting_options['pccf_editor'], 0 ); ?> ><?php esc_html_e('No', PCCF_TEXT_DOMAIN );?>
							</td>
						</tr>
						
						<tr>
							<th></th>
							<td>
								<?php wp_nonce_field('pccf_setting_form_nonce', 'pccf_setting_form_nonce_field') ?>
								<input type="submit" name="pccfBasicSetting" class="button-primary" value="<?php esc_html_e('Save', PCCF_TEXT_DOMAIN );?>">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
