<?php


namespace JetWooCore\JetFormBuilder;


use Jet_Form_Builder\Blocks\Types\Base;
use JetWooCore\BaseRenderField;

/**
 * @property Base $block_type
 *
 * Trait RenderBlock
 * @package JetWooCore\JetFormBuilder
 */
trait RenderBlock {

	use BaseRenderField;

	public function set_up( ...$args ) {
		$this->args = $this->block_type->block_attrs;

		return $this;
	}

	public function _preset_attributes_map() {
		return array(
			'class'           => array( 'jet-form-builder__field' ),
			'required'        => $this->block_type->get_required_val(),
			'name'            => $this->block_type->get_field_name( $this->get_arg( 'name', 'field_name' ) ),
			'id'              => $this->block_type->get_field_id( $this->args ),
			'data-field-name' => $this->get_arg( 'name', 'field_name' ),
			'value'           => $this->get_arg( 'default' ),
		);
	}


}