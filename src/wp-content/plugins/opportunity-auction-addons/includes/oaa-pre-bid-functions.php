<?php

function oaa_new_pre_bid( int $user_id, int $auction_id, float $bid ): string | bool {
    $user       = get_user_by( 'id', $user_id );
    $auction    = get_post( $auction_id );

    if( ! $user instanceof WP_User || ! $auction instanceof WP_Post || $auction->post_type != 'product' )
        return false;

    $pre_bid_already_made = oaa_pre_bid_already_made( $user_id, $auction_id, $bid );

    if( $pre_bid_already_made )
        return 'Pre bid with this value is already made.';

    $inset_on_db = oaa_insert_on_table( 'oaa_pre_bids', array(
        'user_id'       => $user->ID,
        'auction_id'    => $auction->ID,
        'bid'           => $bid,
        'date'          => date( 'y-m-d H:i:s' )
    ) );

    if( is_string( $inset_on_db ) )
        return $inset_on_db;

    return true;
}

function oaa_get_pre_bids_from_user_on_auction( int $user_id, int $auction_id ): array | bool {
    $table_name = WPDB->prefix . 'oaa_pre_bids';

    $prepare_query  = WPDB->prepare( 
        "SELECT * FROM %i WHERE user_id = %d AND auction_id = %d", 
        $table_name,
        WPDB->esc_like( $user_id ),
        WPDB->esc_like( $auction_id ),
    );
    $pre_bids_query = oaa_execute_query( $prepare_query );

    if( $pre_bids_query == null )
        return false;

    $user_data     = get_user_by( 'id', $user_id );
    $pre_bids_data = array();

    foreach( $pre_bids_query as $pre_bid ) {
        $pre_bids_data[] = ( object ) [
            'id'            => $pre_bid->id,
            'user_id'       => $pre_bid->user_id,
            'auction_id'    => $pre_bid->auction_id,
            'bid'           => number_format( $pre_bid->bid, 2 ),
            'date'          => date( 'd/m/y H:i:s', strtotime( $pre_bid->date ) ),
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