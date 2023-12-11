<?php

function oaa_available_auctions_shorcode() {
    $available_auctions = oaa_get_available_auctions();
    $template_cards     = [];

    if( $available_auctions->have_posts() ) {
        while ( $available_auctions->have_posts() ) {
            $available_auctions->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_url = get_permalink();
            $auction_fields   = get_field( 'auction', $post_id );
            $template_cards[] = oaa_load_template( 'templates/oaa-auction-card-template', array( 
                'auction_fields'    => $auction_fields, 
                'id'                => $post_id,
                'title'             => $post_title, 
                'url'               => $post_url ) 
            );
        }

        oaa_get_template( 'templates/oaa-auction-cards-container-template', array( 'cards' => $template_cards ) );
    } else {
        wc_get_template( 'loop/no-products-found.php' );
    }

    wp_reset_postdata();
}

function oaa_single_auction_template( $single ) {
    global $post;
    $file_path = OAA_PATH . '/templates/oaa-single-auction-template.php';

    // Checks for single template by post type.
    if ( $post->post_type == 'auction' ) {
        if ( file_exists( $file_path ) ) {
            return $file_path;
        }
    }

    return $single;

}

// Add shortcodes.
add_shortcode( 'oaa_available_auctions', 'oaa_available_auctions_shorcode' );

// Add filters.
add_filter( 'single_template', 'oaa_single_auction_template' );