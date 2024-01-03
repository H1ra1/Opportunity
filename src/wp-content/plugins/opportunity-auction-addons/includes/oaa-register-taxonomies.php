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
            'all_items' => 'Todos Sexos',
            'edit_item' => 'Editar Sexo',
            'view_item' => 'Ver Sexo',
            'update_item' => 'Atualizar Sexo',
            'add_new_item' => 'Adicionar novo sexo',
            'new_item_name' => 'Novo Sexo',
            'search_items' => 'Buscar sexos',
            'popular_items' => 'Populares sexos',
            'separate_items_with_commas' => 'Separate sexos with commas',
            'add_or_remove_items' => 'Adicionar ou remover sexos',
            'choose_from_most_used' => 'Choose from the most used sexos',
            'not_found' => 'Nenhum sexo encontrado',
            'no_terms' => 'Nenhum Sexo',
            'items_list_navigation' => 'Sexos list navigation',
            'items_list' => 'Sexos list',
            'back_to_items' => '← Go to sexos',
            'item_link' => 'Sexo Link',
            'item_link_description' => 'A link to a sexos',
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
            'all_items' => 'Todas Raças',
            'edit_item' => 'Editar Raça',
            'view_item' => 'Ver Raça',
            'update_item' => 'Atualizar Raça',
            'add_new_item' => 'Adicionar nova Raça',
            'new_item_name' => 'Nova Raça',
            'search_items' => 'Buscar Raças',
            'popular_items' => 'Populares Raças',
            'separate_items_with_commas' => 'Separate raças with commas',
            'add_or_remove_items' => 'Adicionar ou remover raças',
            'choose_from_most_used' => 'Choose from the most used raças',
            'not_found' => 'Nenhhuma raça encontrada',
            'no_terms' => 'Nenhhuma raça',
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
            'all_items' => 'Todas Pelagens',
            'edit_item' => 'Editar Pelagem',
            'view_item' => 'Ver Pelagem',
            'update_item' => 'Atualizar Pelagem',
            'add_new_item' => 'Adicionar nova pelagem',
            'new_item_name' => 'Nova Pelagem',
            'search_items' => 'Buscar pelagens',
            'popular_items' => 'Populares pelagens',
            'separate_items_with_commas' => 'Separate pelagens with commas',
            'add_or_remove_items' => 'Adicionar ou remover pelagens',
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
            'all_items' => 'Todos Criadores',
            'edit_item' => 'Editar Criador',
            'view_item' => 'Ver Criador',
            'update_item' => 'Atualizar Criador',
            'add_new_item' => 'Adicionar novo criador',
            'new_item_name' => 'Novo Criador',
            'search_items' => 'Buscar criadores',
            'popular_items' => 'Populares criadores',
            'separate_items_with_commas' => 'Separate criadores with commas',
            'add_or_remove_items' => 'Adicionar ou remover criadores',
            'choose_from_most_used' => 'Choose from the most used criadores',
            'not_found' => 'Nenhhum criadore encontrado',
            'no_terms' => 'Nenhhum Criadore',
            'items_list_navigation' => 'Criadores list navigation',
            'items_list' => 'Criadores list',
            'back_to_items' => '← Go to criadores',
            'item_link' => 'Criador Link',
            'item_link_description' => 'A link to a criadores',
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
            'all_items' => 'Todos Tipos',
            'edit_item' => 'Editar Tipo',
            'view_item' => 'Ver Tipo',
            'update_item' => 'Atualizar Tipo',
            'add_new_item' => 'Adicionar novo tipo',
            'new_item_name' => 'Novo Tipo',
            'search_items' => 'Buscar tipo',
            'popular_items' => 'Populares tipo',
            'separate_items_with_commas' => 'Separate tipo with commas',
            'add_or_remove_items' => 'Adicionar ou remover tipo',
            'choose_from_most_used' => 'Choose from the most used tipo',
            'not_found' => 'Nenhum tipo encontrado',
            'no_terms' => 'Nenhum Tipo',
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
            'all_items' => 'Todos UF',
            'edit_item' => 'Editar UF',
            'view_item' => 'Ver UF',
            'update_item' => 'Atualizar UF',
            'add_new_item' => 'Adicionar novo UF',
            'new_item_name' => 'Novo UF',
            'search_items' => 'Buscar UF',
            'popular_items' => 'Populares UF',
            'separate_items_with_commas' => 'Separate UF with commas',
            'add_or_remove_items' => 'Adicionar ou remover UF',
            'choose_from_most_used' => 'Choose from the most used UF',
            'not_found' => 'Nenhum UF encontrado',
            'no_terms' => 'Nenhum UF',
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
            'all_items' => 'Todas Cidade',
            'edit_item' => 'Editar Cidade',
            'view_item' => 'Ver Cidade',
            'update_item' => 'Atualizar Cidade',
            'add_new_item' => 'Adicionar nova Cidade',
            'new_item_name' => 'Nova Cidade',
            'search_items' => 'Buscar Cidade',
            'popular_items' => 'Populares Cidade',
            'separate_items_with_commas' => 'Separate Cidade with commas',
            'add_or_remove_items' => 'Adicionar ou remover Cidade',
            'choose_from_most_used' => 'Choose from the most used Cidade',
            'not_found' => 'Nenhuma Cidade encontrada',
            'no_terms' => 'Nenhuma Cidade',
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