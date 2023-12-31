<?php
/**
 * This class handles all functionality for the page builder frontend ajax
 *
 * @category   Pagebuilder
 * @package    ZnFramework
 * @author     Balasa Sorin Stefan ( Zauan )
 * @copyright  Copyright (c) Balasa Sorin Stefan
 * @link       http://themeforest.net/user/TheneFuzz
 */

// PageBuilder stuff
add_action('wp_ajax_znpb_get_module_option', 'znpb_get_module_option'); //
add_action('wp_ajax_znpb_get_page_options', 'znpb_get_page_options'); //
add_action('wp_ajax_znpb_clone_element', 'znpb_clone_element');
add_action('wp_ajax_znpb_render_module', 'znpb_render_module');
add_action('wp_ajax_znpb_publish_page', 'znpb_publish_page');


// Template system
add_action('wp_ajax_zn_save_template', 'zn_save_template');
add_action('wp_ajax_zn_delete_template', 'zn_delete_template');

// Element saving
add_action('wp_ajax_znpb_save_module', 'znpb_save_module');
add_action('wp_ajax_znpb_do_save_element', '_znpb_do_save_element');


/**
 * Returns a form containing requested module options
 * @return void
 */
function znpb_get_module_option() {

	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );

	define( 'ZN_PB_AJAX', true );

	$element_data = json_decode(  stripslashes( $_POST['element_options'] ), true );
	$module       = ZNB()->frontend->setupSingleElement( $element_data['data'] );

	echo '<form data-uid="' . $module->data['uid'] . '" class="zn_modal zn-modal-form">';

	$options = $module->options();

	// Allow themes to hook into options
	$options = apply_filters( 'zn_pb_options', $options, $module->data );

	$selector = '';
	if ( isset ( $options['css_selector'] ) ) {
		$selector = $options['css_selector'] . $module->data['uid'];
		unset ( $options['css_selector']  );
	}

	if ( isset( $options['has_tabs'] ) ) {
		unset( $options['has_tabs'] );

		if ( isset( $options['restrict'] ) ) {
			unset( $options['restrict'] );
		}

		echo '<div class="zn-tabs-container">';
		echo '<div class="zn-options-tab-header">';
		$i = 0;
		foreach ( $options as $key => $tab) {
			$cls = '';
			if ( ! empty($tab['title'])) {
				if ( 0 == $i ) {
					$cls = 'zn-tab-active';
				}
				echo '<a href="#" class="' . $cls . '" data-zntab="' . $key . '">' . $tab['title'] . '</a>';
			}
			$i++;
		}

		echo '</div>';

		$i = 0;
		foreach ( $options as $key => $tab ) {
			$cls = '';
			if ( 0 == $i ) {
				$cls = 'zn-tab-active';
			}
			echo '<div class="zn-options-tab-content zn-tab-key-' . $key . ' ' . $cls . '">';

			foreach ( $tab['options'] as $k => $option ) {
				// SET THE DEFAULT VALUE IF PROVIDED
				if ( isset( $module->data['options'][$option['id']] ) ) {
					$option['std'] = $module->data['options'][$option['id']];
				} elseif ( ! empty( $option['std'] ) ) {
					$module->data['options'][$option['id']] = $option['std'];
				}

				// Generate the options
				echo ZNHGFW()->getComponent('html')->zn_render_single_option( $option );
			}

			echo '</div>';
			$i++;
		}
		echo '</div>';
	} else {
		foreach ( $options as $option ) {

				// SET THE DEFAULT VALUE IF PROVIDED
			if ( isset( $module->data['options'][$option['id']] ) ) {
				$option['std'] = $module->data['options'][$option['id']];
			} elseif ( ! empty( $option['std'] ) ) {
				$module->data['options'][$option['id']] = $option['std'];
			}

			// Generate the options
			echo ZNHGFW()->getComponent('html')->zn_render_single_option( $option );
		}
	}

	echo '</form>'; // END FORM

	if ( ! empty( $selector ) ) {
		echo '<div title="' . esc_html(__('You can use this css selector to customize this element', 'zn_framework')) . '" class="zn_unique_selector_bar">' . __('CSS selector:', 'zn_framework') . ' ' . $selector . '</div>';
	}

	exit;
}

