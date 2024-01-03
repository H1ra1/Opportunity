<?php

function oaa_register_post_types() {
    // Register the Animal post type.
    register_post_type( 'animal', 
        array(
            'labels'            => array(
                'name' => 'Animais',
                'singular_name' => 'Animal',
                'menu_name' => 'Animais',
                'all_items' => 'Todos Animais',
                'edit_item' => 'Editar Animal',
                'view_item' => 'Ver Animal',
                'view_items' => 'Ver Animais',
                'add_new_item' => 'Adicionar novo Animal',
                'add_new' => 'Adicionar novo Animal',
                'new_item' => 'Novo Animal',
                'parent_item_colon' => 'Parent Animal:',
                'search_items' => 'Buscar Animais',
                'not_found' => 'Nenhum Animal Encontrado',
                'not_found_in_trash' => 'Nenhum Animal encontrado na lixeira',
                'archives' => 'Animal Archives',
                'attributes' => 'Animal Atributos',
                'insert_into_item' => 'Insert into animal',
                'uploaded_to_this_item' => 'Uploaded to this animal',
                'filter_items_list' => 'Filter Animais list',
                'filter_by_date' => 'Filter Animais by date',
                'items_list_navigation' => 'Animais list navigation',
                'items_list' => 'Animais list',
                'item_published' => 'Animal publicado.',
                'item_published_privately' => 'Animal publicado privadamente.',
                'item_reverted_to_draft' => 'Animal revertido para rascunho.',
                'item_scheduled' => 'Animal agendado.',
                'item_updated' => 'Animal atualizado.',
                'item_link' => 'Animal Link',
                'item_link_description' => 'A link to a animal.',
            ),
            'public'            => true,
            'show_in_rest'      => true,
            'supports'          => array(
                0 => 'title',
                1 => 'editor',
                2 => 'thumbnail',
            ),
            'delete_with_user'  => false,
            'menu_icon'         => 'dashicons-buddicons-activity'
        ) 
    );

    // Register the Auction post type.
    register_post_type( 'auction', 
        array(
            'labels'            => array(
                'name' => 'Leilões',
                'singular_name' => 'Leilão',
                'menu_name' => 'Leilões',
                'all_items' => 'Todos Leilões',
                'edit_item' => 'Editar Leilão',
                'view_item' => 'Ver Leilão',
                'view_items' => 'Ver Leilões',
                'add_new_item' => 'Adicioanr novo Leilão',
                'add_new' => 'Adicioanr novo Leilão',
                'new_item' => 'Novo Leilão',
                'parent_item_colon' => 'Parent Leilão:',
                'search_items' => 'Buscar Leilões',
                'not_found' => 'Nenhum Leilão encontrado',
                'not_found_in_trash' => 'Nenhum Leilão encontrado na lixeira',
                'archives' => 'Leilão Archives',
                'attributes' => 'Leilão Atributos',
                'insert_into_item' => 'Insert into Leilão',
                'uploaded_to_this_item' => 'Uploaded to this leilão',
                'filter_items_list' => 'Filter Leilões list',
                'filter_by_date' => 'Filter Leilões by date',
                'items_list_navigation' => 'Leilões list navigation',
                'items_list' => 'Leilões list',
                'item_published' => 'Leilão publicado.',
                'item_published_privately' => 'Leilão publicado privadamente.',
                'item_reverted_to_draft' => 'Leilão revertido para rascunho.',
                'item_scheduled' => 'Leilão agendado.',
                'item_updated' => 'Leilão atualizado.',
                'item_link' => 'Leilão Link',
                'item_link_description' => 'A link to a leilão.',
            ),
            'public'            => true,
            'show_in_rest'      => true,
            'supports'          => array(
                0 => 'title',
                1 => 'editor',
                2 => 'thumbnail',
            ),
            'delete_with_user'  => false,
            'menu_icon'         => 'dashicons-schedule'
        ) 
    );
}

// Add actions.
add_action( 'init', 'oaa_register_post_types', 5 );