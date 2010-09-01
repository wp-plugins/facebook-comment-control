<?php
	add_action('admin_menu', 'fbcomcon_menu');

	function fbcomcon_menu() {

	  add_options_page('Facebook Comment Control Options', 'Facebook Comment Control', 'manage_options', 'facebook-comment-control-options', 'fbcomcon_options');

	}
	

	function fbcomcon_options() {

		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
?>
		
		<div class="wrap">
			<h2><?php _e('Facebook Comment Control for Wordpress - Options','fbcomcon');?></h2>
		
			<form method="post" action="options.php">
		
				<?php wp_nonce_field('update-options'); include_once('check_options.php');?>
		
				<div id="poststuff" class="postbox">
					<h3><?php _e('General','fbcomcon');?></h3>
					<div class="inside">
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><?php _e('Facebook App-ID','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_app_id" value="<?php echo get_option('fbcomcon_app_id');?>" /></td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Facebook Secret','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_secret" value="<?php echo get_option('fbcomcon_secret');?>" /></td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Facebook Admin UID','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_admin_uid" value="<?php echo get_option('fbcomcon_admin_uid');?>" /></td>
							</tr>
						</table>
					</div>
				</div>
		
				<div id="poststuff" class="postbox">
					<h3><?php _e('Advanced Options','fbcomcon');?></h3>
					<div class="inside">
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><?php _e('Min. userlevel to see FBComCon','fbcomcon');?></th>
								<td>
									<select name="fbcomcon_userlevel" size="1">
										<option value="10"<?php echo $fbcomcon_userlevel_10_sel;?>><?php _e('Admin','fbcomcon');?></option>
										<option value="7"<?php echo $fbcomcon_userlevel_7_sel;?>><?php _e('Editor','fbcomcon');?></option>
										<option value="2"<?php echo $fbcomcon_userlevel_2_sel;?>><?php _e('Author','fbcomcon');?></option>
										<option value="1"<?php echo $fbcomcon_userlevel_1_sel;?>><?php _e('Contributor','fbcomcon');?></option>
										<option value="0"<?php echo $fbcomcon_userlevel_0_sel;?>><?php _e('Subscriber','fbcomcon');?></option>
									</select> (<?php _e('Default','fbcomcon');?>: <i><?php _e('Admin','fbcomcon');?></i>)
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Custom token (optional)','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_custom_token" value="<?php echo get_option('fbcomcon_custom_token');?>" /> (<?php _e('Default','fbcomcon');?>: <i><?php _e('empty','fbcomcon');?></i>)</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Number of comments to display','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_comments_limit" value="<?php echo $comments_limit;?>" /> (<?php _e('Default','fbcomcon');?>: <i>-1 (<?php _e('unlimited','fbcomcon');?>)</i>)</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Number of Comments per Page','fbcomcon');?></th>
								<td><input type="text" name="fbcomcon_paging_limit" value="<?php echo $paging_limit;?>" /> (<?php _e('Default','fbcomcon');?>: <i>10</i>)</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Enable Paging','fbcomcon');?></th>
								<td>
									<select name="fbcomcon_paging_comments" size="1">
										<option value="true"<?php echo $fbcomcon_paging_comments_yes_sel;?>><?php _e('Yes','fbcomcon');?></option>
										<option value="false"<?php echo $fbcomcon_paging_comments_no_sel;?>><?php _e('No','fbcomcon');?></option>
									</select> (<?php _e('Default','fbcomcon');?>: <i><?php _e('Yes','fbcomcon');?></i>)
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Show Comments Count','fbcomcon');?></th>
								<td>
									<select name="fbcomcon_comments_count" size="1">
										<option value="true"<?php echo $fbcomcon_comments_count_yes_sel;?>><?php _e('Yes','fbcomcon');?></option>
										<option value="false"<?php echo $fbcomcon_comments_count_no_sel;?>><?php _e('No','fbcomcon');?></option>
									</select> (<?php _e('Default','fbcomcon');?>: <i><?php _e('Yes','fbcomcon');?></i>)
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Show Login Header','fbcomcon');?></th>
								<td>
									<select name="fbcomcon_login_header" size="1">
										<option value="true"<?php echo $fbcomcon_login_header_yes_sel;?>><?php _e('Yes','fbcomcon');?></option>
										<option value="false"<?php echo $fbcomcon_login_header_no_sel;?>><?php _e('No','fbcomcon');?></option>
									</select> (<?php _e('Default','fbcomcon');?>: <i><?php _e('Yes','fbcomcon');?></i>)
								</td>
							</tr>
						</table>
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" 
							value="	fbcomcon_app_id,
									fbcomcon_secret,
									fbcomcon_admin_uid,
									fbcomcon_userlevel,
									fbcomcon_custom_token,
									fbcomcon_comments_limit,
									fbcomcon_paging_limit,
									fbcomcon_paging_comments,
									fbcomcon_comments_count,
									fbcomcon_login_header" 
						/>
					</div>
				</div>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes','fbcomcon') ?>" />
				</p>
			</form>
			
			<!-- PayPal Link -->
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="N6E42VW26QD66">
				<input type="image" src="<?php echo get_option( "siteurl" ).'/'.PLUGINDIR.'/facebook-comment-control/img/donate.jpg';?>" border="0" name="submit" alt="Buy me a beer">
				<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
			Plugin Homepage: <a href="http://fblico.mafact.de/">Facebook Like Count</a><br/>
			Plugin Author: <a href="http://www.facebook.com/ms.fb.ger">Marco Scheffel</a>
		</div>
	<?php } ?>