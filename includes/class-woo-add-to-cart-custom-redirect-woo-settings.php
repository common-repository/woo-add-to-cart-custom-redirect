<?php
/**
 * Woo Add To Cart Custom Redirect.
 *
 * @package   Woo_Add_To_Cart_Custom_Redirect_Woo_Settings
 * @author    KungWoo
 * @license   GPL-2.0+
 * @link      http://kungwoo.com
 * @copyright 2016 KungWoo
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/

/**
 * WooCommerce Settings
 */
class Woo_Add_To_Cart_Custom_Redirect_Woo_Settings
{

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.0.0
     */
    private function __construct()
    {

        // Register WooCommerce Settings Section
        add_filter('woocommerce_get_sections_products', array($this, 'register_sections'));

        // Register WooCommerce Settings
        add_filter('woocommerce_get_settings_products', array($this, 'register_settings'), 10, 2);

        // Register WooCommerce Product Options
        add_action('woocommerce_product_options_general_product_data', array($this, 'register_product_options'));
        // Save WooCommerce Product Options
        add_action('woocommerce_process_product_meta', array($this, 'save_product_options'));

    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Add section to WooCommerce products settings page
     *
     * @since     1.0.0
     */
    public function register_sections($sections)
    {
        $sections['custom_redirect'] = __('Custom Redirect', 'woo-add-to-cart-custom-redirect');

        return $sections;
    }

    /**
     * Add WooCommerce settings
     *
     * @since     1.0.0
     */
    public function register_settings($settings, $current_section)
    {
        /**
         * Check the current section is what we want
         **/
        if ($current_section == 'custom_redirect') {
            $new_settings = array();
            // Section Title
            $new_settings[] = array(
                'id'   => 'watc_custom_redirect_title',
                'name' => __('Custom Redirect', 'woo-add-to-cart-custom-redirect'),
                'type' => 'title',
                'desc' =>
                __('Customers will be redirected to custom URL when a WooCommerce product is added to the cart.', 'woo-add-to-cart-custom-redirect') . '<br>' .
                __('You can specify custom URL for each product separately.', 'woo-add-to-cart-custom-redirect'),
            );
            $new_settings[] = array(
                'id'          => 'watc_custom_redirect_url',
                'name'        => __('Redirect on Add to Cart', 'woo-add-to-cart-custom-redirect'),
                'type'        => 'text',
                'placeholder' => 'http://',
                'desc'        => __('Enter a URL to redirect the user to after a product is added to the cart.', 'woo-add-to-cart-custom-redirect'),
                'desc_tip'    => true,
            );

            $new_settings[] = array('type' => 'sectionend', 'id' => 'custom_redirect');

            return $new_settings;

        } else {

            return $settings;
        }
    }

    /**
     * Add product settings
     *
     * @since     1.0.0
     */
    public function register_product_options()
    {
        global $post_id, $woocommerce, $post;

        echo '<div class="options_group">';

        woocommerce_wp_text_input(

            array(
                'id'          => '_watc_product_custom_redirect_url',
                'label'       => __('Redirect on Add to Cart', 'woo-add-to-cart-custom-redirect'),
                'placeholder' => 'http://',
                'desc_tip'    => 'true',
                'description' => __('Enter a URL to redirect the user to after this product is added to the cart.', 'woo-add-to-cart-custom-redirect'),
                'value'       => get_post_meta($post_id, '_watc_product_custom_redirect_url', true),
            )

        );

        echo '</div>';
    }

    /**
     * Save product settings
     *
     * @since     1.0.0
     */
    public function save_product_options($post_id)
    {

        $redirect_url = isset($_POST['_watc_product_custom_redirect_url']) ? $_POST['_watc_product_custom_redirect_url'] : '';

        update_post_meta($post_id, '_watc_product_custom_redirect_url', esc_url($redirect_url));

    }
}