/**
 * Returns a form containing current page options
 * @return void
 */
function znpb_get_page_options() {
	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );
	define( 'ZN_PB_AJAX', true );

	echo '<form class="zn_modal zn-modal-form">';

	// Get page options
	$options = ZNB()->builder->getPageOptions();

	unset( $options['has_tabs'] );

	echo '<div class="zn-tabs-container">';
	echo '<div class="zn-options-tab-header">';
	$i = 0;
	foreach ( $options as $key => $tab) {
		$cls = '';
		if ( 0 == $i ) {
			$cls = 'zn-tab-active';
		}
		echo '<a href="#" class="' . $cls . '" data-zntab="' . $key . '">' . $tab['title'] . '</a>';
		$i++;
	}

	echo '</div>';

	$i = 0;
	foreach ( $options as $key => $tab ) {
		$cls = '';
		if ( 0 == $i ) {
			$cls = 'zn-tab-active';
		}
		echo '<div class="zn-options-tab-content zn-tab-key-' . $key . ' ' . $cls . '">';

		foreach ( $tab['options'] as $k => $option ) {
			// SET THE DEFAULT VALUE IF PROVIDED
			if ( ! empty( $_POST['page_options'][$option['id']] ) ) {
				$option['std'] = $_POST['page_options'][$option['id']];
			} else {
				$saved_value = get_post_meta( $_POST['post_id'], $option['id'], true);
				if (  ! empty($saved_value) ) {
					$option['std'] = $saved_value;
				}
			}

			echo ZNHGFW()->getComponent('html')->zn_render_single_option( $option );
		}

		echo '</div>';
		$i++;
	}
	echo '</div>';
	echo '</form>';
}

/**
 * Update an element
 *
 * @access public
 * @return void
 */
function znpb_clone_element() {
	// Init the page builder editor mode so we can have access to all data
	znpb_render_module();
}

/**
 * Update an element
 *
 * @access public
 * @return void
 */
function znpb_render_module() {

	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );

	define( 'ZN_PB_AJAX', true );

	$znb = ZNB();

	$znb->builder->init();
	$_templates = $znb->templates;
	$_frontend  = $znb->frontend;


	// SET THE ELEMENT DATA
	$template_data = json_decode( stripslashes( $_POST['template'] ), true );
	$template_data = znb_generate_uid( $template_data );

	$response = array();

	// If this is a saved element
	if ( ! empty( $_POST['template_name'] ) ) {
		$templateName = $_templates->generateKey($_POST['template_name']);
		// Check to see if this is a page template or a single element
		$templateType  = filter_var($_POST[ 'isSingle' ], FILTER_VALIDATE_BOOLEAN) ? 'zn_pb_el_templates' : 'zn_pb_templates';
		$post_id       = $_templates->getPostID( $templateType );
		$template_name = esc_attr( stripslashes(str_replace(array(' '), '_', strip_tags($templateName))) );
		$template_data = $_templates->getPageBuilderTemplates( $templateType, $template_name, '=' );

		if ( ! empty( $template_data[0] ) ) {
			$template_data = maybe_unserialize($template_data[0]);
			$template_data = znb_generate_uid( $template_data['template'] );
		}
	}

	// Setup post and WP_query data
	if ( ! empty( $_POST['post_id'] ) ) {
		$post_type    = get_post_type( $_POST['post_id'] );
		$current_post = query_posts( array( 'p' => $_POST['post_id'], 'post_type' => $post_type ) );
		global $post;
		$post = get_post( $_POST['post_id'] );
		setup_postdata( $post );
	}

	// Setup elements
	$_frontend->setupElements( $template_data );

	// Start output fetching
	ob_start();
	$_frontend->renderContent( $template_data );
	// End output fetching
	$html = ob_get_contents();
	ob_end_clean();

	$response['template']       = do_shortcode( $html );
	$response['current_layout'] = $_frontend->getLayoutModules();

	wp_send_json( $response );
}

