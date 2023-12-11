<?php

function oaa_include_once( string $filename = '' ) {
    $file_path = OAA_PATH . $filename;

    if ( file_exists( $file_path ) ) {
        include_once $file_path;
    }
}

function oaa_get_template( string $filename = '', array $args = array() ) {
    $file_path = OAA_PATH . $filename . ".php";

    if ( file_exists( $file_path ) ) {
        include $file_path;
    }
}

function oaa_load_template( string $filename = '', array $args = array() ) {
    ob_start();
    oaa_get_template( $filename, $args );
    $template = ob_get_contents();
    ob_end_clean();

    return $template;
}

function pprint( array | object $content ) {
    print( "<pre>" . print_r( $content, true ) . "</pre>" );
}

function oaa_format_date( string $str ) {
    $timestamp = strtotime( $str );
    $date = date( 'd/m/Y H:i:s', $timestamp );

    return $date;
}

function oaa_format_date_only( string $str ) {
    $timestamp = strtotime( $str );
    $date = date( 'd/m/Y', $timestamp );

    return $date;
}

function oaa_format_time_only( string $str ) {
    $timestamp = strtotime( $str );
    $time = date( 'H:i', $timestamp );

    return $time;
}

function oaa_format_money( $number ) {
    $number = ( double ) $number;
    $format = number_format( $number, 2, ",", "." );

    return $format;
}