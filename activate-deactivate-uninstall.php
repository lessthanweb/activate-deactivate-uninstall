<?php
/*
Plugin Name: Activate Deactivate Uninstall
Plugin URI: https://www.lessthanweb.com/blog/on-activation-deactivation-or-uninstall-functions
Description: lessthanweb. How To: Use Activate, Deactivate and Uninstall functions.
Version: 1.0
Author: lessthanweb.
Author URI: https://www.lessthanweb.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lessthanweb
*/

/*
Activate Deactivate Uninstall is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Activate Deactivate Uninstall is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Add Additional Fields To The User Profile. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	die();
}

//	Call the activation function with a callback to static class method
register_activation_hook( __FILE__, array( 'LTW_SecretCastle', 'activate' ) );

//	On plugin deletion
register_uninstall_hook( __FILE__, array( 'LTW_SecretCastle', 'uninstall' ) );

//	On plugin deactivation
register_deactivation_hook( __FILE__, array( 'LTW_SecretCastle', 'deactivation' ) );

/**
 * LTW_SecretCastle Class
 */
class LTW_SecretCastle {
	/**
	 * When plugin is activated, let's save something to options table.
	 *
	 * @param	void
	 * @return	boolean|void
	 * @since	1.0
	 *
	 */
	public static function activate() {
		//	First you should always check that the user who is trying to activate has the required capability.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return false;
		}
		
		//	Check nonce
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	
		check_admin_referer( 'activate-plugin_' . $plugin );
        
		//	Let's save the location of my secret castle into options table
		add_option( 'secret_castle_location', '5.884663, -162.079791' );
        
		//	You can also create new tables, set new permalinks and so on.
	}
    
	/**
	 * When plugin is uninstalled (deleted), let's clear the junk that the plugin made on activation.
	 *
	 * @param	void
	 * @return	boolean|void
	 * @since	1.0
	 *
	 */
	public static function uninstall() {
		//	First you should always check that the user who is trying to activate has the required capability.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return false;
		}
        
		//	Let's delete the option that we create on plugin activation.
		delete_option( 'secret_castle_location' );
        
		//	In uninstall function you should remove all the tables, custom options and so on if your plugin made them.
	}
    
	/**
	 * When plugin is deactivated, let's remove things like custom permalinks, flush cache...
	 *
	 * @param	void
	 * @return	boolean|void
	 * @since	1.0
	 *
	 */
	public static function deactivate() {
		//	First you should always check that the user who is trying to activate has the required capability.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return false;
		}
		
		//	Check nonce
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	
		check_admin_referer( 'deactivate-plugin_' . $plugin );
        
		//	On deactivation you should remove custom permalinks, flush cache and so on.
		//	Things that are more dynamic in nature.
	}
}