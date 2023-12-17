<?php

namespace Jet_FB_Woo;

use Jet_FB_Woo\JetEngine\Notifications\Manager as JEManager;
use Jet_FB_Woo\JetFormBuilder\Actions\Manager as JFBManager;

if ( ! defined( 'WPINC' ) ) {
	die();
}

class Plugin {
	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * @var WcIntegration
	 */
	public $wc;

	public $slug = 'jet-form-builder-woo-action';

	public function __construct() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_plugin' ) );

			return;
		}
		$this->wc = WcIntegration::register();

		JFBManager::register();
		JEManager::register();

		$can_init_license = (
			is_admin()
			&& function_exists( 'jet_form_builder' )
			&& array_key_exists( 'addons_manager', get_object_vars( jet_form_builder() ) )
		);

		if ( $can_init_license ) {
			require $this->plugin_dir( 'includes/class-jfb-license-manager.php' );

			new \JFB_License_Manager();
		}
	}

	public function admin_notice_missing_plugin() {
		$woocommerce_link = sprintf(
			'<a href="%1$s">%2$s</a>',
			admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term',
			'<strong>' . esc_html__( 'WooCommerce', 'jet-form-builder-woo-action' ) . '</strong>'
		);
		$message          = sprintf( __(
			'<b>Error:</b> <b>JetFormBuilder WooCommerce Cart & Checkout Action</b> plugin requires a %1$s',
			'jet-form-builder-woo-action'
		), $woocommerce_link );

		printf(
			'<div class="notice notice-error is-dismissible"><p>%1$s</p></div>',
			wp_kses_post( $message )
		);
	}

	public function get_version() {
		return JET_FB_WOO_ACTION_VERSION;
	}

	public function plugin_url( $path ) {
		return JET_FB_WOO_ACTION_URL . $path;
	}

	public function plugin_dir( $path = '' ) {
		return JET_FB_WOO_ACTION_PATH . $path;
	}

	public function get_template_path( $template ) {
		$path = JET_FB_WOO_ACTION_PATH . 'templates' . DIRECTORY_SEPARATOR;

		return ( $path . $template . '.php' );
	}


	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Plugin::instance();