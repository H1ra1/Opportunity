<?php

function oaa_new_user_register( object $user_obj ): object|bool {
    if( email_exists( $user_obj->email ) ) 
        return ( object ) [ 
            'message'    => 'Desculpe, mas este e-mail já está em uso!',
            'error'      => ''
        ];

    $new_user_id =  wp_create_user( $user_obj->username, $user_obj->password, $user_obj->email );

    if( $new_user_id instanceof WP_Error ) 
        return ( object ) [ 
            'message'   => 'Erro ao criar usuário',
            'error'     => $new_user_id
        ];

    $new_user       = new WP_User( $new_user_id );
    $new_user_wc    = new WC_Customer( $new_user->ID );

    // Treated data.
    $fullname_split = preg_split( '#\s+#', $user_obj->fullname, 2 );
    
    // Set user role.
    $new_user->set_role( 'customer' );

    // Update ACF fields.
    $acf_fields = [];

    foreach( $user_obj->fields as $field => $field_value ) {
        $acf_fields[ $field ] = $field_value;
    }

    update_field( 'user_personal_data', $acf_fields, "user_{$new_user->ID}" ); 
    
    // Update user meta.
    update_user_meta( $new_user->ID, 'show_admin_bar_front', false );

    // Update WC user data.
    $new_user_wc->set_first_name( $fullname_split[ 0 ] );
    $new_user_wc->set_last_name( array_key_exists( 1, $fullname_split ) ? $fullname_split[ 1 ] : '' );
    $new_user_wc->save();

    return true;
}

function oaa_new_user_register_ajax() {
    if( wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        $formd_fields = $_POST[ 'form_data' ];
        
        $user_fields = ( object ) [
            'username'  => $formd_fields[ 'user_email' ],
            'password'  => $formd_fields[ 'user_senha' ],
            'email'     => $formd_fields[ 'user_email' ],
            'fullname'  => $formd_fields[ 'user_fullname' ],
            'fields'    => $formd_fields
        ];

        $new_user = oaa_new_user_register( $user_fields );

        if( is_object( $new_user ) )
            wp_send_json( [
                'message'   => $new_user->message,
                'error'     => $new_user->error
            ], 500 );

        wp_send_json( [
            'message'   => 'Usuário cadastrado com sucesso!',
        ], 200 );
    }

    wp_die();
}

// oaa_new_user_register( ( object ) [
//     'username'  => 'cliente1@gmail.com',
//     'password'  => '12345',
//     'email'     => 'cliente1@gmail.com',
//     'fullname'  => 'Cliente Teste da Silva o Brabo',
//     'fields'    => [
//         'user_cpf_cnpj'                 => '465.242.523-25',
//         'user_rg_ie'                    => '05.944.894-Y',
//         'user_endereco'                 => 'Rua teste',
//         'user_endereco_numero'          => '42',
//         'user_endereco_bairro'          => 'Vila Lala',
//         'user_endereco_cep'             => '04473550',
//         'user_endereco_estado'          => 'São Paulo',
//         'user_endereco_cidade'          => 'São Paulo',
//         'user_nacionalidade'            => 'Brasileiro',  
//         'user_celular'                  => '11951252252',
//         'user_telefone'                 => '',
//         'user_naturalidade'             => 'Brasileiro',
//         'user_estado_civil'             => 'Solteiro',
//         'user_conjuge'                  => '',
//         'user_pai'                      => '',
//         'user_mae'                      => '',
//         'user_profissao'                => '',
//         'user_empresa'                  => '',
//         'user_site_da_empresa'          => '',
//         'user_informacoes_adicionais'   => '',
//         'user_nome_da_fazenda_haras'    => '',
//         'user_telefone_fazenda_haras'   => '',
//         'user_propriedade_estado'       => '',
//         'user_propriedade_cidade'       => '',
//         'user_racas_de_interesse'       => '',
//     ]
// ] );


function oaa_hide_wordpress_admin_bar($user){
    return ( current_user_can( 'administrator' ) ) ? $user : false;
}

// Add actions.
add_action( 'wp_ajax_oaa_new_user_register_ajax', 'oaa_new_user_register_ajax' );
add_action( 'wp_ajax_nopriv_oaa_new_user_register_ajax', 'oaa_new_user_register_ajax' );

// Add filters.
add_filter( 'show_admin_bar' , 'oaa_hide_wordpress_admin_bar');