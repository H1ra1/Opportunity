<?php

function oaa_include_once( string $filename = '' ) {
    $file_path = OAA_PATH . $filename;

    if ( file_exists( $file_path ) ) {
        include_once $file_path;
    }
}

function oaa_load_template( string $filename = '', array $args = array() ) {
    $file_path = OAA_PATH . $filename . ".php";

    if ( file_exists( $file_path ) ) {
        include $file_path;
    }
}

function pprint( array | object $content ) {
    print( "<pre>" . print_r( $content, true ) . "</pre>" );
}