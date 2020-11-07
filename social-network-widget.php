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
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * @link                    https://www.mypreview.one
 * @since                   1.1.0
 * @package                 social-network-widget
 * @author                  MyPreview (Github: @mahdiyazdani, @mypreview)
 * @copyright               © 2015 - 2020 MyPreview. All Rights Reserved.
 *
 * @wordpress-plugin
 * Plugin Name:             Social Network Widget
 * Plugin URI:              https://www.mypreview.one
 * Description:             A simple widget that allows you easily add icons for the most popular social networks to your sidebar or other widget area.
 * Version:                 1.1.0
 * Requires at least:       WordPress 5.0
 * Requires PHP:            7.2.0
 * Author:                  MyPreview
 * Author URI:              https://mahdiyazdani.com
 * License:                 GPL-3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:             social-network-widget
 * Domain Path:             /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

/**
 * Gets the path to a plugin file or directory.
 *
 * @see     https://codex.wordpress.org/Function_Reference/plugin_basename
 * @see     http://php.net/manual/en/language.constants.predefined.php
 */
$social_network_widget_plugin_data = get_file_data(
	__FILE__,
	array(
		'author_uri' => 'Author URI',
		'version'    => 'Version',
	),
	'plugin'
);
define( 'SOCIAL_NETWORK_WIDGET_VERSION', $social_network_widget_plugin_data['version'] );
define( 'SOCIAL_NETWORK_WIDGET_AUTHOR_URI', $social_network_widget_plugin_data['author_uri'] );
define( 'SOCIAL_NETWORK_WIDGET_SLUG', 'social-network-widget' );
define( 'SOCIAL_NETWORK_WIDGET_FILE', __FILE__ );
define( 'SOCIAL_NETWORK_WIDGET_BASENAME', basename( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME', plugin_basename( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_DIR_URL', plugin_dir_url( SOCIAL_NETWORK_WIDGET_FILE ) );
define( 'SOCIAL_NETWORK_WIDGET_DIR_PATH', plugin_dir_path( SOCIAL_NETWORK_WIDGET_FILE ) );

if ( ! class_exists( 'Social_Network_Widget' ) ) :

	/**
	 * The Social Network Widget - Class
	 */
	final class Social_Network_Widget {

		/**
		 * Instance of the class.
		 *
		 * @var  object   $instance
		 */
		private static $instance = null;

		/**
		 * Main `Social_Network_Widget` instance
		 * Ensures only one instance of `Social_Network_Widget` is loaded or can be loaded.
		 *
		 * @access  public
		 * @return  instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Setup class.
		 *
		 * @access  protected
		 * @return  void
		 */
		protected function __construct() {
			add_action( 'init', array( $this, 'textdomain' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'widgets_init', array( $this, 'register_widget' ) );
			add_filter( sprintf( 'plugin_action_links_%s', SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME ), array( $this, 'additional_links' ) );
		}

		/**
		 * Cloning instances of this class is forbidden.
		 *
		 * @access  protected
		 * @return  void
		 */
		protected function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Cloning instances of this class is forbidden.', 'clone', 'social-network-widget' ), esc_html( SOCIAL_NETWORK_WIDGET_VERSION ) );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @access  public
		 * @return  void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Unserializing instances of this class is forbidden.', 'wakeup', 'social-network-widget' ), esc_html( SOCIAL_NETWORK_WIDGET_VERSION ) );
		}

		/**
		 * Load languages file and text domains.
		 * Define the internationalization functionality.
		 *
		 * @access  public
		 * @return  void
		 */
		public function textdomain() {
			load_plugin_textdomain( 'social-network-widget', false, dirname( dirname( SOCIAL_NETWORK_WIDGET_PLUGIN_BASENAME ) ) . '/languages/' );
		}

		/**
		 * Enqueue scripts and styles.
		 * Fires when scripts and styles are enqueued.
		 *
		 * @access  public
		 * @return  void
		 */
		public function enqueue() {
			$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_style( sprintf( '%s-style', SOCIAL_NETWORK_WIDGET_SLUG ), sprintf( '%sassets/public/css/style%s.css', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array(), SOCIAL_NETWORK_WIDGET_VERSION, 'all' );

			// Bail early, in case the widget is not displayed on the front end.
			if ( is_active_widget( false, false, 'social_network_widget', true ) ) {
				wp_enqueue_style( sprintf( '%s-style', SOCIAL_NETWORK_WIDGET_SLUG ) );
			}
		}

		/**
		 * Enqueue scripts for admin pages.
		 *
		 * @access  public
		 * @return  void
		 */
		public function admin_enqueue() {
			global $pagenow;

			$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_style( sprintf( '%s-style', SOCIAL_NETWORK_WIDGET_SLUG ), sprintf( '%sassets/admin/css/style%s.css', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array( 'wp-color-picker' ), SOCIAL_NETWORK_WIDGET_VERSION, 'screen' );
			wp_register_script( sprintf( '%s-script', SOCIAL_NETWORK_WIDGET_SLUG ), sprintf( '%sassets/admin/js/script%s.js', SOCIAL_NETWORK_WIDGET_DIR_URL, $min ), array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), SOCIAL_NETWORK_WIDGET_VERSION, true );

			// Enqueue admin scrips and styles, only in the customizer or the old widgets page.
			if ( is_customize_preview() || 'widgets.php' === $pagenow ) {
				wp_enqueue_style( sprintf( '%s-style', SOCIAL_NETWORK_WIDGET_SLUG ) );
				wp_enqueue_script( sprintf( '%s-script', SOCIAL_NETWORK_WIDGET_SLUG ) );
			}
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
		 * @param   array $links  An array of plugin action links.
		 * @return  array
		 */
		public function additional_links( $links ) {
			$plugin_links = array();
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$plugin_links[] = sprintf( _x( '%1$sHire Me!%2$s', 'plugin link', 'social-network-widget' ), sprintf( '<a href="%s" class="button-link-delete" target="_blank" rel="noopener noreferrer nofollow" title="%s">', esc_url( SOCIAL_NETWORK_WIDGET_AUTHOR_URI ), esc_attr_x( 'Looking for help? Hire Me!', 'upsell', 'social-network-widget' ) ), '</a>' );
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$plugin_links[] = sprintf( _x( '%1$sSupport%2$s', 'plugin link', 'social-network-widget' ), '<a href="https://wordpress.org/support/plugin/social-network-widget" target="_blank" rel="noopener noreferrer nofollow">', '</a>' );

			return array_merge( $plugin_links, $links );
		}

	}
endif;

if ( ! function_exists( 'social_network_widget_init' ) ) :
	/**
	 * Returns the main instance of Social_Network_Widget to prevent the need to use globals.
	 *
	 * @return  object(class)   Social_Network_Widget::instance
	 */
	function social_network_widget_init() {
		return Social_Network_Widget::instance();
	}

	social_network_widget_init();
endif;
