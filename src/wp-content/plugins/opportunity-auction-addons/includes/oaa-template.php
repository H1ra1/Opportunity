<?php

function oaa_available_auctions_shorcode() {
    $available_auctions = oaa_get_available_auctions();

    if( $available_auctions->have_posts() ) {
        woocommerce_product_loop_start();
        while ( $available_auctions->have_posts() ) {
            $available_auctions->the_post();

            oaa_load_template( 'templates/oaa-auction-card-template', array( 'teste' ) );
        }
        woocommerce_product_loop_end();
    } else {
        wc_get_template( 'loop/no-products-found.php' );
    }

    wp_reset_postdata();
    // pprint( $available_auctions );
}

// Add shortcodes
add_shortcode( 'oaa_available_auctions', 'oaa_available_auctions_shorcode' );