<?php
/**
 * Plugin Name: Monstroid French Language Pack
 * Plugin URI: https://fxbenard.com/
 * Description: French Language Translations for Monstroid
 * Version: 1.0.0
 * Author: fxbenard
 * Author URI: https://fxbenard.com/
 * Text Domain: monstroid-french
 * Domain Path: languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright Copyright (c) 2015, FxB
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


/* Language: text domain
------------------------------------------*/

load_plugin_textdomain( 'monstroid-french', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*
 * Load my own textdomain function
 * Thanks to @grappler for his help
 */
add_action( 'after_setup_theme', 'monstroid_french_load_textdomain', 10 );
function monstroid_french_load_textdomain(){
	$domain = 'monstroid';

	if ( $loaded = load_theme_textdomain( $domain, WP_LANG_DIR . '/plugins/monstroid-french/' ) ) {
		return $loaded;
	} elseif ( $loaded = load_theme_textdomain( $domain, plugin_dir_path( __FILE__ ) . '/languages/' ) ) {
		return $loaded;
	} else {
		load_theme_textdomain( $domain, get_theme_root() . '/monstroid-child/languages/' );
	}
}

/*
 * Load CherryFramework textdomain function
 * Thanks to @grappler for his help
 */
add_action( 'after_setup_theme', 'monstroid_french_cherry_load_textdomain', 10 );
function monstroid_french_cherry_load_textdomain(){
	$domain = 'cherry';

	if ( $loaded = load_theme_textdomain( $domain, WP_LANG_DIR . '/plugins/monstroid-french/cherry' ) ) {
		return $loaded;
	} elseif ( $loaded = load_theme_textdomain( $domain, plugin_dir_path( __FILE__ ) . '/languages/cherry/' ) ) {
		return $loaded;
	} else {
		load_theme_textdomain( $domain, get_theme_root() . '/monstroid-child/languages/cherry/' );
	}
}

/*
 * Load CherryFramework textdomain function
 * Thanks to @grappler for his help
 */
add_action( 'after_setup_theme', 'cherry_data_manager_french_load_textdomain', 10 );
function cherry_data_manager_french_load_textdomain(){
	$domain = 'cherry-content-manager';

	if ( $loaded = load_textdomain( $domain, WP_LANG_DIR . '/plugins/monstroid-french/' ) ) {
		return $loaded;
	} elseif ( $loaded = load_textdomain( $domain, plugin_dir_path( __FILE__ ) . '/languages/' ) ) {
		return $loaded;
	} else {
		load_textdomain( $domain, get_theme_root() . '/monstroid-child/languages/' );
	}
}


/*
 * Load Monstroid Wizard textdomain function
 * Thanks to @grappler for his help
 */
function monstroid_load_plugin_textdomain() {
	$domains = array(
		'monstroid-wizard'
	);
	$domains = apply_filters( 'monstroid_french_text_domains', $domains );
	foreach ( $domains as $domain ) {
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		if ( $loaded = load_textdomain( $domain, WP_LANG_DIR . '/plugins/monstroid-french/' ) ) {
			return $loaded;
		} elseif ( $loaded = load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' ) ) {
			return $loaded;
		} else {
			load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/languages/' );
		}
	}
}
add_action( 'plugins_loaded', 'monstroid_load_plugin_textdomain', 0 );


// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'MONSTROID_FRENCH_STORE_URL', 'https://fxbenard.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'MONSTROID_FRENCH_ITEM_NAME', 'Monstroid French' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

if ( ! class_exists( 'MONSTROID_FRENCH_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/includes/MONSTROID_FRENCH_Plugin_Updater.php' );
}

function monstroid_french_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'monstroid_french_license_key' ) );

	// setup the updater
	$edd_updater = new MONSTROID_FRENCH_Plugin_Updater( MONSTROID_FRENCH_STORE_URL, __FILE__, array(
			'version' 	=> '1.0.0',
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => MONSTROID_FRENCH_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'fxbenard',  // author of this plugin
		)
	);

}
add_action( 'admin_init', 'monstroid_french_plugin_updater', 0 );


/************************************
* the code below is just a standard
* options page. Substitute with
* your own.
*************************************/

function monstroid_french_license_menu() {
	add_plugins_page( __( 'Monstroid French License', 'monstroid-french' ), __( 'Monstroid French License', 'monstroid-french' ), 'manage_options', 'monstroidfrench-license', 'monstroid_french_license_page' );
}
add_action( 'admin_menu', 'monstroid_french_license_menu' );

function monstroid_french_license_page() {
	$license 	= get_option( 'monstroid_french_license_key' );
	$status 	= get_option( 'monstroid_french_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e( 'Monstroid French License Options', 'monstroid-french' ); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields( 'monstroid_french_license' ); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'License Key', 'monstroid-french' ); ?>
						</th>
						<td>
							<input id="monstroid_french_license_key" name="monstroid_french_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="monstroid_french_license_key"><?php _e( 'Enter your license key', 'monstroid-french' ); ?></label>
						</td>
					</tr>
					<?php if ( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e( 'Activate License', 'monstroid-french' ); ?>
							</th>
							<td>
								<?php if ( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e( 'active', 'monstroid-french' ); ?></span>
									<?php wp_nonce_field( 'monstroid_french_nonce', 'monstroid_french_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e( 'Deactivate License', 'monstroid-french' ); ?>"/>
								<?php } else {
									wp_nonce_field( 'monstroid_french_nonce', 'monstroid_french_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e( 'Activate License', 'monstroid-french' ); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function monstroid_french_register_option() {
	// creates our settings in the options table
	register_setting( 'monstroid_french_license', 'monstroid_french_license_key', 'edd_sanitize_license' );
}
add_action( 'admin_init', 'monstroid_french_register_option' );

function edd_sanitize_license( $new ) {
	$old = get_option( 'monstroid_french_license_key' );
	if ( $old && $old != $new ) {
		delete_option( 'monstroid_french_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}



/************************************
* this illustrates how to activate
* a license key
*************************************/

function monstroid_french_activate_license() {

	// listen for our activate button to be clicked
	if ( isset( $_POST['edd_license_activate'] ) ) {

		// run a quick security check
	 	if ( ! check_admin_referer( 'monstroid_french_nonce', 'monstroid_french_nonce' ) ) {
			return; // get out if we didn't click the Activate button
		}
		// retrieve the license from the database
		$license = trim( get_option( 'monstroid_french_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( MONSTROID_FRENCH_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, MONSTROID_FRENCH_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false; }

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'monstroid_french_license_status', $license_data->license );

	}
}
add_action( 'admin_init', 'monstroid_french_activate_license' );


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function monstroid_french_deactivate_license() {

	// listen for our activate button to be clicked
	if ( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check
	 	if ( ! check_admin_referer( 'monstroid_french_nonce', 'monstroid_french_nonce' ) ) {
			return; // get out if we didn't click the Activate button
		}
		// retrieve the license from the database
		$license = trim( get_option( 'monstroid_french_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( MONSTROID_FRENCH_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, MONSTROID_FRENCH_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false; }

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if ( 'deactivated' == $license_data->license ) {
			delete_option( 'monstroid_french_license_status' ); }
	}
}
add_action( 'admin_init', 'monstroid_french_deactivate_license' );


/************************************
* this illustrates how to check if
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function monstroid_french_check_license() {

	global $wp_version;

	$license = trim( get_option( 'monstroid_french_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( MONSTROID_FRENCH_ITEM_NAME ),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, MONSTROID_FRENCH_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) ) {
		return false; }

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if ( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}
