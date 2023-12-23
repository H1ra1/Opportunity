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

function oaa_get_bids_from_user_on_auction( int $user_id, int $auction_id ): array {
    $table_name = WPDB->prefix . 'woo_ua_auction_log';

    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i AS al WHERE al.userid = %d AND al.auction_id = %d ORDER BY al.date DESC", 
        $table_name,
        WPDB->esc_like( $user_id ),
        WPDB->esc_like( $auction_id ),
    );
    $bids_query = oaa_execute_query( $prepare_query );

    if( $bids_query == null )
        return [];

    $user_data     = get_user_by( 'id', $user_id );
    $bids_data = array();

    foreach( $bids_query as $bid ) {
        $bids_data[] = ( object ) [
            'id'            => $bid->id,
            'user_id'       => $bid->userid,
            'auction_id'    => $bid->auction_id,
            'bid'           => number_format( $bid->bid, 2, ',', '.' ),
            'date'          => date( 'd/m/Y', strtotime( $bid->date ) ),
            'time'          => date( 'H:i:s', strtotime( $bid->date ) ),
            'name'          => $user_data->data->user_nicename,
            'email'         => $user_data->data->user_email,
        ];
    }

    return $bids_data;
}

// Add actions.
add_action( 'wp_ajax_oaa_update_bid_next_bids_values_ajax', 'oaa_update_bid_next_bids_values_ajax' );