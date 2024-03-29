<?php

function oaa_add_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }
        acf_add_local_field_group( array(
            'key' => 'group_6574f2c60d1fb',
            'title' => 'Auctions',
            'fields' => array(
                array(
                    'key' => 'field_6574f2c661bcd',
                    'label' => '',
                    'name' => 'auction',
                    'aria-label' => '',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_657610e2693b4',
                            'label' => 'Capa do leilão',
                            'name' => 'banner_do_leilao',
                            'aria-label' => '',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                            'preview_size' => 'medium',
                        ),
                        array(
                            'key' => 'field_65777422d20da',
                            'label' => 'Total de Parcelas',
                            'name' => 'total_de_parcelas',
                            'aria-label' => '',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'min' => '',
                            'max' => '',
                            'placeholder' => '',
                            'step' => '',
                            'prepend' => '',
                            'append' => '',
                        ),
                        array(
                            'key' => 'field_6576114c693b5',
                            'label' => 'Condições de pagamento( EX:	2+2+2+2+2+30 )',
                            'name' => 'condicoes_de_pagamento',
                            'aria-label' => '',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'maxlength' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                        ),
                        array(
                            'key' => 'field_6575148b8b31b',
                            'label' => 'Incremento de Lance',
                            'name' => 'incremento_de_lance',
                            'aria-label' => '',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '33',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 10,
                            'min' => '',
                            'max' => '',
                            'placeholder' => '',
                            'step' => '',
                            'prepend' => '',
                            'append' => '',
                        ),
                        array(
                            'key' => 'field_657514ee8b31d',
                            'label' => 'Data de Início',
                            'name' => 'data_de_inicio',
                            'aria-label' => '',
                            'type' => 'date_time_picker',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'display_format' => 'd/m/Y H:i:s',
                            'return_format' => 'Y-m-d H:i:s',
                            'first_day' => 1,
                        ),
                        array(
                            'key' => 'field_657515158b31e',
                            'label' => 'Data de Término',
                            'name' => 'data_de_termino',
                            'aria-label' => '',
                            'type' => 'date_time_picker',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '47',
                                'class' => '',
                                'id' => '',
                            ),
                            'display_format' => 'd/m/Y H:i:s',
                            'return_format' => 'Y-m-d H:i:s',
                            'first_day' => 1,
                        ),
                        array(
                            'key' => 'field_6574f3da61bce',
                            'label' => 'Lotes',
                            'name' => 'lotes',
                            'aria-label' => '',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'layout' => 'block',
                            'pagination' => 0,
                            'min' => 0,
                            'max' => 0,
                            'collapsed' => 'field_657515992ce48',
                            'button_label' => 'Adicionar Lote',
                            'rows_per_page' => 20,
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_657515992ce48',
                                    'label' => '#Lote ID',
                                    'name' => 'lote_id',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => 'disabled-input',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                                array(
                                    'key' => 'field_6574f94261bcf',
                                    'label' => 'Número do Lote',
                                    'name' => 'numero_do_lote',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                                array(
                                    'key' => 'field_6574f99661bd0',
                                    'label' => 'Preço de Abertura (R$)',
                                    'name' => 'preco_de_abertura',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                                array(
                                    'key' => 'field_6574f9cb61bd1',
                                    'label' => 'Menor Preço para Aceitar (R$)',
                                    'name' => 'menor_preco_para_aceitar',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                                array(
                                    'key' => 'field_657514b68b31c',
                                    'label' => 'Preço Venda Imediata (R$)',
                                    'name' => 'preco_venda_imediata',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                                array(
                                    'key' => 'field_65755c689f0b0',
                                    'label' => 'Animal',
                                    'name' => 'animal',
                                    'aria-label' => '',
                                    'type' => 'post_object',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'post_type' => array(
                                        0 => 'animal',
                                    ),
                                    'post_status' => array(
                                        0 => 'publish',
                                    ),
                                    'taxonomy' => '',
                                    'return_format' => 'object',
                                    'multiple' => 0,
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'ui' => 1,
                                    'bidirectional_target' => array(
                                    ),
                                    'parent_repeater' => 'field_6574f3da61bce',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'auction',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
                4 => 'revisions',
                5 => 'slug',
                6 => 'author',
                7 => 'format',
                8 => 'page_attributes',
                9 => 'featured_image',
                10 => 'categories',
                11 => 'tags',
                12 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ) );
    
        acf_add_local_field_group( array(
            'key' => 'group_6574e813ae33c',
            'title' => 'Animal',
            'fields' => array(
                array(
                    'key' => 'field_6577676d81ec6',
                    'label' => '',
                    'name' => 'animal',
                    'aria-label' => '',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_6574e9797d2aa',
                            'label' => 'Dados Gerais',
                            'name' => '',
                            'aria-label' => '',
                            'type' => 'tab',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'placement' => 'top',
                            'endpoint' => 0,
                        ),
                        array(
                            'key' => 'field_6574eb5ecc025',
                            'label' => '',
                            'name' => 'dados_gerais',
                            'aria-label' => '',
                            'type' => 'group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'layout' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_6577603421e27',
                                    'label' => 'Tipo',
                                    'name' => 'tipo',
                                    'aria-label' => '',
                                    'type' => 'taxonomy',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'taxonomy' => 'tipo',
                                    'add_term' => 1,
                                    'save_terms' => 1,
                                    'load_terms' => 1,
                                    'return_format' => 'object',
                                    'field_type' => 'select',
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'multiple' => 0,
                                    'bidirectional_target' => array(
                                    ),
                                ),
                                array(
                                    'key' => 'field_6574eb8acc026',
                                    'label' => 'Sexo',
                                    'name' => 'sexo',
                                    'aria-label' => '',
                                    'type' => 'taxonomy',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'taxonomy' => 'sexo',
                                    'add_term' => 1,
                                    'save_terms' => 1,
                                    'load_terms' => 1,
                                    'return_format' => 'object',
                                    'field_type' => 'select',
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'multiple' => 0,
                                    'bidirectional_target' => array(
                                    ),
                                ),
                                array(
                                    'key' => 'field_6574ebcecc028',
                                    'label' => 'Pelagem',
                                    'name' => 'pelagem',
                                    'aria-label' => '',
                                    'type' => 'taxonomy',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'taxonomy' => 'pelagem',
                                    'add_term' => 1,
                                    'save_terms' => 1,
                                    'load_terms' => 1,
                                    'return_format' => 'object',
                                    'field_type' => 'select',
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'multiple' => 0,
                                    'bidirectional_target' => array(
                                    ),
                                ),
                                array(
                                    'key' => 'field_65775bc762463',
                                    'label' => 'Data de Nascimento',
                                    'name' => 'data_de_nascimento',
                                    'aria-label' => '',
                                    'type' => 'date_picker',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'display_format' => 'd/m/Y',
                                    'return_format' => 'd/m/Y',
                                    'first_day' => 1,
                                ),
                                array(
                                    'key' => 'field_65775ab662461',
                                    'label' => 'Altura Aproximada',
                                    'name' => 'altura_aproximada',
                                    'aria-label' => '',
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'min' => '',
                                    'max' => '',
                                    'placeholder' => '',
                                    'step' => '',
                                    'prepend' => '',
                                    'append' => '',
                                ),
                                array(
                                    'key' => 'field_657755161d5d0',
                                    'label' => 'Raça',
                                    'name' => 'raca',
                                    'aria-label' => '',
                                    'type' => 'taxonomy',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'taxonomy' => 'raca',
                                    'add_term' => 1,
                                    'save_terms' => 1,
                                    'load_terms' => 1,
                                    'return_format' => 'object',
                                    'field_type' => 'select',
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'multiple' => 0,
                                    'bidirectional_target' => array(
                                    ),
                                ),
                                array(
                                    'key' => 'field_65775c7162464',
                                    'label' => 'Criador',
                                    'name' => 'criador',
                                    'aria-label' => '',
                                    'type' => 'taxonomy',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'taxonomy' => 'criador',
                                    'add_term' => 1,
                                    'save_terms' => 1,
                                    'load_terms' => 1,
                                    'return_format' => 'object',
                                    'field_type' => 'select',
                                    'allow_null' => 0,
                                    'bidirectional' => 0,
                                    'multiple' => 0,
                                    'bidirectional_target' => array(
                                    ),
                                ),
                                array(
                                    'key' => 'field_65775aec62462',
                                    'label' => 'Grau de Sangue',
                                    'name' => 'grau_de_sangue',
                                    'aria-label' => '',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'maxlength' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                ),
                                array(
                                    'key' => 'field_65775f808ceb4',
                                    'label' => 'Registro',
                                    'name' => 'registro',
                                    'aria-label' => '',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'maxlength' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                ),
                                array(
                                    'key' => 'field_65775eb1141cc',
                                    'label' => 'Comentário Resumido',
                                    'name' => 'comentario_resumido',
                                    'aria-label' => '',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'maxlength' => 100,
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_6574e9867d2ab',
                            'label' => 'Fotos',
                            'name' => '',
                            'aria-label' => '',
                            'type' => 'tab',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'placement' => 'top',
                            'endpoint' => 0,
                        ),
                        array(
                            'key' => 'field_657754812ede5',
                            'label' => 'Fotos',
                            'name' => 'fotos',
                            'aria-label' => '',
                            'type' => 'gallery',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'library' => 'all',
                            'min' => 1,
                            'max' => '',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '.png, .jpeg, .jpg, .webp',
                            'insert' => 'append',
                            'preview_size' => 'medium',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'animal',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'discussion',
                4 => 'comments',
                5 => 'revisions',
                6 => 'slug',
                7 => 'author',
                8 => 'format',
                9 => 'page_attributes',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ) );    
}

function oaa_acf_fields_path() {
    return OAA_PATH . 'oaa-acf-json';
}

// Add filters.
add_filter( 'acf/settings/save_json', 'oaa_acf_fields_path' );
add_filter( 'acf/settings/load_json', 'oaa_acf_fields_path' );


// Add actions.
// add_action( 'acf/include_fields', 'oaa_add_acf_fields' );