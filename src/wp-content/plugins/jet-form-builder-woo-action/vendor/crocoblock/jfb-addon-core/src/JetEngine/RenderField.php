<?php


namespace JetWooCore\JetEngine;


use JetWooCore\AttributesTrait;
use JetWooCore\BaseRenderField;

trait RenderField {

	use AttributesTrait;
	use BaseRenderField;

	private $builder;

	public function set_up( ...$args ) {
		list( $this->args, $this->builder ) = $args;

		return $this;
	}

	public function _preset_attributes_map() {
		return array(
			'class'           => array( 'jet-form__field' ),
			'required'        => $this->builder->get_required_val( $this->args ),
			'name'            => $this->builder->get_field_name( $this->get_arg( 'name', 'field_name' ) ),
			'id'              => $this->builder->get_field_id( $this->args ),
			'data-field-name' => $this->get_arg( 'name', 'field_name' ),
			'value'           => $this->get_arg( 'default' ),
		);
	}
}