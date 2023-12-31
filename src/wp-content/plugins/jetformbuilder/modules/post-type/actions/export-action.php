<?php


namespace JFB_Modules\Post_Type\Actions;

use Jet_Form_Builder\Classes\Tools;
use JFB_Modules\Post_Type\Actions\Traits\Get_Form_Data_Trait;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Export_Action extends Base_Form_Action {

	use Get_Form_Data_Trait;

	// phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore
	private $_file;

	/**
	 * @return string
	 */
	public function get_id() {
		return 'jet_fb_export';
	}

	/**
	 * @return mixed
	 */
	public function get_title() {
		return __( 'Export', 'jet-form-builder' );
	}

	public function do_admin_action() {
		$form_id = $this->get_post_id_from_request();

		/** @var \WP_Post[] $form_data */
		$form_data   = $this->get_from_data( $form_id );
		$this->_file = Tools::encode_json( $form_data[1] );

		$name = sanitize_title( $form_data[0]->post_title );

		$this->file_download( $name . '.json' );
	}


	/**
	 * Process
	 *
	 * @param $filename
	 * @param string $type
	 *
	 * @return void
	 */
	public function file_download( $filename = null, $type = 'application/json' ) {

		set_time_limit( 0 );

		// phpcs:disable
		@session_write_close();

		if ( function_exists( 'apache_setenv' ) ) {
			$variable = 'no-gzip';
			$value    = 1;
			@apache_setenv( $variable, $value );
		}

		@ini_set( 'zlib.output_compression', 'Off' );

		nocache_headers();

		header( "Robots: none" );
		header( "Content-Type: " . $type );
		header( "Content-Description: File Transfer" );
		header( "Content-Disposition: attachment; filename=\"" . $filename . "\";" );
		header( "Content-Transfer-Encoding: binary" );

		// Set the file size header
		header( "Content-Length: " . strlen( $this->_file ) );

		echo $this->send_file();

		die();

		// phpcs:enable
	}

	private function send_file() {
		return apply_filters( 'jet-form-builder/export-form/content', $this->_file );
	}
}
