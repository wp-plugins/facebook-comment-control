<?php

/*
	Plugin Name: Facebook Comment Control
	Plugin URI: http://fbcomcon.mafact.de/
	Description: If you have replaced the standart Wordpress comment feature with facebook comments, you can control all facebook-comments on your Dashboard.
	Version: 2.2
	Author: Marco Scheffel
	Author URI: http://www.facebook.com/ms.fb.ger
	License: GPLv2

	Copyright 2010  Marco Scheffel  (email : Marco.Scheffel@gmx.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/

/* GENERAL */

	/**
	 * Loading localisation
	 */
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('fbcomcon', 'wp-content/plugins/' . $plugin_dir . '/lang', $plugin_dir . '/lang');
	
	/**
	 * Include the Options Page
	 */
	include_once('fbcomcon_options.php');

	
/* DASHBOARD WIDGET */	

	/**
	 * Content of Dashboard-Widget
	 */
	function fbcomcon_dashboard() {
		include_once('fbcomcon_dashboard.php');
	}
	 
	/**
	 * Add Dashboard Widget via function wp_add_dashboard_widget()
	 */
	function fbcomcon_setup() {
		wp_add_dashboard_widget( 'fbcomcon', 'Facebook Comment Control', 'fbcomcon_dashboard' );
	}
	 
	/**
	 * Using hook to add all the stuff into the admin pages
	 * Adds Widget only for users equal or higher the set options
	 */
	 
	require_once(ABSPATH . WPINC . '/pluggable.php');
	global $user_level;
    get_currentuserinfo();
	
	if(get_option('fbcomcon_userlevel')){
		$fbcomcon_userlevel = get_option('fbcomcon_userlevel');
	}
	else{
		$fbcomcon_userlevel = 10;
	}
	if($fbcomcon_userlevel <= $user_level || $user_level == 10){
		add_action('wp_dashboard_setup', 'fbcomcon_setup');
	}
	/**
	 * 

	 
/* SIDEBAR WIDGET */		 
	
	/**
	 * Add Dashboard Widget via function wp_register_sidebar_widget()
	 */
	function fbcomcon_sidebar_register() {
	
		function fbcomcon_sidebar_widget($args) {
		
			extract($args);
			echo $before_widget;
			include_once('fbcomcon_widget.php');
			echo $after_widget;
			
		}
		
		wp_register_sidebar_widget( 'fbcomcon', 'Facebook Comment Control', 'fbcomcon_sidebar_widget'); 
	}
	
	/**
	 * Use hook, to integrate new sidebar widget
	 */

	add_action('init', 'fbcomcon_sidebar_register');
?>
