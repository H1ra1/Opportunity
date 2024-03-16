<?php

function oaa_get_available_auctions() {
    $available_auctions = new WP_Query( array(
        'post_type'         => 'auction',
        'posts_per_page'    => -1,
        'meta_query'        => array(

        )
    ) );

    return $available_auctions;
}

function oaa_get_auction_lot_data( int $auction_id, int $lot_id ) {
    $opening_price = get_post_meta( $lot_id, 'woo_ua_opening_price', true );
    $current_bid   = get_post_meta( $lot_id, 'woo_ua_auction_current_bid', true );
    $lot_indice    = get_post_meta( $auction_id, 'oaa_auction_lot_indice', true );
    $auction_data  = get_field( 'auction', $auction_id );
    $lot_data      = $auction_data[ 'lotes' ][ $lot_indice ];
    $animal_data   = get_field( 'animal', $lot_data[ 'animal' ]->ID );

    $lot_data = array(
        'current_bid'   => ! empty( $current_bid ) ? oaa_format_money( $current_bid ) : oaa_format_money( $opening_price ),
        'url'           => get_permalink( $lot_id ),
        'animal'        => $animal_data,
        'auction'       => $auction_data
    );

    return $lot_data;
}

function oaa_get_bid_next_bids_values( int $auction_product_id, float $last_bid = 0 ) {
    $auction_post_id        = get_post_meta( $auction_product_id, 'oaa_auction_product_post_id', true );
    $auction_post_fields    = get_field( 'auction', $auction_post_id );
    $current_bid            = get_post_meta( $auction_product_id, 'woo_ua_auction_current_bid', true );
    $opening_price          = get_post_meta( $auction_product_id, 'woo_ua_opening_price', true );

    $next_bids = array();
    
    if( ! empty( $auction_post_fields[ 'incremento_de_lances_por_regra' ] ) ) {
        $actual_bid = $last_bid > 0 ? $last_bid : ( $current_bid != null && ! empty( $current_bid ) && $current_bid > 0 ? $current_bid : $opening_price );
        $increment = oaa_get_increment_by_rule( $auction_post_fields[ 'incremento_de_lances_por_regra' ]->ID, $actual_bid );
    } else {
        $increment = $auction_post_fields[ 'incremento_de_lances' ];
    }

    if( $last_bid == 0 ) {
        $current_bid        = $current_bid == null || empty( $current_bid ) ? 0 : $current_bid;

        if( $current_bid == 0 ) {
            $current_increment  = floatval( $opening_price );
        } else {
            $current_increment  = floatval( $current_bid ) + floatval( $increment );
        }
    } else {
        $current_increment = floatval( $last_bid ) + floatval( $increment );
    }

    for ( $i = 0; $i < $auction_post_fields[ 'numero_de_proximos_lances' ]; $i++ ) {
        $next_bids[] = $current_increment;
        $current_increment += floatval( $increment );
    }

    return $next_bids;
}

function oaa_get_current_bid_value( int $auction_product_id ) {
    $current_bid    = get_post_meta( $auction_product_id, 'woo_ua_auction_current_bid', true );
    $opening_price  = get_post_meta( $auction_product_id, 'woo_ua_opening_price', true );
    $formated_value = number_format( isset( $current_bid ) && ! empty( $current_bid ) ? $current_bid : $opening_price, 2, ',', '.' );

    return $formated_value;
}

function oaa_hide_wordpress_admin_bar( $user ){
    return ( current_user_can( 'administrator' ) ) ? $user : false;
}

