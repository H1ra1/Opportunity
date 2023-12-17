<?php


namespace JetWooCore;


trait BaseRenderField {

	public $args;

	abstract public function set_up( ...$args );

	abstract public function render_field( $attrs_string );

	/**
	 * It used in JetFormBuilder Render\Base for naming field template
	 * And in JetEngine & JetFormBuilder it used for naming wp.hook
	 *
	 * @return string
	 */
	abstract public function get_name();

	/**
	 * It must be rewrite on client-level
	 */
	public function attributes_values() {
		return array();
	}

	/**
	 * Base function, it must rewrite on core-level
	 */
	public function _preset_attributes_map() {
		return array();
	}

	final public function get_arg( $key, $if_not_exist = '' ) {
		return ( isset( $this->args[ $key ] ) ? $this->args[ $key ] : $if_not_exist );
	}

	private function save_attributes() {
		$attributes = apply_filters( "jet-fb/attributes/{$this->get_name()}", $this->get_attributes_map() );

		foreach ( $attributes as $name => $value ) {
			$this->add_attribute( $name, $value );
		}
	}

	final public function get_attributes_map() {
		return array_merge_recursive( $this->_preset_attributes_map(), $this->attributes_values() );
	}

	public function get_args( $args_names = array() ) {
		if ( ! $args_names ) {
			return $this->args;
		}
		$response = array();

		foreach ( $args_names as $args_name ) {
			if ( ! is_array( $args_name ) ) {
				$response[ $args_name ] = $this->get_arg( $args_name );

				continue;
			}
			list( $name, $if_not_exist ) = $args_name;

			$response[ $name ] = $this->get_arg( $name, $if_not_exist );
		}

		return $response;
	}

	/**
	 * Call this function to get rendered field template
	 *
	 * @return string
	 */
	final public function get_rendered() {
		$this->save_attributes();

		return $this->render_field( $this->get_attributes_string() );
	}

}