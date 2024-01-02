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

function oaa_now_date_equal_or_bigger( string $date ) {
    $date_now   = new DateTime( 'now', new DateTimeZone( 'America/Sao_Paulo' ) );
    $date       = new DateTime( $date, new DateTimeZone( 'America/Sao_Paulo' ) );

    if( $date_now >= $date )
        return true;

    return false;
}

function oaa_remove_filters_with_method_name( $hook_name = '', $method_name = '', $priority = 0 ) {
    global $wp_filter;

    if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
        return false;
    }

    foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
        if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
            if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && $filter_array['function'][1] == $method_name ) {

                if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
                    unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
                } else {
                    unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
                }
            }
        }
    }
    return false;
}

function oaa_translate_day_name( string $day ) {
    switch ( $day ) {
        case 'Monday':
            return 'Segunda-feira';
            break;
        case 'Tuesday':
            return 'Terca-feira';
            break;
        case 'Wednesday':
            return 'Quarta-feira';
            break;
        case 'Thursday':
            return 'Quinta-feira';
            break;
        case 'Friday':
            return 'Sexta-feira';
            break;
        case 'Saturday':
            return 'Sábado';
            break;
        case 'Sunday':
            return 'Domingo';
            break;
    }
}

function oaa_get_yt_video_id( string $url ) {
    preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match );

    return $match[1];
}

function oaa_get_user_ip() {
    $user_ip = array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER ) && ! empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ? $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] : $_SERVER[ 'REMOTE_ADDR' ];

    return $user_ip;
}