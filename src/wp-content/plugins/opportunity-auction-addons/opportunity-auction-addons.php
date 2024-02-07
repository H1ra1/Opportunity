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
            global $wpdb;
            
            // Check if ACF is active.
            if ( ! class_exists('ACF') ) {
                echo 'ALTERAR MENSAGEM DE ERRO';
            }

            // Define constants.
            define( 'OAA_PATH', plugin_dir_path( __FILE__ ) );
            define( 'OAA_URL', plugin_dir_url( __FILE__ ) );
            define( 'WPDB', $wpdb );

            // Include utility functions.
            include_once OAA_PATH . 'includes/oaa-utility-functions.php';

            // Include functions.
            oaa_include_once( 'includes/oaa-functions.php' );
            oaa_include_once( 'includes/oaa-template-functions.php' );

            // Include core.
            oaa_include_once( 'includes/oaa-add-acf-fields.php' );
            oaa_include_once( 'includes/oaa-register-post-types.php' );
            oaa_include_once( 'includes/oaa-register-taxonomies.php' );

            // Add actions.
            add_action( 'init', array( $this, 'init' ), 1 );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_admin' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'save_post', array( $this, 'save_post_auction' ), 10, 3 );
            add_action( 'admin_menu', array( $this, 'remove_menu_pages_for_user_roles' ) );
        }

        public function init() {

            // Include functions.
            oaa_include_once( 'includes/oaa-db-functions.php' );
            oaa_include_once( 'includes/oaa-bid-functions.php' );
            oaa_include_once( 'includes/oaa-pre-bid-functions.php' );
            oaa_include_once( 'includes/oaa-auth-functions.php' );

            // Call core functions.
            $this->create_pages();
            $this->create_database_tables();
            $this->create_user_roles();
            $this->create_columns_on_auction_tables();
        }

        private function create_pages() {

            // Check if the page already exists.
            if( empty( get_page_by_title( 'leiloes', 'OBJECT', 'page' ) ) ) {

                // Create page Leilões and insert shortcode to list the auctions registered.
                wp_insert_post(
                    array(
                    'comment_status' => 'close',
                    'ping_status'    => 'close',
                    'post_author'    => 1,
                    'post_title'     => ucwords( 'Leilões' ),
                    'post_name'      => strtolower( str_replace(' ', '-', trim( 'leiloes' ) ) ),
                    'post_status'    => 'publish',
                    'post_content'   => '[oaa_available_auctions]',
                    'post_type'      => 'page'
                    )
                );
            }
        }

        public function enqueue_scripts_admin() {

            // Scripts
            wp_enqueue_script( 'oaa-admin-scripts', OAA_URL . "assets/js/oaa-admin.js", array( 'jquery' ), $this->version );
        }

        public function enqueue_scripts() {
            $vars = array(
                'uri'                   => OAA_URL,
                'ajax_url'              => admin_url( 'admin-ajax.php' ),
                'nonce'                 => wp_create_nonce( 'ajax-nonce' )
            );

            // Scripts.
            wp_enqueue_script( 'oaa-scripts', OAA_URL . "assets/js/oaa.js", array( 'jquery' ), $this->version );
            wp_enqueue_script( 'oaa-slick', OAA_URL . "assets/lib/slick.min.js", array( 'jquery' ), '1.8.1' );

            // Styles.
            wp_enqueue_style( 'oaa-styles', OAA_URL . "assets/css/oaa.min.css", array(), $this->version );
            wp_enqueue_style( 'oaa-slick', OAA_URL . "assets/lib/slick.css", array(), '1.8.1' );

            // Add vars to scripts.
            wp_localize_script(
                'oaa-scripts',
                'main_params',
                $vars
            );
        }

        public function save_post_auction( int $post_id, WP_Post $post, bool $update ) {
            $post_type = get_post_type( $post_id );

            if( $post_type != 'auction' )
                return;

            $auction_configs = get_field( 'auction', $post_id );

            if( ! is_array( $auction_configs ) || ! is_array( $auction_configs[ 'lotes' ] ) || count(  $auction_configs[ 'lotes' ] ) == 0 )
                return;
            
            foreach( $auction_configs[ 'lotes' ] as $indice => $lot ) {
                $animal_data = get_field( 'animal', $lot[ 'animal' ]->ID );
                $lot[ 'animal_data' ] = $animal_data;

                if( empty( $lot[ 'lote_id' ] ) ) {
                    $product_id = $this->create_auction_product( $lot, $auction_configs, $post, $indice );
                } else {
                    $product_id = $lot[ 'lote_id' ];
                    $this->update_auction_product( $lot[ 'lote_id' ], $lot, $auction_configs, $post, $indice );
                }

                // Add on Auction array data the product id on lote id field.
                $auction_configs[ 'lotes' ][ $indice ][ 'lote_id' ] = $product_id;
            }

            // Update acf field product ID
            update_field( 'auction', $auction_configs, $post_id );
        }

        private function create_auction_product( array $lot_data, array $auction_configs, WP_Post $post, int $lot_indice ) {

            // Set auction product data.
            $product = new WC_Product();

            $product->set_name( "Lote: {$lot_data[ 'numero_do_lote' ]} - Evento: {$post->post_title}" );

            if( is_array( $lot_data[ 'animal_data' ] ) && count( $lot_data[ 'animal_data' ][ 'fotos' ] ) > 0 ) {
                $product->set_image_id( $lot_data[ 'animal_data' ][ 'fotos' ][ 0 ][ 'ID' ] );
            }

            $product->save();
            
            // Retrive the product created id.
            $product_id = $product->get_id();

            // Define the product type auction.
            wp_set_object_terms( $product_id, 'auction', 'product_type' );

            // Update the post metas.
            update_post_meta( $product_id, 'woo_ua_opening_price', ! empty( $lot_data[ 'preco_de_abertura' ] ) ? $lot_data[ 'preco_de_abertura' ] : $auction_configs[ 'preco_padrao_de_abertura' ] );
            update_post_meta( $product_id, 'woo_ua_lowest_price', $lot_data[ 'menor_preco_para_aceitar' ] );
            update_post_meta( $product_id, '_regular_price', $lot_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, '_price', $lot_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_configs[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_configs[ 'data_de_inicio_lances' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_configs[ 'data_de_termino_lances' ] );
            update_post_meta( $product_id, 'woo_ua_next_bids', $auction_configs[ 'numero_de_proximos_lances' ] );
            update_post_meta( $product_id, 'woo_ua_auction_type', 'normal' );
            update_post_meta( $product_id, 'oaa_auction_product_post_id', $post->ID );
            update_post_meta( $product_id, 'oaa_auction_animal_post_id', $lot_data[ 'animal' ]->ID );
            update_post_meta( $post->ID, 'oaa_auction_lot_indice', $lot_indice );

            return $product_id;
        }

        private function update_auction_product( int $product_id, array $lot_data, array $auction_configs, WP_Post $post, int $lot_indice ) {

            // Update auction product data.
            $auction_product_object = wc_get_product( $product_id );

            if ( $auction_product_object instanceof WC_Product ) {
                $auction_product_object->set_name( "Lote: {$lot_data[ 'numero_do_lote' ]} - Evento: {$post->post_title}" );

                if( is_array( $lot_data[ 'animal_data' ] ) && count( $lot_data[ 'animal_data' ][ 'fotos' ] ) > 0 ) {
                    $auction_product_object->set_image_id( $lot_data[ 'animal_data' ][ 'fotos' ][ 0 ][ 'ID' ] );
                }

                // Save it.
                $auction_product_object->save();
            }
            
            // Update the post metas.
            update_post_meta( $product_id, 'woo_ua_opening_price', ! empty( $lot_data[ 'preco_de_abertura' ] ) ? $lot_data[ 'preco_de_abertura' ] : $auction_configs[ 'preco_padrao_de_abertura' ]);
            update_post_meta( $product_id, 'woo_ua_lowest_price', $lot_data[ 'menor_preco_para_aceitar' ] );
            update_post_meta( $product_id, '_regular_price', $lot_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, '_price', $lot_data[ 'preco_venda_imediata' ] );
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_configs[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_configs[ 'data_de_inicio_lances' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_configs[ 'data_de_termino_lances' ] );
            update_post_meta( $product_id, 'woo_ua_next_bids', $auction_configs[ 'numero_de_proximos_lances' ] );
            update_post_meta( $product_id, 'woo_ua_auction_type', 'normal' );
            update_post_meta( $product_id, 'oaa_auction_product_post_id', $post->ID );
            update_post_meta( $product_id, 'oaa_auction_animal_post_id', $lot_data[ 'animal' ]->ID );
            update_post_meta( $post->ID, 'oaa_auction_lot_indice', $lot_indice );
        }

        private function create_database_tables() {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            $charset_collate = WPDB->get_charset_collate();
            $prefix          = WPDB->prefix;

            $queries = array(
                'oaa_pre_bids'  => "
                    CREATE TABLE IF NOT EXISTS `{$prefix}oaa_pre_bids` (
                        id bigint NOT NULL AUTO_INCREMENT,
                        user_id bigint NOT NULL,
                        auction_id bigint NOT NULL,
                        bid decimal(32,4) NULL,
                        ip varchar(32) NULL,
                        date timestamp NOT NULL,
                        PRIMARY KEY ( id )
                    ) {$charset_collate}
                "
            );

            foreach( $queries as $query ) {
                dbDelta( $query );
            }
        }

        private function create_user_roles() {
            add_role(
                'simplified_administrator',
                __( 'Simplified Administrator' ),
                array(
                    'read'                      => true,
                    'edit_posts'                => true,
                    'delete_posts'              => true,
                    'publish_posts'             => true,
                    'upload_files'              => true,
                    'create_users'              => true,
                    'delete_users '             => true,
                    'list_users'                => true,
                    'remove_users'              => true,
                    'edit_users'                => true,
                    'manage_categories'         => true,
                    'edit_others_posts'         => true,
                    'edit_published_posts'      => true,
                    'edit_pages'                => true,
                    'edit_others_pages'         => true,
                    'edit_published_pages'      => true,
                    'publish_pages'             => true,
                    'delete_pages'              => true,
                    'delete_others_pages'       => true,
                    'delete_published_pages'    => true,
                    'delete_others_posts'       => true,
                    'delete_private_posts'      => true,
                    'edit_private_posts'        => true,
                    'read_private_posts'        => true,
                    'delete_private_pages'      => true,
                    'edit_private_pages'        => true,
                    'read_private_pages'        => true,
                    'promote_users'             => true,
                    'read_product'              => true,
                    'publish_products'          => true,
                    'manage_woocommerce'        => true,
                    'read_private_products'     => true,
                )
            );

            add_role(
                'assessor',
                __( 'Assessor' ),
                array(
                    'read'  => false,
                )
            );

            // remove_role( 'simplified_administrator' );
        }

        public function remove_menu_pages_for_user_roles() {
            if( is_user_logged_in() ) {

                if( current_user_can( 'simplified_administrator' ) ) {
                    remove_menu_page( 'tools.php' );
                    remove_menu_page( 'wpseo_workouts' );
                    remove_menu_page( 'edit.php?post_type=elementor_library' );
                    remove_menu_page( 'woocommerce-marketing' );
                    remove_menu_page( 'woocommerce' );
                }
            }
        }

        private function create_columns_on_auction_tables() {
            $prefix = WPDB->prefix;

            // Create IP column on auction log table
            if( empty( WPDB->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$prefix}woo_ua_auction_log' AND COLUMN_NAME = 'ip'" ) ) ) {
                WPDB->query( "ALTER TABLE {$prefix}woo_ua_auction_log ADD `ip` varchar(32) NULL" );
            }
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