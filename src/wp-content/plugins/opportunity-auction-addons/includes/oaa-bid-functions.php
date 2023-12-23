<?php

function oaa_update_bid_next_bids_values_ajax() {
    if( wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        $last_bid_value     = esc_html( $_POST[ 'last_bid_value' ] );
        $auction_product_id = esc_html( $_POST[ 'auction_product_id' ] );

        $next_bids = oaa_get_bid_next_bids_values( $auction_product_id, $last_bid_value );


        update_post_meta( $auction_product_id, 'woo_ua_opening_price', $last_bid_value );
        update_post_meta( $auction_product_id, 'woo_ua_auction_current_bid', $last_bid_value );

        wp_send_json( array( 
            'next_bids'         => $next_bids, 
            'last_bid_value'    => $last_bid_value,
            'current_bid'       => number_format( $last_bid_value, 2, ',', '.' )
        ), 200 );
    }

    wp_die();
}

// Add actions.
add_action( 'wp_ajax_oaa_update_bid_next_bids_values_ajax', 'oaa_update_bid_next_bids_values_ajax' );