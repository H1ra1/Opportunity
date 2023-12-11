<?php

function oaa_register_post_types() {
    // Register the Animal post type.
    register_post_type( 'animal', 
        array(
            'labels'            => array(
                'name' => 'Animais',
                'singular_name' => 'Animal',
                'menu_name' => 'Animais',
                'all_items' => 'All Animais',
                'edit_item' => 'Edit Animal',
                'view_item' => 'View Animal',
                'view_items' => 'View Animais',
                'add_new_item' => 'Add New Animal',
                'add_new' => 'Add New Animal',
                'new_item' => 'New Animal',
                'parent_item_colon' => 'Parent Animal:',
                'search_items' => 'Search Animais',
                'not_found' => 'No Animais found',
                'not_found_in_trash' => 'No Animais found in Trash',
                'archives' => 'Animal Archives',
                'attributes' => 'Animal Attributes',
                'insert_into_item' => 'Insert into animal',
                'uploaded_to_this_item' => 'Uploaded to this animal',
                'filter_items_list' => 'Filter Animais list',
                'filter_by_date' => 'Filter Animais by date',
                'items_list_navigation' => 'Animais list navigation',
                'items_list' => 'Animais list',
                'item_published' => 'Animal published.',
                'item_published_privately' => 'Animal published privately.',
                'item_reverted_to_draft' => 'Animal reverted to draft.',
                'item_scheduled' => 'Animal scheduled.',
                'item_updated' => 'Animal updated.',
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
                'all_items' => 'All Leilões',
                'edit_item' => 'Edit Leilão',
                'view_item' => 'View Leilão',
                'view_items' => 'View Leilões',
                'add_new_item' => 'Add New Leilão',
                'add_new' => 'Add New Leilão',
                'new_item' => 'New Leilão',
                'parent_item_colon' => 'Parent Leilão:',
                'search_items' => 'Search Leilões',
                'not_found' => 'No Leilões found',
                'not_found_in_trash' => 'No Leilões found in Trash',
                'archives' => 'Leilão Archives',
                'attributes' => 'Leilão Attributes',
                'insert_into_item' => 'Insert into Leilão',
                'uploaded_to_this_item' => 'Uploaded to this leilão',
                'filter_items_list' => 'Filter Leilões list',
                'filter_by_date' => 'Filter Leilões by date',
                'items_list_navigation' => 'Leilões list navigation',
                'items_list' => 'Leilões list',
                'item_published' => 'Leilão published.',
                'item_published_privately' => 'Leilão published privately.',
                'item_reverted_to_draft' => 'Leilão reverted to draft.',
                'item_scheduled' => 'Leilão scheduled.',
                'item_updated' => 'Leilão updated.',
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