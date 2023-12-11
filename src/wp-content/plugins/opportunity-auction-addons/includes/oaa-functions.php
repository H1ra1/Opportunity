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