<?php
	//check if there are already options set, otherwise: Default
		//Check Layout
		if(get_option('fbcomcon_layout')=='dark'){
			$dark_sel = ' selected';
		}
		else{
			$light_sel = ' selected';
		}
		//Check Lang
		if(get_option('fbcomcon_lang')){
			$fbcomcon_lang = get_option('fbcomcon_lang');
			$fbcomcon_lang_sel = $fbcomcon_lang.'_sel';
			$$fbcomcon_lang_sel = ' selected';
		}
		else{
			$fbcomcon_lang = "en_US";
			$en_US_sel = " selected";
		}
		//Check Comments Limit
		if(get_option('fbcomcon_comments_limit')){
			$comments_limit = get_option('comments_limit');
		}
		else{
			$comments_limit = '-1';
		}
		//Check Paging Limit
		if(get_option('fbcomcon_paging_limit')){
			$paging_limit = get_option('paging_limit');
		}
		else{
			$paging_limit = '10';
		}
?>