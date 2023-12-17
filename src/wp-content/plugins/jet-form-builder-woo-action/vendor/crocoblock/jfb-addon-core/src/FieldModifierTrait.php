<?php


namespace JetWooCore;

use JetWooCore\Exceptions\BaseHandlerException;

/**
 * @var $this FieldModifierIT
 *
 * Trait FieldModifierTrait
 * @package JetWooCore
 */
trait FieldModifierTrait {

	public $_args;
	public $_class;

	public function renderHandler( $args, $instance ): array {
		try {
			$this->_args  = $args;
			$this->_class = $instance;

			return $this->onRender();

		} catch ( BaseHandlerException $exception ) {
			return $args;
		}
	}


	public function editorAssets() {
	}

}