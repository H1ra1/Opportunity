<?php

function oaa_new_pre_bid( int $user_id, int $auction_id, float $bid ): string | bool {
    $user       = get_user_by( 'id', $user_id );
    $auction    = get_post( $auction_id );

    if( ! $user instanceof WP_User || ! $auction instanceof WP_Post || $auction->post_type != 'product' )
        return false;

    $pre_bid_already_made = oaa_pre_bid_already_made( $user_id, $auction_id, $bid );

    if( $pre_bid_already_made )
        return 'Pre bid with this value is already made.';

    $pre_bid_is_open = oaa_check_if_pre_bid_is_open( $auction_id );

    if( ! $pre_bid_is_open )
        return 'Pre bid is not longer open.';

    $inset_on_db = oaa_insert_on_table( 'oaa_pre_bids', array(
        'user_id'       => $user->ID,
        'auction_id'    => $auction->ID,
        'bid'           => $bid,
        'date'          => date( 'y-m-d H:i:s' )
    ) );

    if( is_string( $inset_on_db ) )
        return $inset_on_db;

    $pre_bid_count = get_post_meta( $auction->ID, 'oaa_auction_pre_bid_count', true );

    update_post_meta( $auction->ID, 'oaa_auction_pre_bid_count', ! empty( $pre_bid_count ) ? $pre_bid_count + 1 : 1 );

    return true;
}

function oaa_get_pre_bids_from_user_on_auction( int $user_id, int $auction_id ): array {
    $table_name = WPDB->prefix . 'oaa_pre_bids';

    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i AS pb WHERE pb.user_id = %d AND pb.auction_id = %d ORDER BY pb.date DESC", 
        $table_name,
        WPDB->esc_like( $user_id ),
        WPDB->esc_like( $auction_id ),
    );
    $pre_bids_query = oaa_execute_query( $prepare_query );

    if( $pre_bids_query == null )
        return [];

    $user_data     = get_user_by( 'id', $user_id );
    $pre_bids_data = array();

    foreach( $pre_bids_query as $pre_bid ) {
        $pre_bids_data[] = ( object ) [
            'id'            => $pre_bid->id,
            'user_id'       => $pre_bid->user_id,
            'auction_id'    => $pre_bid->auction_id,
            'bid'           => number_format( $pre_bid->bid, 2, ',', '.' ),
            'date'          => date( 'd/m/Y', strtotime( $pre_bid->date ) ),
            'time'          => date( 'H:i:s', strtotime( $pre_bid->date ) ),
            'name'          => $user_data->data->user_nicename,
            'email'         => $user_data->data->user_email,
        ];
    }

    return $pre_bids_data;
}

function oaa_pre_bid_already_made( int $user_id, int $auction_id, float $bid ): bool {
    $table_name = WPDB->prefix . 'oaa_pre_bids';

    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i WHERE user_id = %d AND auction_id = %d AND bid = %d", 
        $table_name,
        WPDB->esc_like( $user_id ),
        WPDB->esc_like( $auction_id ),
        WPDB->esc_like( $bid ),
    );
    $pre_bids_query = oaa_execute_query( $prepare_query );

    if( $pre_bids_query == null )
        return false;

    return true;
}

function oaa_check_if_pre_bid_is_open( int $id, bool $product_id = true ): bool {
    if( $product_id ) {
        $auction_post_id        = get_post_meta( $id, 'oaa_auction_product_post_id', true );
    } else {
        $auction_post_id        = $id;
    }
    
    $auction_post_fields    = get_field( 'auction', $auction_post_id );
    $pre_bid_date_open      = oaa_now_date_equal_or_bigger( $auction_post_fields[ 'data_de_inicio_pre_lances' ] );
    $pre_bid_date_close     = oaa_now_date_equal_or_bigger( $auction_post_fields[ 'data_de_termino_pre_lances' ] );
    $pre_bid_open           = $pre_bid_date_open && ! $pre_bid_date_close ? true : false;

    return $pre_bid_open;
}

// Ajax functions.

function oaa_new_pre_bid_ajax() {
    if( wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        $bid_value          = esc_html( $_POST[ 'bid_value' ] );
        $auction_product_id = esc_html( $_POST[ 'auction_product_id' ] );

        if( ! is_user_logged_in() )
            wp_send_json( array( 'success' => false, 'message' => 'User not logged in.' ), 500 );

        $current_user_id    = get_current_user_id();
        $pre_bid            = oaa_new_pre_bid( $current_user_id, $auction_product_id, $bid_value );

        if( is_string( $pre_bid ) )
            wp_send_json( array( 'success' => false, 'message' => $pre_bid ), 500 );

        wp_send_json( array( 'success' => true, 'message' => 'Pre bid included!' ), 200 );
    }

    wp_die();
}

// Add actions.
add_action( 'wp_ajax_oaa_new_pre_bid_ajax', 'oaa_new_pre_bid_ajax' );