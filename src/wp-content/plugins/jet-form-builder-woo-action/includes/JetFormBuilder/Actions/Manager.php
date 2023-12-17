<?php


namespace Jet_FB_Woo\JetFormBuilder\Actions;

use Jet_FB_Woo\Plugin;
use JetWooCore\JetFormBuilder\ActionsManager;

class Manager extends ActionsManager {

	public function register_controller( \Jet_Form_Builder\Actions\Manager $manager ) {
		$manager->register_action_type( new Action() );
	}

	/**
	 * @return void
	 */
	public function before_init_editor_assets() {
		wp_enqueue_script(
			Plugin::instance()->slug,
			Plugin::instance()->plugin_url( 'assets/js/builder.editor.js' ),
			array(),
			Plugin::instance()->get_version(),
			true
		);
	}

	public function plugin_version_compare() {
		return '1.2.4';
	}

	public function on_base_need_update() {
		$this->add_admin_notice( 'warning', __(
			'<b>Warning</b>: <b>JetFormBuilder Woocommerce Cart & Checkout Action</b> needs <b>JetFormBuilder</b> update.',
			'jet-form-builder-woo-action'
		) );
	}

	public function on_base_need_install() {
	}
}