function znb_generate_uid( $template ) {
	if ( ! is_array( $template ) ) {
		return false;
	}

	$template_data = array();

	$i = 0;

	foreach ($template as $key => $module) {
		if ( ! isset( $module['uid'] ) ) {
			$module['uid'] = zn_uid('eluid');
		};

		$template_data[$i]            = $module;
		$template_data[$i]['content'] = array();

		if ( ! empty( $module['content'] ) ) {
			if ( ! empty( $module['content']['has_multiple'] ) ) {
				unset( $module['content']['has_multiple'] );

				$u = 0;

				foreach ( $module['content'] as $actual_content ) {
					$template_data[$i]['content'][$u] = znb_generate_uid( $actual_content );

					$u++;
				}
				$template_data[$i]['content']['has_multiple'] = true;
			} else {
				$template_data[$i]['content'] = znb_generate_uid( $module['content'] );
			}
		}
		$i++;
	}

	return $template_data;
}

/**
 * Publish the pagebuilder page
 *
 * @access public
 * @return void
 */
function znpb_publish_page() {

	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );

	define( 'ZN_PB_AJAX', true );

	$postID = ZNB()->utility->getPostID();

	if ( 'page' == get_post_type( $postID ) ) {
		if ( ! current_user_can( 'edit_page', $postID ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $postID ) ) {
			return;
		}
	}

	$element_data = json_decode( stripslashes( $_POST['template'] ), true );
	// Fixes #1933 - update_metadata strips slashes
	$element_data = wp_slash( $element_data );
	update_metadata('post', $postID, 'zn_page_builder_els', $element_data);

	// UPDATE THE PAGEBUILDER OPTION IN CASE SOMEONE ELSE EDITS THE PAGE IN BACKEND
	ZNB()->utility->enableEditor($postID);

	/* CHECK IF THE THEME SUPPORTS CUSTOM OPTIONS AND SAVE THEM */
	// TODO: Sa verific intai daca optiunile au fost inregistrate...sa nu salvez tot ce vine in POST
	if ( ! empty( $_POST['page_options'] ) ) {
		foreach ( $_POST['page_options'] as $key => $value ) {
			update_post_meta( $postID, $key, $value );
			if ( ! empty($latest_revision)) {
				update_post_meta( $latest_revision, $key, $value );
			}
		}
	}

	// Update post modified date
	$post = array(
		'ID'                => $postID,
		'post_modified_gmt' => time(),
	);
	wp_update_post( $post );

	// LET OTHERS HOOK HERE :)
	do_action('znpb_save_page', $postID);
	echo 'Done';
	exit;
}

function znpb_save_module() {
	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );
	define( 'ZN_PB_AJAX', true );

	$option = array (
		'name'        => __( 'Element name', 'zn_framework'),
		'description' => __( 'Enter a name for this saved element. Please note that the name must be unique!', 'zn_framework'),
		'id'          => 'element_name',
		'std'         => '',
		'type'        => 'text',
		'placeholder' => __( 'My awesome element', 'zn_framework' ),
		'class'		     => 'zn_full',
	);

	echo '<form class="zn_save_element_form zn-modal-form">';

	// We need the element uid and level to save it
	if ( empty( $_POST['element_uid'] ) || empty( $_POST['element_level'] ) ) {
		echo __('Something went wrong. Please try again', 'zn_framework');
	} else {
		echo ZNHGFW()->getComponent('html')->zn_render_single_option( $option );

		// Save button
		echo '<a href="#" data-uid="' . $_POST['element_uid'] . '" data-level="' . $_POST['element_level'] . '" class="zn-btn-confirm zn-btn-green zn_button_save_element">' . __( 'Save element', 'zn_framework' ) . '</a>';
		echo '<a href="#" data-uid="' . $_POST['element_uid'] . '" data-level="' . $_POST['element_level'] . '" class="zn-btn-confirm zn-btn-cancel zn_button_export_element">' . __( 'Export element', 'zn_framework' ) . '</a>';
	}

	echo '</form>';
}

