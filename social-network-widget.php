<?php
/**
 * The `Social Network Widget` bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * 
 * Social Network Widget is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * @link                    https://www.mypreview.one
 * @since                   1.0.0
 * @package                 social-network-widget
 * @author                  MyPreview (Github: @mahdiyazdani, @mypreview)
 * @copyright               © 2015 - 2019 MyPreview. All Rights Reserved.
 *
 * @wordpress-plugin
 * Plugin Name:             Social Network Widget
 * Plugin URI:              https://www.mypreview.one
 * Description:             A simple widget that allows you easily add icons for the most popular social networks to your sidebar or other widget area.
 * Version:                 1.0.0
 * Author:                  MyPreview
 * Author URI:              https://www.upwork.com/o/profiles/users/_~016ad17ad3fc5cce94
 * License:                 GPL-2.0
 * License URI:             http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:             social-network-widget
 * Domain Path:             /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    wp_die();
} // End If Statement

/**
 * Gets the path to a plugin file or directory.
 * @see     https://codex.wordpress.org/Function_Reference/plugin_basename
 * @see     http://php.net/manual/en/language.constants.predefined.php
 */
$plugin_data = get_file_data( __FILE__, array( 'author_uri' => 'Author URI', 'version' => 'Version' ), 'plugin' );
define( 'SOCIAL_NETWORK_WIDGET_VERSION', $plugin_data['version'] );
define( 'SOCIAL_NETWORK_WIDGET_AUTHOR_URI', $plugin_data['author_uri'] );
define( 'SOCIAL_NETWORK_WIDGET_FILE', __FILE__ );
define( 'SOCIAL_NETWORK_WIDGET_BASENAME', basename( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME', plugin_basename( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_DIR_URL', plugin_dir_url( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_DIR_PATH', plugin_dir_path( SOCIAL_NETWORK_WIDGET_FILE ) );

if ( ! class_exists( 'Social_Network_Widget' ) ) :

    /**
     * The Woo Additional Terms - Class
     */
    final class Social_Network_Widget {

        /**
         * Instance of the class.
         * 
         * @var  object   $_instance
         */
        private static $_instance = NULL;

        /**
         * Main `Social_Network_Widget` instance
         * Ensures only one instance of `Social_Network_Widget` is loaded or can be loaded.
         *
         * @access  public
         * @return  instance
         */
        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            } // End If Statement

            return self::$_instance;

        }

        /**
         * Setup class.
         *
         * @access  protected
         * @return  void
         */
        protected function __construct() {

            add_action( 'init',                                                                         array( $this, 'textdomain' ),               10 );
            add_action( 'wp_enqueue_scripts',                                                           array( $this, 'enqueue' ),                  10 );
            add_action( 'admin_enqueue_scripts',                                                        array( $this, 'admin_enqueue' ),            10 );
            add_action( 'widgets_init',                                                                 array( $this, 'register_widget' ),          10 );
            add_filter( sprintf( 'plugin_action_links_%s', SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME ),     array( $this, 'additional_links' ),      10, 1 );

        }

        /**
         * Cloning instances of this class is forbidden.
         *
         * @access  protected
         * @return  void
         */
        protected function __clone() {

            _doing_it_wrong( __FUNCTION__, _x( 'Cloning instances of this class is forbidden.', 'clone', 'social-network-widget' ) , SOCIAL_NETWORK_WIDGET_VERSION );

        }

        /**
         * Unserializing instances of this class is forbidden.
         *
         * @access  public
         * @return  void
         */
        public function __wakeup() {

            _doing_it_wrong( __FUNCTION__, _x( 'Unserializing instances of this class is forbidden.', 'wakeup', 'social-network-widget' ) , SOCIAL_NETWORK_WIDGET_VERSION );

        }

        /**
         * Load languages file and text domains.
         * Define the internationalization functionality.
         *
         * @access  public
         * @return  void
         */
        public function textdomain() {

            load_plugin_textdomain( 'social-network-widget', FALSE, dirname( dirname( SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME ) ) . '/languages/' );

        }

        /**
         * Enqueue scripts and styles.
         * Fires when scripts and styles are enqueued.
         * 
         * @access  public
         * @return  void
         */
        public function enqueue() {

            $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG  ?  ''  :  '.min';
            wp_register_style( 'social-network-widget-style', sprintf( '%spublic/css/style%s.css', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array(), SOCIAL_NETWORK_WIDGET_VERSION, 'all' );

            // Bailout, if the widget is not displayed on the front end.
            if ( is_active_widget( FALSE, FALSE, 'social_network_widget', TRUE ) ) {
                wp_enqueue_style( 'social-network-widget-style' );
            } // End If Statement

        }

        /**
         * Enqueue scripts for admin pages.
         * 
         * @access  public
         * @return  void
         */
        public function admin_enqueue() {

            global $pagenow;

            $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG  ?  ''  :  '.min';
            wp_register_style( 'social-network-widget-style', sprintf( '%sadmin/css/style%s.css', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array( 'wp-color-picker' ), SOCIAL_NETWORK_WIDGET_VERSION, 'screen' );
            wp_register_script( 'social-network-widget-script', sprintf( '%sadmin/js/script%s.js', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), SOCIAL_NETWORK_WIDGET_VERSION, TRUE );

            // Enqueue admin scrips and styles, only in the customizer or the old widgets page.
            if ( is_customize_preview() || 'widgets.php' === $pagenow ) {
                wp_enqueue_style( 'social-network-widget-style' );
                wp_enqueue_script( 'social-network-widget-script' );
            } // End If Statement

        }

        /**
         * Registers all custom and built-in widgets right after all default 
         * WordPress widgets have been registered.
         *
         * @access  public
         * @return  void
         */
        public function register_widget() {

            require_once sprintf( '%ssocial-network-widget-register.php', SOCIAL_NETWORK_WIDGET_DIR_PATH );
            register_widget( 'Social_Network_Widget_Register' );

        }

        /**
         * Display additional links in plugins table page.
         * Filters the list of action links displayed for a specific plugin in the Plugins list table.
         *
         * @access  public
         * @param   array   $links
         * @return  array   $links
         */
        public function additional_links( $links ) {

            $plugin_links = array();
            $plugin_links[] = sprintf( _x( '%sHire Me!%s', 'plugin link', 'social-network-widget' ) , sprintf( '<a href="%s" class="button-link-delete" target="_blank" rel="noopener noreferrer nofollow" title="%s">', esc_url( SOCIAL_NETWORK_WIDGET_AUTHOR_URI ), esc_attr_x( 'Looking for help? Hire Me!', 'upsell', 'social-network-widget' ) ), '</a>' );
            $plugin_links[] = sprintf( _x( '%sSupport%s', 'plugin link', 'social-network-widget' ) , '<a href="https://wordpress.org/support/plugin/social-network-widget" target="_blank" rel="noopener noreferrer nofollow">', '</a>' );

            return array_merge( $plugin_links, $links );

        }

    }
endif;

/**
 * Returns the main instance of Social_Network_Widget to prevent the need to use globals.
 *
 * @return  object(class)   Social_Network_Widget::instance
 */
if ( ! function_exists( 'button_widget_init' ) ) :
    
    function button_widget_init() {

        return Social_Network_Widget::instance();

    }

    button_widget_init();
endif;