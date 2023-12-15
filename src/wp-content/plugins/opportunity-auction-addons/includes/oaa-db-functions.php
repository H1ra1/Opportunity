<?php

function oaa_table_exists( string $table_name ): bool {
    $table_name = WPDB->prefix . $table_name;

    $query = WPDB->prepare( 'SHOW TABLES LIKE %i', $table_name );

    if( ! WPDB->get_var( $query ) == $table_name )
        return false;

    return true;
}

function oaa_insert_on_table( string $table_name, array $data ): string | array {

    // Check if table exists by name.
    if( ! oaa_table_exists( $table_name ) )
        return 'Table do not exists.';

    $table_name = WPDB->prefix . $table_name;

    $inser_rows = WPDB->insert( $table_name, $data );

    return ! empty( WPDB->last_error ) ? WPDB->last_error : array(
        'id'    =>  WPDB->insert_id,
        'rows'  => $inser_rows
    );
}

function oaa_get_all_from_table( string $table_name ): array | object | null {

    // Check if table exists by name.
    if( ! oaa_table_exists( $table_name ) )
        return false;

    $table_name = WPDB->prefix . $table_name;

    $query          = WPDB->prepare( 'SELECT * FROM %i', $table_name );
    $query_results  = WPDB->get_results( $query );

    return $query_results;
}

function oaa_execute_query( string $prepare_query ): array | object | null {
    $query_results = WPDB->get_results( $prepare_query );

    return $query_results;
}