<?php

namespace Jet_FB_Address_Autocomplete\JetFormBuilder\Blocks;


// If this file is called directly, abort.
use Jet_FB_Address_Autocomplete\AddressAutocomplete;
use Jet_FB_Address_Autocomplete\GutenbergStyleControls;
use Jet_FB_Address_Autocomplete\Plugin;
use Jet_FB_Address_Autocomplete\Traits\AddressFieldTrait;
use Jet_Form_Builder\Admin\Tabs_Handlers\Tab_Handler_Manager;
use Jet_Form_Builder\Blocks\Types\Base;
use JetAddressAutocompleteCore\JetFormBuilder\SmartBaseBlock;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Text field block class
 */
class AddressBlock extends Base {

	use SmartBaseBlock;
	use AddressFieldTrait;

	/**
	 * Returns block name
	 *
	 * @return [type] [description]
	 */
	public function get_name() {
		return 'address-field';
	}

	protected function _jsm_register_controls() {
		( new GutenbergStyleControls() )->register_address_controls( $this->controls_manager );
	}

	public function get_field_template( $path ) {
		return Plugin::instance()->get_template_path( $path );
	}

	public function get_path_metadata_block() {
		$path_parts = array( 'assets', 'blocks', $this->get_name() );
		$path       = implode( DIRECTORY_SEPARATOR, $path_parts );

		return Plugin::instance()->plugin_dir( $path );
	}

	public function render_instance() {
		AddressAutocomplete::instance()->settings( 'jfb-address-tab', Tab_Handler_Manager::instance() );

		AddressAutocomplete::instance()->enqueue_scripts( 'jfb-address-tab' );
		AddressAutocomplete::instance()->enqueue_styles();

		return new AddressBlockRender( $this );
	}
}
