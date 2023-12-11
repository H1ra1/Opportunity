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

function oaa_get_auction_lot_data( int $lot_id ) {
    $opening_price = get_post_meta( $lot_id, 'woo_ua_opening_price' );
    $current_bid   = get_post_meta( $lot_id, 'woo_ua_auction_current_bid' );
    $lot_data = array(
        'current_bid'   => ! empty( $current_bid ) ? $current_bid : $opening_price,
        'url'           => get_permalink( $lot_id )
    );

    return $lot_data;
}