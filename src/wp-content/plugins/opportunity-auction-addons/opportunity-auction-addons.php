<?php
/*
Plugin Name:  Opportunity Auction Addons
Description:  Creates additional features for the animal auction.
Version:      1.0
Author:       Henrique Lira
Author URI:   https://github.com/H1ra1
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  oaa
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'OAA' ) ) {
    class OAA {

        public $version = '1.0.0';

        public function __construct() {
			// Do nothing.
		}

        public function initialize() {
            
            // Check if ACF is active.
            if ( ! class_exists('ACF') ) {
                echo 'ALTERAR MENSAGEM DE ERRO';
            }

            // Define constants.
            define( 'OAA_PATH', plugin_dir_path( __FILE__ ) );
            define( 'OAA_URL', plugin_dir_url( __FILE__ ) );

            // Add actions.
            add_action( 'init', array( $this, 'register_post_types' ), 5 );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'save_post', array( $this, 'save_post_auction' ), 10, 3 );
        }

        public function register_post_types() {
            // Register the Animal post type.
            register_post_type( 'animal', 
                array(
                    'labels' => array(
                        'name' => 'Animais',
                        'singular_name' => 'Animal',
                        'menu_name' => 'Animais',
                        'all_items' => 'All Animais',
                        'edit_item' => 'Edit Animal',
                        'view_item' => 'View Animal',
                        'view_items' => 'View Animais',
                        'add_new_item' => 'Add New Animal',
                        'add_new' => 'Add New Animal',
                        'new_item' => 'New Animal',
                        'parent_item_colon' => 'Parent Animal:',
                        'search_items' => 'Search Animais',
                        'not_found' => 'No Animais found',
                        'not_found_in_trash' => 'No Animais found in Trash',
                        'archives' => 'Animal Archives',
                        'attributes' => 'Animal Attributes',
                        'insert_into_item' => 'Insert into animal',
                        'uploaded_to_this_item' => 'Uploaded to this animal',
                        'filter_items_list' => 'Filter Animais list',
                        'filter_by_date' => 'Filter Animais by date',
                        'items_list_navigation' => 'Animais list navigation',
                        'items_list' => 'Animais list',
                        'item_published' => 'Animal published.',
                        'item_published_privately' => 'Animal published privately.',
                        'item_reverted_to_draft' => 'Animal reverted to draft.',
                        'item_scheduled' => 'Animal scheduled.',
                        'item_updated' => 'Animal updated.',
                        'item_link' => 'Animal Link',
                        'item_link_description' => 'A link to a animal.',
                    ),
                    'public' => true,
                    'show_in_rest' => true,
                    'supports' => array(
                        0 => 'title',
                        1 => 'editor',
                        2 => 'thumbnail',
                    ),
                    'delete_with_user' => false,
                    'menu_icon' => 'dashicons-buddicons-activity'
                ) 
            );

            // Register the Auction post type.
            register_post_type( 'auction', 
                array(
                    'labels'            => array(
                        'name' => 'Leilões',
                        'singular_name' => 'Leilão',
                        'menu_name' => 'Leilões',
                        'all_items' => 'All Leilões',
                        'edit_item' => 'Edit Leilão',
                        'view_item' => 'View Leilão',
                        'view_items' => 'View Leilões',
                        'add_new_item' => 'Add New Leilão',
                        'add_new' => 'Add New Leilão',
                        'new_item' => 'New Leilão',
                        'parent_item_colon' => 'Parent Leilão:',
                        'search_items' => 'Search Leilões',
                        'not_found' => 'No Leilões found',
                        'not_found_in_trash' => 'No Leilões found in Trash',
                        'archives' => 'Leilão Archives',
                        'attributes' => 'Leilão Attributes',
                        'insert_into_item' => 'Insert into Leilão',
                        'uploaded_to_this_item' => 'Uploaded to this leilão',
                        'filter_items_list' => 'Filter Leilões list',
                        'filter_by_date' => 'Filter Leilões by date',
                        'items_list_navigation' => 'Leilões list navigation',
                        'items_list' => 'Leilões list',
                        'item_published' => 'Leilão published.',
                        'item_published_privately' => 'Leilão published privately.',
                        'item_reverted_to_draft' => 'Leilão reverted to draft.',
                        'item_scheduled' => 'Leilão scheduled.',
                        'item_updated' => 'Leilão updated.',
                        'item_link' => 'Leilão Link',
                        'item_link_description' => 'A link to a leilão.',
                    ),
                    'public'            => true,
                    'show_in_rest'      => true,
                    'supports'          => array(
                        0 => 'title',
                        1 => 'editor',
                        2 => 'thumbnail',
                    ),
                    'delete_with_user'  => false,
                    'menu_icon'         => 'dashicons-schedule'
                ) 
            );
        }

        public function enqueue_scripts() {
            wp_enqueue_script( 'oaa-admin-scripts', OAA_URL . "assets/js/oaa-admin.js", array( 'jquery' ), $this->version );
        }

        public function save_post_auction( int $post_id, WP_Post $post, bool $update ) {
            $post_type = get_post_type( $post_id );

            if( $post_type != 'auction' )
                return;

            $auction_configs = get_field( 'auction', $post_id );

            if( ! is_array( $auction_configs[ 'lotes' ] ) || count(  $auction_configs[ 'lotes' ] ) == 0 )
                return;
            
            foreach( $auction_configs[ 'lotes' ] as $indice => $lote ) {
                if( empty( $lote[ 'lote_id' ] ) ) {
                    $product_id = $this->create_auction_product( $lote, $post );
                } else {
                    $product_id = $lote[ 'lote_id' ];
                    $this->update_auction_product( $lote[ 'lote_id' ], $lote, $post );
                }

                // Add on Auction array data the product id on lote id field.
                $auction_configs[ 'lotes' ][ $indice ][ 'lote_id' ] = $product_id;
            }

            // Update acf field product ID
            update_field( 'auction', $auction_configs, $post_id );
            
            // wp_die();
        }

        private function create_auction_product( array $auction_data, WP_Post $post ) {

            // Set auction product data
            $product = new WC_Product();

            $product->set_name( "Lote: {$auction_data[ 'numero_do_lote' ]} - Evento: {$post->post_title}" );
            $product->save();
            
            // Retrive the product created id.
            $product_id = $product->get_id();

            // Define the product type auction.
            wp_set_object_terms( $product_id, 'auction', 'product_type' );

            // Update the post metas.
            update_post_meta( $product_id, 'woo_ua_opening_price', $auction_data[ 'preco_de_abertura' ] );
            update_post_meta( $product_id, 'woo_ua_lowest_price', $auction_data[ 'menor_preco_para_aceitar' ] );
            update_post_meta( $product_id, '_regular_price', $auction_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, '_price', $auction_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_data[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_data[ 'data_de_inicio' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_data[ 'data_de_termino' ] );

            return $product_id;
        }

        private function update_auction_product( int $product_id, array $auction_data, WP_Post $post ) {

            // Update auction product data
            $auction_product_object = wc_get_product( $product_id );
            if ( $auction_product_object instanceof WC_Product ) {
                $auction_product_object->set_name( "Lote: {$auction_data[ 'numero_do_lote' ]} - Evento: {$post->post_title}" );

                // Save it
                $auction_product_object->save();
            }
            
            // Update the post metas.
            update_post_meta( $product_id, 'woo_ua_opening_price', $auction_data[ 'preco_de_abertura' ] );
            update_post_meta( $product_id, 'woo_ua_lowest_price', $auction_data[ 'menor_preco_para_aceitar' ] );
            update_post_meta( $product_id, '_regular_price', $auction_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, '_price', $auction_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_data[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_data[ 'data_de_inicio' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_data[ 'data_de_termino' ] );
        }
    }

    function oaa() {
		global $oaa;

		// Instantiate only once.
		if ( ! isset( $oaa ) ) {
			$oaa = new OAA();
			$oaa->initialize();
		}

		return $oaa;
	}

	// Instantiate.
	oaa();
}