function _znpb_do_save_element() {
	// Check the request
	check_ajax_referer( 'zn_framework', 'security' );
	define( 'ZN_PB_AJAX', true );

	if ( empty( $_POST['template_name'] ) || empty( $_POST['template'] ) || empty( $_POST['level'] ) ) {
		return false;
	}
	$template_name = esc_attr( stripslashes(str_replace(array(' '), '_', strip_tags($_POST['template_name']))) );
	$template_data = array(
		'template_name' => $template_name,
		'template'      => json_decode( stripslashes( $_POST['template'] ), true ),
		'level'         => $_POST['level'],
	);

	$return = znpb_do_save_element($template_data);

	// Send the response
	wp_send_json($return);
	exit;
}
function znpb_do_save_element( $template_data = false ) {
	$return = array();

	// Get the template map
	$template_name = $template_data['template_name'];
	$content       = array(
		'name'     => '{{{' . $template_name . '}}}',
		'template' => $template_data['template'],
		'level'    => $template_data['level'],
	);

	$zTemplates = ZNB()->templates;

	$post_id 				          = $zTemplates->getPostID( 'zn_pb_el_templates' );
	$template_new_name 		  = $zTemplates->generateKey( $template_name );
	$template_name_check 	 = $zTemplates->getPageBuilderTemplates( 'zn_pb_el_templates', $template_new_name, '=' );

	if ( ! empty($template_name_check)) {
		$template_name     = $template_name . zn_uid('');
		$template_new_name = $zTemplates->generateKey( $template_name );
		$content['name']   = '{{{' . $template_name . '}}}';
	}

	$result = update_post_meta( $post_id, $template_new_name, $content );
	if ( $result ) {
		$return['message'] = __('Element successfully saved.', 'zn_framework');
	} else {
		$return['message'] = __('There was a problem saving the element.', 'zn_framework');
	}

	return $return;
}

function zn_save_template() {
	check_ajax_referer( 'zn_framework', 'security' );

	define( 'ZN_PB_AJAX', true );

	if ( empty( $_POST['template_name'] ) ) {
		return false;
	}

	$return = array();

	$zTemplates = ZNB()->templates;

	// Get the template map
	$template_name = $_POST['template_name'];
	$page_options  = $_POST['page_options'];
	$custom_css    = ! empty( $page_options['zn_page_custom_css'] ) ? $page_options['zn_page_custom_css'] : '';
	$template      = json_decode( stripslashes( $_POST['template'] ), true );
	$content       = array(
		'name'       => '{{{' . $template_name . '}}}',
		'template'   => $template,
		'custom_css' => $custom_css,
	);

	$post_id               = $zTemplates->getPostID();
	$template_new_name 		  = $zTemplates->generateKey( $_POST['template_name'] );
	$template_name_check 	 = $zTemplates->getPageBuilderTemplates( 'zn_pb_templates', $template_new_name, '=' );

	if ( ! empty($template_name_check)) {
		$template_name     = $template_name . zn_uid('');
		$template_new_name = $zTemplates->generateKey( $template_name );
		$content['name']   = '{{{' . $template_name . '}}}';
	}

	$result = update_post_meta( $post_id, $template_new_name, $content );
	if ( $result ) {
		$return['message'] = __('Template successfully saved.', 'zn_framework');
	} else {
		$return['message'] = __('There was a problem saving the template.', 'zn_framework');
	}

	// Send the response
	wp_send_json($return);
	exit;
}


function zn_delete_template() {
	check_ajax_referer( 'zn_framework', 'security' );

	define( 'ZN_PB_AJAX', true );

	// DO NOTHING IF WE DON"T HAVE A TEMPLATE NAME
	if ( empty( $_POST['template_name'] ) ) {
		return false;
	}

	$templateName = ZNB()->templates->generateKey($_POST['template_name']);
	// Check to see if this is a page template or a single element
	$templateType = filter_var($_POST[ 'isSingle' ], FILTER_VALIDATE_BOOLEAN) ? 'zn_pb_el_templates' : 'zn_pb_templates';
	$post_id      = ZNB()->templates->getPostID( $templateType );

	$template_name    = esc_attr( stripslashes(str_replace(array(' '), '_', strip_tags($templateName))) );
	$template_deleted = delete_post_meta($post_id, $template_name );

	if ( $template_deleted ) {
		$return['message'] = __('Template deleted successfully', 'zn_framework');
		$return['success'] = true;
	} else {
		$return['message'] = __('There was a problem. The template was not deleted', 'zn_framework');
	}

	// Send the response
	wp_send_json($return);
	exit;
}
