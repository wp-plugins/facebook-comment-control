<?php
	add_action('admin_menu', 'fbcomcon_menu');

	function fbcomcon_menu() {

	  add_options_page('Facebook Comment Control Options', 'Facebook Comment Control', 'manage_options', 'facebook-comment-control-options', 'fbcomcon_options');

	}
	

	function fbcomcon_options() {

		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		echo '<div class="wrap">';
		echo '<h2>Facebook Comment Control - Options</h2>';
		echo '<form method="post" action="options.php">';
		wp_nonce_field('update-options');
		include_once('check_options.php');
		echo '<h3>General Options</h3>';
		echo '<table class="form-table">';
		echo '<tr valign="top">
				<th scope="row">Facebook App-ID</th>
				<td><input type="text" name="fbcomcon_app_id" value="'.get_option('fbcomcon_app_id').'" /></td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Facebook Secret</th>
				<td><input type="text" name="fbcomcon_secret" value="'.get_option('fbcomcon_secret').'" /></td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Facebook Admin UID</th>
				<td><input type="text" name="fbcomcon_admin_uid" value="'.get_option('fbcomcon_admin_uid').'" /></td>
			</tr>';
		echo '</table>';
		
		echo '<h3>Styling</h3>';
		echo '<table class="form-table">';
		echo '<tr valign="top">
				<th scope="row">Layout</th>
				<td><select name="fbcomcon_layout" size="1">
						<option value="light"'.$fbcomcon_layout_light_sel.'>Light Style</option>
						<option value="dark"'.$fbcomcon_layout_dark_sel.'>Dark Style</option>
					</select> (Default: <i>Light Style</i>)</td>
			</tr>';
		echo '</table>';
		
		echo '<h3>Advanced Options</h3>';
		echo '<table class="form-table">';
		echo '<tr valign="top">
				<th scope="row">Language</th>
				<td><select name="fbcomcon_lang" size="1">
						<option value="en_US"'.$fbcomcon_lang_en_US_sel.'>English</option>
						<option value="de_DE"'.$fbcomcon_lang_de_DE_sel.'>Deutsch</option>
						<option value="fr_FR"'.$fbcomcon_lang_fr_FR_sel.'>Fran&ccedil;ais</option>
						<option value="es_ES"'.$fbcomcon_lang_es_ES_sel.'>Espagnol</option>
					</select> (Default: <i>English</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Custom token (optional)</th>
				<td><input type="text" name="fbcomcon_custom_token" value="'.get_option('fbcomcon_custom_token').'" /> (Default: <i>empty</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Number of comments to display</th>
				<td><input type="text" name="fbcomcon_comments_limit" value="'.$comments_limit.'" /> (Default: <i>-1 (unlimited)</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Number of Comments per Page</th>
				<td><input type="text" name="fbcomcon_paging_limit" value="'.$paging_limit.'" /> (Default: <i>10</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Enable Paging</th>
				<td><select name="fbcomcon_paging_comments" size="1">
						<option value="true"'.$fbcomcon_paging_comments_yes_sel.'>Yes</option>
						<option value="false"'.$fbcomcon_paging_comments_no_sel.'>No</option>
					</select> (Default: <i>Yes</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Show Comments Count</th>
				<td><select name="fbcomcon_comments_count" size="1">
						<option value="true"'.$fbcomcon_comments_count_yes_sel.'>Yes</option>
						<option value="false"'.$fbcomcon_comments_count_no_sel.'>No</option>
					</select> (Default: <i>Yes</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Show Login Header</th>
				<td><select name="fbcomcon_login_header" size="1">
						<option value="true"'.$fbcomcon_login_header_yes_sel.'>Yes</option>
						<option value="false"'.$fbcomcon_login_header_no_sel.'>No</option>
					</select> (Default: <i>Yes</i>)</td>
			</tr>';
		echo '</table>';
		echo '<input type="hidden" name="action" value="update" />';
		echo '<input type="hidden" name="page_options" value="fbcomcon_app_id,fbcomcon_secret,fbcomcon_admin_uid,fbcomcon_layout,fbcomcon_lang,fbcomcon_custom_token,fbcomcon_comments_limit,fbcomcon_paging_limit,fbcomcon_paging_comments,fbcomcon_comments_count,fbcomcon_login_header" />';
		?>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		<?php
		echo'<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="N6E42VW26QD66">
				<input type="image" src="'.get_option( "siteurl" ).'/'.PLUGINDIR.'/facebook-comment-control/img/donate.jpg" border="0" name="submit" alt="Buy me a beer">
				<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
				</form>';
		echo '</div>';

	}
?>