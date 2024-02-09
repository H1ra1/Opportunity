<?php

function oaa_custom_login_page( $templates ) {
   $templates[ OAA_PATH . 'templates/pages/oaa-login.php' ] = __( 'OAA Custom Login Page', 'text-domain' );

   return $templates;
}

function oaa_selected_template( $template ){
    global $wp_query;
    $template_selected = get_page_template_slug( $wp_query->post->ID );

    return ! empty( $template_selected ) ? $template_selected : $template;   
}


// Add filters.
add_filter( 'theme_page_templates', 'oaa_custom_login_page' );
add_filter( 'template_include', 'oaa_selected_template' );