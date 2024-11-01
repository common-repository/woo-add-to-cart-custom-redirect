<?php
/**
 * @package   Woo_Add_To_Cart_Custom_Redirect
 * @author    KungWoo
 * @license   GPL-2.0+
 * @link      http://kungwoo.com
 * @copyright 2016 KungWoo
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Add To Cart Custom Redirect
 * Plugin URI:        https://kungwoo.com/plugins/woo-add-to-cart-custom-redirect
 * Description:       Redirect customers to custom URL after a WooCommerce product is added to the cart.
 * Version:           1.0.0
 * Author:            KungWoo
 * Author URI:        http://kungwoo.com
 * Text Domain:       woo-add-to-cart-custom-redirect
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/

/*----------------------------------------------------------------------------*
 * * * ATTENTION! * * *
 * FOR DEVELOPMENT ONLY
 * SHOULD BE DISABLED ON PRODUCTION
 *----------------------------------------------------------------------------*/
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
/*----------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------*
 * WooCommerce Settings
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Woo Settings ----- */
require_once plugin_dir_path(__FILE__) . 'includes/class-woo-add-to-cart-custom-redirect-woo-settings.php';

add_action('plugins_loaded', array('Woo_Add_To_Cart_Custom_Redirect_Woo_Settings', 'get_instance'));
/* ----- Module End: Woo Settings ----- */

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once plugin_dir_path(__FILE__) . 'includes/class-woo-add-to-cart-custom-redirect.php';

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook(__FILE__, array('Woo_Add_To_Cart_Custom_Redirect', 'activate'));
register_deactivation_hook(__FILE__, array('Woo_Add_To_Cart_Custom_Redirect', 'deactivate'));

add_action('plugins_loaded', array('Woo_Add_To_Cart_Custom_Redirect', 'get_instance'));

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {

    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-woo-add-to-cart-custom-redirect-admin.php';

    add_action('plugins_loaded', array('Woo_Add_To_Cart_Custom_Redirect_Admin', 'get_instance'));

}
