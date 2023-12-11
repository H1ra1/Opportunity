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

            // Include utility functions.
            include_once OAA_PATH . 'includes/oaa-utility-functions.php';

            // Include functions.
            oaa_include_once( 'includes/oaa-functions.php' );
            oaa_include_once( 'includes/oaa-template.php' );

            // Add actions.
            add_action( 'init', array( $this, 'register_post_types' ), 5 );
            add_action( 'init', array( $this, 'create_pages' ), 10 );
            add_action( 'acf/include_fields', array( $this, 'add_acf_fields' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_admin' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'save_post', array( $this, 'save_post_auction' ), 10, 3 );
        }

        public function register_post_types() {
            // Register the Animal post type.
            register_post_type( 'animal', 
                array(
                    'labels'            => array(
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
                    'public'            => true,
                    'show_in_rest'      => true,
                    'supports'          => array(
                        0 => 'title',
                        1 => 'editor',
                        2 => 'thumbnail',
                    ),
                    'delete_with_user'  => false,
                    'menu_icon'         => 'dashicons-buddicons-activity'
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

        public function add_acf_fields() {
            if ( ! function_exists( 'acf_add_local_field_group' ) ) {
                return;
            }
            
            acf_add_local_field_group( array(
                'key' => 'group_6574f2c60d1fb',
                'title' => 'Auctions',
                'fields' => array(
                    array(
                        'key' => 'field_6574f2c661bcd',
                        'label' => '',
                        'name' => 'auction',
                        'aria-label' => '',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_657610e2693b4',
                                'label' => 'Capa do leilão',
                                'name' => 'capa_do_leilao',
                                'aria-label' => '',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                                'preview_size' => 'medium',
                            ),
                            array(
                                'key' => 'field_6576114c693b5',
                                'label' => 'Condições de pagamento( EX:	2+2+2+2+2+30 )',
                                'name' => 'condicoes_de_pagamento',
                                'aria-label' => '',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'maxlength' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                            ),
                            array(
                                'key' => 'field_6575148b8b31b',
                                'label' => 'Incremento de Lance',
                                'name' => 'incremento_de_lance',
                                'aria-label' => '',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => 10,
                                'min' => '',
                                'max' => '',
                                'placeholder' => '',
                                'step' => '',
                                'prepend' => '',
                                'append' => '',
                            ),
                            array(
                                'key' => 'field_657514ee8b31d',
                                'label' => 'Data de Início',
                                'name' => 'data_de_inicio',
                                'aria-label' => '',
                                'type' => 'date_time_picker',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'display_format' => 'd/m/Y H:i:s',
                                'return_format' => 'Y-m-d H:i:s',
                                'first_day' => 1,
                            ),
                            array(
                                'key' => 'field_657515158b31e',
                                'label' => 'Data de Término',
                                'name' => 'data_de_termino',
                                'aria-label' => '',
                                'type' => 'date_time_picker',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '47',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'display_format' => 'd/m/Y H:i:s',
                                'return_format' => 'Y-m-d H:i:s',
                                'first_day' => 1,
                            ),
                            array(
                                'key' => 'field_6574f3da61bce',
                                'label' => 'Lotes',
                                'name' => 'lotes',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'layout' => 'block',
                                'pagination' => 0,
                                'min' => 0,
                                'max' => 0,
                                'collapsed' => 'field_657515992ce48',
                                'button_label' => 'Adicionar Lote',
                                'rows_per_page' => 20,
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_657515992ce48',
                                        'label' => '#Lote ID',
                                        'name' => 'lote_id',
                                        'aria-label' => '',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => 'disabled-input',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'min' => '',
                                        'max' => '',
                                        'placeholder' => '',
                                        'step' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                    array(
                                        'key' => 'field_6574f94261bcf',
                                        'label' => 'Número do Lote',
                                        'name' => 'numero_do_lote',
                                        'aria-label' => '',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'min' => '',
                                        'max' => '',
                                        'placeholder' => '',
                                        'step' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                    array(
                                        'key' => 'field_6574f99661bd0',
                                        'label' => 'Preço de Abertura (R$)',
                                        'name' => 'preco_de_abertura',
                                        'aria-label' => '',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '33',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'min' => '',
                                        'max' => '',
                                        'placeholder' => '',
                                        'step' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                    array(
                                        'key' => 'field_6574f9cb61bd1',
                                        'label' => 'Menor Preço para Aceitar (R$)',
                                        'name' => 'menor_preco_para_aceitar',
                                        'aria-label' => '',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '33',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'min' => '',
                                        'max' => '',
                                        'placeholder' => '',
                                        'step' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                    array(
                                        'key' => 'field_657514b68b31c',
                                        'label' => 'Preço Venda Imediata (R$)',
                                        'name' => 'preco_venda_imediata',
                                        'aria-label' => '',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '33',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'min' => '',
                                        'max' => '',
                                        'placeholder' => '',
                                        'step' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                    array(
                                        'key' => 'field_65755c689f0b0',
                                        'label' => 'Animal',
                                        'name' => 'animal',
                                        'aria-label' => '',
                                        'type' => 'post_object',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'post_type' => array(
                                            0 => 'animal',
                                        ),
                                        'post_status' => array(
                                            0 => 'publish',
                                        ),
                                        'taxonomy' => '',
                                        'return_format' => 'object',
                                        'multiple' => 0,
                                        'allow_null' => 0,
                                        'bidirectional' => 0,
                                        'ui' => 1,
                                        'bidirectional_target' => array(
                                        ),
                                        'parent_repeater' => 'field_6574f3da61bce',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'auction',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'acf_after_title',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => array(
                    0 => 'the_content',
                    1 => 'excerpt',
                    2 => 'discussion',
                    3 => 'comments',
                    4 => 'revisions',
                    5 => 'slug',
                    6 => 'author',
                    7 => 'format',
                    8 => 'page_attributes',
                    9 => 'featured_image',
                    10 => 'categories',
                    11 => 'tags',
                    12 => 'send-trackbacks',
                ),
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ) );
            
            acf_add_local_field_group( array(
                'key' => 'group_6574e813ae33c',
                'title' => 'Animal',
                'fields' => array(
                    array(
                        'key' => 'field_6574e8147d2a9',
                        'label' => '',
                        'name' => 'animal',
                        'aria-label' => '',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_6574e9797d2aa',
                                'label' => 'Dados Gerais',
                                'name' => '',
                                'aria-label' => '',
                                'type' => 'tab',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'placement' => 'top',
                                'endpoint' => 0,
                            ),
                            array(
                                'key' => 'field_6574eb5ecc025',
                                'label' => '',
                                'name' => 'dados_gerais',
                                'aria-label' => '',
                                'type' => 'group',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'layout' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_6574eb8acc026',
                                        'label' => 'Sexo',
                                        'name' => 'sexo',
                                        'aria-label' => '',
                                        'type' => 'select',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'choices' => array(
                                            'macho' => 'Macho',
                                            'femea' => 'Fêmea',
                                        ),
                                        'default_value' => 'macho',
                                        'return_format' => 'value',
                                        'multiple' => 0,
                                        'allow_null' => 0,
                                        'ui' => 0,
                                        'ajax' => 0,
                                        'placeholder' => '',
                                    ),
                                    array(
                                        'key' => 'field_6574ebcecc028',
                                        'label' => 'Pelagem',
                                        'name' => 'pelagem',
                                        'aria-label' => '',
                                        'type' => 'select',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'choices' => array(
                                        ),
                                        'default_value' => false,
                                        'return_format' => 'value',
                                        'multiple' => 0,
                                        'allow_null' => 0,
                                        'ui' => 0,
                                        'ajax' => 0,
                                        'placeholder' => '',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_6574e9867d2ab',
                                'label' => 'Fotos',
                                'name' => '',
                                'aria-label' => '',
                                'type' => 'tab',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'placement' => 'top',
                                'endpoint' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'animal',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'acf_after_title',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => array(
                    0 => 'permalink',
                    1 => 'the_content',
                    2 => 'excerpt',
                    3 => 'discussion',
                    4 => 'comments',
                    5 => 'revisions',
                    6 => 'slug',
                    7 => 'author',
                    8 => 'format',
                    9 => 'page_attributes',
                    10 => 'featured_image',
                    11 => 'categories',
                    12 => 'tags',
                    13 => 'send-trackbacks',
                ),
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ) );           
        }

        public function create_pages() {

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
            wp_enqueue_script( 'oaa-admin-scripts', OAA_URL . "assets/js/oaa-admin.js", array( 'jquery' ), $this->version );
        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'oaa-styles', OAA_URL . "assets/css/oaa.min.css", array(), $this->version );
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
                    $product_id = $this->create_auction_product( $lote, $auction_configs, $post );
                } else {
                    $product_id = $lote[ 'lote_id' ];
                    $this->update_auction_product( $lote[ 'lote_id' ], $lote, $auction_configs, $post );
                }

                // Add on Auction array data the product id on lote id field.
                $auction_configs[ 'lotes' ][ $indice ][ 'lote_id' ] = $product_id;
            }

            // Update acf field product ID
            update_field( 'auction', $auction_configs, $post_id );
            
            // wp_die();
        }

        private function create_auction_product( array $auction_data, array $auction_configs, WP_Post $post ) {

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
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_configs[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_configs[ 'data_de_inicio' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_configs[ 'data_de_termino' ] );

            return $product_id;
        }

        private function update_auction_product( int $product_id, array $auction_data, array $auction_configs, WP_Post $post ) {

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
            update_post_meta( $product_id, 'woo_ua_bid_increment', $auction_configs[ 'incremento_de_lance' ] );
            update_post_meta( $product_id, 'woo_ua_auction_start_date', $auction_configs[ 'data_de_inicio' ] );
            update_post_meta( $product_id, 'woo_ua_auction_end_date', $auction_configs[ 'data_de_termino' ] );
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