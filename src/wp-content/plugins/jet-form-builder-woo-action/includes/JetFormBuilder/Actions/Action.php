<?php

namespace Jet_FB_Woo\JetFormBuilder\Actions;

use Jet_FB_Woo\ActionTrait;
use Jet_FB_Woo\Plugin;
use Jet_Form_Builder\Exceptions\Request_Exception;
use JetWooCore\Exceptions\BaseHandlerException;
use JetWooCore\JetFormBuilder\SmartBaseAction;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Base_Type class
 */
class Action extends SmartBaseAction {

	use ActionTrait;

	public function self_script_name() {
		return 'JetActionWooCheckout';
	}

}


