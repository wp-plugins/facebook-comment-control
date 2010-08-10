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
		//check if there are already options set, otherwise: Default
			if(get_option("comments_limit")){
				$comments_limit = get_option("comments_limit");
			}
			else{
				$comments_limit = '-1';
			}
				
			if(get_option("paging_limit")){
				$paging_limit = get_option("paging_limit");
			}
			else{
				$paging_limit = '10';
			}
		echo '<h3>General Options</h3>';
		echo '<table class="form-table">';
		echo '<tr valign="top">
				<th scope="row">Facebook App-ID</th>
				<td><input type="text" name="fb_app_id" value="'.get_option('fb_app_id').'" /></td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Facebook Secret</th>
				<td><input type="text" name="fb_secret" value="'.get_option('fb_secret').'" /></td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Facebook Admin UID</th>
				<td><input type="text" name="fb_admin_uid" value="'.get_option('fb_admin_uid').'" /></td>
			</tr>';
		echo '</table>';
		
		echo '<h3>Advanced Options</h3>';
		echo '<table class="form-table">';
		echo '<tr valign="top">
				<th scope="row">Custom token (optional)</th>
				<td><input type="text" name="manual_token" value="'.get_option('manual_token').'" /> (Default: <i>empty</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Number of comments to display</th>
				<td><input type="text" name="comments_limit" value="'.$comments_limit.'" /> (Default: <i>-1 (unlimited)</i>)</td>
			</tr>';
		echo '<tr valign="top">
				<th scope="row">Number of Comments per Page</th>
				<td><input type="text" name="paging_limit" value="'.$paging_limit.'" /> (Default: <i>10</i>)</td>
			</tr>';
		echo '</table>';
		echo '<input type="hidden" name="action" value="update" />';
		echo '<input type="hidden" name="page_options" value="fb_app_id,fb_secret,fb_admin_uid,manual_token,comments_limit,paging_limit" />';
		?>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
		<?php
		echo'<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="N6E42VW26QD66">
				<input type="image" src="/wp-content/plugins/facebook-comment-control/img/donate.jpg" border="0" name="submit" alt="Buy me a beer">
				<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
				</form>';
		echo '</div>';

	}
?>