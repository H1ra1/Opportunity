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