function oaa_check_outlier_bid_and_pre_bid( int $auction_id, float $next_bid_value, bool $bid = false ): float {

    if( ! $bid ) {
        $table_name = WPDB->prefix . 'oaa_pre_bids';
    
        $prepare_query  = WPDB->prepare( 
            "SELECT * FROM %i AS pb WHERE pb.auction_id = %d ORDER BY pb.date DESC", 
            $table_name,
            WPDB->esc_like( $auction_id ),
        );
    } else {
        $table_name = WPDB->prefix . 'woo_ua_auction_log';
    
        $prepare_query  = WPDB->prepare( 
            "SELECT * FROM %i AS al WHERE al.auction_id = %d ORDER BY al.date DESC", 
            $table_name,
            WPDB->esc_like( $auction_id ),
        );
    }
    $query = oaa_execute_query( $prepare_query );

    if( is_array( $query ) && count( $query ) == 0 )
        return false;

    $last_bid = floatval( $query[ 0 ]->bid );

    $auction_post_id        = get_post_meta( $auction_id, 'oaa_auction_product_post_id', true );
    $auction_bid_increment  = get_field( 'auction', $auction_post_id )[ 'incremento_de_lances' ];
    $next_acceptable_bid    = $last_bid + ( $auction_bid_increment * 1 );

    if( $next_bid_value > $next_acceptable_bid )
        return true;

    return false;
}

function oaa_get_last_bid_and_pre_bid( int $auction_id, bool $user_id = false, bool $bid = false ): bool|object|int {

    if( ! $bid ) {
        $table_name = WPDB->prefix . 'oaa_pre_bids';
    
        $prepare_query  = WPDB->prepare( 
            "SELECT * FROM %i AS pb WHERE pb.auction_id = %d ORDER BY pb.date DESC", 
            $table_name,
            WPDB->esc_like( $auction_id ),
        );
    } else {
        $table_name = WPDB->prefix . 'woo_ua_auction_log';
    
        $prepare_query  = WPDB->prepare( 
            "SELECT * FROM %i AS al WHERE al.auction_id = %d ORDER BY al.date DESC", 
            $table_name,
            WPDB->esc_like( $auction_id ),
        );
    }
    $query = oaa_execute_query( $prepare_query );

    if( is_array( $query ) && count( $query ) == 0 )
        return false;

    $last_bid = $query[ 0 ];

    if( $user_id ) {
        if( $bid ) {
            return $last_bid->userid;
        } else {
            return $last_bid->user_id;
        }
    }

    return $last_bid;
}

function oaa_get_increment_by_rule( int $rule_id, $current_bid ) {
    $rules      = get_field( 'regras_de_incremento', $rule_id );
    $last_rule  = $rules[ count( $rules ) - 1 ];

    if( $current_bid > $last_rule[ 'lances_de_ate' ] )
        return $last_rule[ 'valor_do_incremento' ];

    foreach( $rules as $rule ) {
        if( $current_bid <=  $rule[ 'lances_de_ate' ] ) {
            return $rule[ 'valor_do_incremento' ];
        }
    }
}

function oaa_pre_vet_historic( int $post_id, object $post, bool $update ) {
    if( $post->post_type == 'animal' && ! $update ) {
        $items = [
            [
                'title' => 'Prognata',
                'value' => 0
            ],
            [
                'title' => 'Cirurgia de Cólica',
                'value' => 0
            ],
            [
                'title' => 'Aerofágico',
                'value' => 0
            ],
            [
                'title' => 'Cicatrizes',
                'value' => 0
            ],
            [
                'title' => 'Criptorquídico',
                'value' => 0
            ],
            [
                'title' => 'HYPP',
                'value' => 0
            ],
            [
                'title' => 'Cirurgia de Neurectomia',
                'value' => 0
            ],
            [
                'title' => 'DPOC',
                'value' => 0
            ],
            [
                'title' => 'Já teve Laminite',
                'value' => 0
            ],
            [
                'title' => 'Cirurgia Grave',
                'value' => 0
            ],
        ];

        update_post_meta( $post_id, 'animal_historico_veterinario_data', count( $items ) );

        foreach( $items as $item_index => $item ) {
            add_post_meta( $post_id, "animal_historico_veterinario_data_{$item_index}_titulo", $item[ 'title' ], true );
            add_post_meta( $post_id, "animal_historico_veterinario_data_{$item_index}_valor", $item[ 'value' ], true );
        }
    }
}

// Add filters.
add_filter( 'show_admin_bar' , 'oaa_hide_wordpress_admin_bar');

// Add actions.
add_action( 'wp_insert_post', 'oaa_pre_vet_historic', 10, 3 );