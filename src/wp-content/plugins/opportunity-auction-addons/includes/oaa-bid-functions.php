<?php

function oaa_get_bids_on_auction( int $auction_id ): array {
    $table_name     = WPDB->prefix . 'woo_ua_auction_log';
    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i AS al WHERE al.auction_id = %d ORDER BY al.date DESC", 
        $table_name,
        WPDB->esc_like( $auction_id ),
    );
    $bids_query     = oaa_execute_query( $prepare_query );

    if( $bids_query == null )
        return [];

    $bids_data = array();
    
    foreach( $bids_query as $bid ) {
        $user_data   = get_user_by( 'id', $bid->userid );
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

function oaa_get_user_last_bid( int $user_id, int $auction_id ): object | null {
    $table_name     = WPDB->prefix . 'woo_ua_auction_log';
    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i AS al WHERE al.userid = %d AND al.auction_id = %d ORDER BY al.date DESC LIMIT 1",
        $table_name,
        $user_id, 
        $auction_id 
    );
    $query_results  = WPDB->get_row( $prepare_query );

    return $query_results;
}

function oaa_update_user_ip_last_bid( int $user_id, int $auction_id ): string | bool {
    date_default_timezone_set( 'America/Sao_Paulo' );

    $user_last_bid = oaa_get_user_last_bid( $user_id, $auction_id );
    
    if( $user_last_bid == null )
        return "Not last bid found.";
    
    $prefix = WPDB->prefix;
    
    // Execute query.
    WPDB->query( WPDB->prepare( "UPDATE {$prefix}woo_ua_auction_log as al SET al.ip = %s, al.date = %s WHERE al.id = %d", oaa_get_user_ip(), date( 'y-m-d H:i:s' ),$user_last_bid->id ) );

    if( ! empty( WPDB->last_error ) )
        return WPDB->last_error;

    return true;
}

// Ajax functions.

function oaa_update_bid_next_bids_values_ajax() {
    if( wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        $last_bid_value     = esc_html( $_POST[ 'last_bid_value' ] );
        $auction_product_id = esc_html( $_POST[ 'auction_product_id' ] );
        $is_bid             = esc_html( $_POST[ 'is_bid' ] );
        $current_user_id    = get_current_user_id();
        $next_bids          = oaa_get_bid_next_bids_values( $auction_product_id, $last_bid_value );

        update_post_meta( $auction_product_id, 'woo_ua_opening_price', $last_bid_value );
        update_post_meta( $auction_product_id, 'woo_ua_auction_current_bid', $last_bid_value );

        if( $is_bid )
            oaa_update_user_ip_last_bid( $current_user_id, $auction_product_id );

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