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

    if( $last_bid == 0 ) {
        $current_bid        = $current_bid == null || empty( $current_bid ) ? 0 : $current_bid;

        if( $current_bid == 0 ) {
            $current_increment  = floatval( $opening_price );
        } else {
            $current_increment  = floatval( $current_bid ) + floatval( $auction_post_fields[ 'incremento_de_lance' ] );
        }
    } else {
        $current_increment = floatval( $last_bid ) + floatval( $auction_post_fields[ 'incremento_de_lance' ] );
    }

    for ( $i = 0; $i < $auction_post_fields[ 'numero_de_proximos_lances' ]; $i++ ) {
        $next_bids[] = $current_increment;
        $current_increment += floatval( $auction_post_fields[ 'incremento_de_lance' ] );
    }

    return $next_bids;
}