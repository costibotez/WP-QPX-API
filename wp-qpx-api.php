<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://costinbotez.co.uk
 * @since             1.0.0
 * @package           Wp_Qpx_Api
 *
 * @wordpress-plugin
 * Plugin Name:       WP QPX API
 * Plugin URI:        https://github.com/costibotez/WP-QPX-API
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Costin Botez
 * Author URI:        https://costinbotez.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-qpx-api
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-qpx-api-activator.php
 */
function activate_wp_qpx_api() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-qpx-api-activator.php';
	Wp_Qpx_Api_Activator::activate();
}

add_action( 'admin_notices', 'qpx_activation_notice' );
function qpx_activation_notice() {
	if(!is_plugin_active('contact-form-7/wp-contact-form-7.php')) :
    ?>
    <div class="updated notice is-dismissible">
        <p><?php _e('<strong>WP QPX API</strong> requires', 'wp-qpx-api'); ?> <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">Contact Form 7</a> <?php _e('plugin to be active!', 'wp-qpx-api'); ?> <strong><?php _e('You are awesome', 'wp-qpx-api'); ?></strong>.</p>
    </div>
    <?php endif;
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-qpx-api-deactivator.php
 */
function deactivate_wp_qpx_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-qpx-api-deactivator.php';
	Wp_Qpx_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_qpx_api' );
register_deactivation_hook( __FILE__, 'deactivate_wp_qpx_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-qpx-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_qpx_api() {
	// exit;
	$plugin = new Wp_Qpx_Api();
	$plugin->run();

}
run_wp_qpx_api();
