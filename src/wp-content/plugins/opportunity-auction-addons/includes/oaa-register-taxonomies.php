<?php

function oaa_register_taxonomies() {

    // Register the Tipo taxonomy.
    register_taxonomy( 'sexo', 
        array(
            0 => 'animal',
        ), 
        array(
            'labels' => array(
            'name' => 'Sexos',
            'singular_name' => 'Sexo',
            'menu_name' => 'Sexos',
            'all_items' => 'All Sexos',
            'edit_item' => 'Edit Sexo',
            'view_item' => 'View Sexo',
            'update_item' => 'Update Sexo',
            'add_new_item' => 'Add New sexo',
            'new_item_name' => 'New Sexo Name',
            'search_items' => 'Search pelagens',
            'popular_items' => 'Popular pelagens',
            'separate_items_with_commas' => 'Separate pelagens with commas',
            'add_or_remove_items' => 'Add or remove pelagens',
            'choose_from_most_used' => 'Choose from the most used pelagens',
            'not_found' => 'No pelagens found',
            'no_terms' => 'No Sexos',
            'items_list_navigation' => 'Sexos list navigation',
            'items_list' => 'Sexos list',
            'back_to_items' => '← Go to pelagens',
            'item_link' => 'Sexo Link',
            'item_link_description' => 'A link to a pelagens',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the Raça taxonomy.
    register_taxonomy( 'raca', 
        array(
            0 => 'animal',
        ), 
        array(
            'labels' => array(
            'name' => 'Raças',
            'singular_name' => 'Raça',
            'menu_name' => 'Raças',
            'all_items' => 'All Raças',
            'edit_item' => 'Edit Raça',
            'view_item' => 'View Raça',
            'update_item' => 'Update Raça',
            'add_new_item' => 'Add New Raça',
            'new_item_name' => 'New Raça Name',
            'search_items' => 'Search Raças',
            'popular_items' => 'Popular Raças',
            'separate_items_with_commas' => 'Separate raças with commas',
            'add_or_remove_items' => 'Add or remove raças',
            'choose_from_most_used' => 'Choose from the most used raças',
            'not_found' => 'No raças found',
            'no_terms' => 'No raças',
            'items_list_navigation' => 'Raças list navigation',
            'items_list' => 'Raças list',
            'back_to_items' => '← Go to raças',
            'item_link' => 'Raça Link',
            'item_link_description' => 'A link to a raça',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the Raça taxonomy.
    register_taxonomy( 'pelagem', 
        array(
            0 => 'animal',
        ), 
        array(
            'labels' => array(
            'name' => 'Pelagens',
            'singular_name' => 'Pelagem',
            'menu_name' => 'Pelagens',
            'all_items' => 'All Pelagens',
            'edit_item' => 'Edit Pelagem',
            'view_item' => 'View Pelagem',
            'update_item' => 'Update Pelagem',
            'add_new_item' => 'Add New pelagem',
            'new_item_name' => 'New Pelagem Name',
            'search_items' => 'Search pelagens',
            'popular_items' => 'Popular pelagens',
            'separate_items_with_commas' => 'Separate pelagens with commas',
            'add_or_remove_items' => 'Add or remove pelagens',
            'choose_from_most_used' => 'Choose from the most used pelagens',
            'not_found' => 'No pelagens found',
            'no_terms' => 'No Pelagens',
            'items_list_navigation' => 'Pelagens list navigation',
            'items_list' => 'Pelagens list',
            'back_to_items' => '← Go to pelagens',
            'item_link' => 'Pelagem Link',
            'item_link_description' => 'A link to a pelagens',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the Criador taxonomy.
    register_taxonomy( 'criador', 
        array(
            0 => 'animal',
        ), 
        array(
            'labels' => array(
            'name' => 'Criadores',
            'singular_name' => 'Criador',
            'menu_name' => 'Criadores',
            'all_items' => 'All Criadores',
            'edit_item' => 'Edit Criador',
            'view_item' => 'View Criador',
            'update_item' => 'Update Criador',
            'add_new_item' => 'Add New criador',
            'new_item_name' => 'New Criador Name',
            'search_items' => 'Search pelagens',
            'popular_items' => 'Popular pelagens',
            'separate_items_with_commas' => 'Separate pelagens with commas',
            'add_or_remove_items' => 'Add or remove pelagens',
            'choose_from_most_used' => 'Choose from the most used pelagens',
            'not_found' => 'No pelagens found',
            'no_terms' => 'No Criadores',
            'items_list_navigation' => 'Criadores list navigation',
            'items_list' => 'Criadores list',
            'back_to_items' => '← Go to pelagens',
            'item_link' => 'Criador Link',
            'item_link_description' => 'A link to a pelagens',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the Tipo taxonomy.
    register_taxonomy( 'tipo', 
        array(
            0 => 'animal',
        ), 
        array(
            'labels' => array(
            'name' => 'Tipos',
            'singular_name' => 'Tipo',
            'menu_name' => 'Tipos',
            'all_items' => 'All Tipos',
            'edit_item' => 'Edit Tipo',
            'view_item' => 'View Tipo',
            'update_item' => 'Update Tipo',
            'add_new_item' => 'Add New tipo',
            'new_item_name' => 'New Tipo Name',
            'search_items' => 'Search tipo',
            'popular_items' => 'Popular tipo',
            'separate_items_with_commas' => 'Separate tipo with commas',
            'add_or_remove_items' => 'Add or remove tipo',
            'choose_from_most_used' => 'Choose from the most used tipo',
            'not_found' => 'No tipo found',
            'no_terms' => 'No Tipos',
            'items_list_navigation' => 'Tipos list navigation',
            'items_list' => 'Tipos list',
            'back_to_items' => '← Go to tipo',
            'item_link' => 'Tipo Link',
            'item_link_description' => 'A link to a tipo',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the UF taxonomy.
    register_taxonomy( 'uf', 
        array(
            0 => 'animal',
            1 => 'auction',
        ), 
        array(
            'labels' => array(
            'name' => 'UF',
            'singular_name' => 'UF',
            'menu_name' => 'UF',
            'all_items' => 'All UF',
            'edit_item' => 'Edit UF',
            'view_item' => 'View UF',
            'update_item' => 'Update UF',
            'add_new_item' => 'Add New UF',
            'new_item_name' => 'New UF Name',
            'search_items' => 'Search UF',
            'popular_items' => 'Popular UF',
            'separate_items_with_commas' => 'Separate UF with commas',
            'add_or_remove_items' => 'Add or remove UF',
            'choose_from_most_used' => 'Choose from the most used UF',
            'not_found' => 'No UF found',
            'no_terms' => 'No UF',
            'items_list_navigation' => 'UF list navigation',
            'items_list' => 'UF list',
            'back_to_items' => '← Go to UF',
            'item_link' => 'UF Link',
            'item_link_description' => 'A link to a UF',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );

    // Register the Cidade taxonomy.
    register_taxonomy( 'cidade', 
        array(
            0 => 'animal',
            1 => 'auction',
        ), 
        array(
            'labels' => array(
            'name' => 'Cidade',
            'singular_name' => 'Cidade',
            'menu_name' => 'Cidade',
            'all_items' => 'All Cidade',
            'edit_item' => 'Edit Cidade',
            'view_item' => 'View Cidade',
            'update_item' => 'Update Cidade',
            'add_new_item' => 'Add New Cidade',
            'new_item_name' => 'New Cidade Name',
            'search_items' => 'Search Cidade',
            'popular_items' => 'Popular Cidade',
            'separate_items_with_commas' => 'Separate Cidade with commas',
            'add_or_remove_items' => 'Add or remove Cidade',
            'choose_from_most_used' => 'Choose from the most used Cidade',
            'not_found' => 'No Cidade found',
            'no_terms' => 'No Cidade',
            'items_list_navigation' => 'Cidade list navigation',
            'items_list' => 'Cidade list',
            'back_to_items' => '← Go to Cidade',
            'item_link' => 'Cidade Link',
            'item_link_description' => 'A link to a Cidade',
        ),
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ) );
}

// Add actions.
add_action( 'init', 'oaa_register_taxonomies', 5 );