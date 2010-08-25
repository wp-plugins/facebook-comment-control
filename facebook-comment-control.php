<?php

/*
	Plugin Name: Facebook Comment Control
	Plugin URI: http://fbcomcon.mafact.de/
	Description: If you have replaced the standart Wordpress comment feature with facebook comments, you can control all facebook-comments on your Dashboard.
	Version: 0.7
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
	/**
	 * Loading localisation
	 */
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('fbcomcon', 'wp-content/plugins/' . $plugin_dir . '/lang', $plugin_dir . '/lang');
	
	/**
	 * Include the Options Page
	 */
	include_once('fbcomcon_options.php');
	
	/**
	 * Content of Dashboard-Widget
	 */
	function fbcomcon_dashboard() {
		include_once('fbcomcon_dashboard.php');
		echo $user_ID;
	}
	 
	/**
	 * add Dashboard Widget via function wp_add_dashboard_widget()
	 */
	function fbcomcon_setup() {
		wp_add_dashboard_widget( 'fbcomcon', 'Facebook Comment Control', 'fbcomcon_dashboard' );
	}
	 
	/**
	 * use hook, to integrate new widget
	 * Adds Widget only for users equal or higher the set options
	 */
	 
	require_once(ABSPATH . WPINC . '/pluggable.php');
	global $user_level;
    get_currentuserinfo();
	
	if(!get_option('fbcomcon_userlevel')){
		$fbcomcon_userlevel = 10;
	}
	if($fbcomcon_userlevel <= $user_level || $user_level == 10){
		add_action('wp_dashboard_setup', 'fbcomcon_setup');
	}
?>
