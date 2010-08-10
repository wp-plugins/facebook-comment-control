<?php
	//check if there are already options set, otherwise: Default
		//Check Layout
		if(get_option('fbcomcon_layout')=='dark'){
			$fbcomcon_layout_dark_sel = ' selected';
		}
		else{
			$fbcomcon_layout_light_sel = ' selected';
		}
		//Check Lang
		if(get_option('fbcomcon_lang')){
			$fbcomcon_lang = get_option('fbcomcon_lang');
			$fbcomcon_lang_sel = 'fbcomcon_lang_'.$fbcomcon_lang.'_sel';
			$$fbcomcon_lang_sel = ' selected';
		}
		else{
			$fbcomcon_lang = "en_US";
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