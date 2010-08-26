<?php
	//check if there are already options set, otherwise: Default

		//Check Userlevel
		if(get_option('fbcomcon_userlevel')){
			$fbcomcon_userlevel= get_option('fbcomcon_userlevel');
			$fbcomcon_userlevel_sel = 'fbcomcon_userlevel_'.$fbcomcon_userlevel.'_sel';
			$$fbcomcon_userlevel_sel = ' selected';
		}
		else{
			$fbcomcon_userlevel = "10";
		}
		//Check Comments Limit
		if(get_option('fbcomcon_comments_limit')){
			$comments_limit = get_option('fbcomcon_comments_limit');
		}
		else{
			$comments_limit = '-1';
		}
		//Check Paging Limit
		if(get_option('fbcomcon_paging_limit')){
			$paging_limit = get_option('fbcomcon_paging_limit');
		}
		else{
			$paging_limit = '10';
		}
		//Check Comments Paging
		if(get_option('fbcomcon_paging_comments')=='false'){
			$fbcomcon_paging_comments_no_sel = ' selected';
			$paging_comments = 'false';
		}
		else{
			$fbcomcon_paging_comments_yes_sel = ' selected';
			$paging_comments = 'true';
		}
		//Check Comments Count
		if(get_option('fbcomcon_comments_count')=='false'){
			$fbcomcon_comments_count_no_sel = ' selected';
			$comments_count = 'false';
		}
		else{
			$fbcomcon_comments_count_yes_sel = ' selected';
			$comments_count = 'true';
		}
		//Check Login Header
		if(get_option('fbcomcon_login_header')=='false'){
			$fbcomcon_login_header_no_sel = ' selected';
			$login_header = 'false';
		}
		else{
			$fbcomcon_login_header_yes_sel = ' selected';
			$login_header = 'true';
		}
?>