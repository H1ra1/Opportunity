<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    $auction_id     = get_the_ID();
    $auction_title  = get_the_title();
    $auction_data   = get_field( 'auction', $auction_id );
    $pre_bid_open   = oaa_check_if_pre_bid_is_open( $auction_id, false );

    get_header();
?>

<section id="content" class="site-content">
    <div class="container">
        <div class="oaa-single-auction">
            <section class="oaa-single-auction__auction_holder fxb-row fxb-row-col-sm fxb-row-col-md">
                <div class="oaa-auction-thumb fxb-col fxb fxb-center-y fxb-center-x">
                    <img src="<?php echo esc_url( $auction_data[ 'banner_do_leilao' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( ! empty( $auction_data[ 'banner_do_leilao' ][ 'alt' ] ) ? $auction_data[ 'banner_do_leilao' ][ 'alt' ] : $auction_title ); ?>">
                </div>

                <div class="oaa-auction-infos fxb-col">
                    <div class="oaa-auction-infos__title_box">
                        <p><?php esc_html_e( $auction_title ); ?></p>
                    </div>

                    <div class="oaa-auction-infos__details_list">
                        <div class="list-block">
                            <?php if( $pre_bid_open ): ?>
                                <p><strong>Prazo para Pré Lances:</strong></p>
                                <p>Início: <strong><?php esc_html_e( oaa_translate_day_name( date( 'l', strtotime( $auction_data[ 'data_de_inicio_pre_lances' ] ) ) ) ) ?>, <?php esc_html_e( date( 'd/m/Y', strtotime( $auction_data[ 'data_de_inicio_pre_lances' ] ) ) ) ?> às <?php esc_html_e( date( 'H:i', strtotime( $auction_data[ 'data_de_inicio_pre_lances' ] ) ) ) ?></strong></p>
                                <p>Término: <strong><?php esc_html_e( oaa_translate_day_name( date( 'l', strtotime( $auction_data[ 'data_de_termino_pre_lances' ] ) ) ) ) ?>, <?php esc_html_e( date( 'd/m/Y', strtotime( $auction_data[ 'data_de_termino_pre_lances' ] ) ) ) ?> às <?php esc_html_e( date( 'H:i', strtotime( $auction_data[ 'data_de_termino_pre_lances' ] ) ) ) ?></strong></p>
                            <?php else: ?>
                                <p><strong>Prazo para Lances:</strong></p>
                                <p>Início: <strong><?php esc_html_e( oaa_translate_day_name( date( 'l', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ) ?>, <?php esc_html_e( date( 'd/m/Y', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ?> às <?php esc_html_e( date( 'H:i', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ?></strong></p>
                                <p>Término: <strong><?php esc_html_e( oaa_translate_day_name( date( 'l', strtotime( $auction_data[ 'data_de_termino_lances' ] ) ) ) ) ?>, <?php esc_html_e( date( 'd/m/Y', strtotime( $auction_data[ 'data_de_termino_lances' ] ) ) ) ?> às <?php esc_html_e( date( 'H:i', strtotime( $auction_data[ 'data_de_termino_lances' ] ) ) ) ?></strong></p>
                            <?php endif; ?>
                        </div>

                        <div class="list-block">
                            <p>Transmissão: <strong><?php esc_html_e( oaa_translate_day_name( date( 'l', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ) ?>, <?php esc_html_e( date( 'd/m/Y', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ?> às <?php esc_html_e( date( 'H:i', strtotime( $auction_data[ 'data_de_inicio_lances' ] ) ) ) ?></strong></p>
                            <p>Condições: <strong><?php esc_html_e( $auction_data[ 'total_de_parcelas' ] ); ?> PARCELAS (<?php echo esc_html_e( $auction_data[ 'condicoes_de_pagamento' ] ); ?>)</strong></p>
                            <?php echo ! empty( $auction_data[ 'comissao_de_compra' ] ) ? "<p>Comissão de Compra: <strong>{$auction_data[ 'comissao_de_compra' ]}%</strong></p>" : ''; ?>
                            <p>Incremento Mínimo: <strong>R$ <?php esc_html_e( number_format( $auction_data[ 'incremento_de_lance' ], 2, ',', '.' ) ); ?></strong></p>
                        </div>
                            
                        <?php if( is_array( $auction_data[ 'leiloleiros' ] ) && count( $auction_data[ 'leiloleiros' ] ) > 0 ): ?>
                            <div class="list-block">
                                <?php foreach( $auction_data[ 'leiloleiros' ] as $leiloleiro ): ?>
                                    <?php 
                                        $leiloleiro_fields = get_field( 'leiloeiro', "user_{$leiloleiro[ 'ID' ]}" );
                                    ?>
                                    <p><?php echo "{$leiloleiro_fields[ 'descricao' ]}: <strong>{$leiloleiro[ 'user_firstname' ]} {$leiloleiro[ 'user_lastname' ]}</strong> - {$leiloleiro_fields[ 'celular' ]}"; ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="oaa-auction-infos__timer_box">
                        <?php if( $pre_bid_open ): ?>
                            <?php if( oaa_now_date_equal_or_bigger( $auction_data[ 'data_de_inicio_pre_lances' ] ) ): ?>
                                <p>TEMPO PARA ENCERRAMENTO PRÉ LANCES:</p>
                            
                                <?php 
                                    countdown_clock(
                                        $end_date   = $auction_data[ 'data_de_termino_pre_lances' ],
                                        $item_id    = $auction_id,
                                        $item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
                                    );
                                ?>
                            <?php else: ?>
                                <p>TEMPO PARA INÍCIO PRÉ LANCES:</p>
                            
                                <?php 
                                    countdown_clock(
                                        $end_date   = $auction_data[ 'data_de_inicio_pre_lances' ],
                                        $item_id    = $auction_id,
                                        $item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
                                    );
                                ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if( oaa_now_date_equal_or_bigger( $auction_data[ 'data_de_inicio_lances' ] ) ): ?>
                                <p>TEMPO PARA ENCERRAMENTO LANCES:</p>

                                <?php 
                                    countdown_clock(
                                        $end_date   = $auction_data[ 'data_de_termino_lances' ],
                                        $item_id    = $auction_id,
                                        $item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
                                    );
                                ?>
                            <?php else: ?>
                                <p>TEMPO PARA INÍCIO LANCES:</p>

                                <?php 
                                    countdown_clock(
                                        $end_date   = $auction_data[ 'data_de_inicio_lances' ],
                                        $item_id    = $auction_id,
                                        $item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
                                    );
                                ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        
                    </div>

                    <div class="oaa-auction-infos__menu">
                        <button oaa-modal-open="oaa-catalago">Catálogo</button>
                        <button oaa-modal-open="oaa-regulamento">Regulamento</button>
                        <button oaa-modal-open="oaa-informacoes">Informações</button>

                        <?php oaa_get_template( 'templates/oaa-modal-template', array(
                            'modal_id'      => 'oaa-catalago',
                            'modal_title'   => "Catálogo - {$auction_title}",
                            'pdf'           => ! empty( $auction_data[ 'catalogo_em_pdf' ] ) ? $auction_data[ 'catalogo_em_pdf' ][ 'url' ] : '',
                            'empty_message' => 'Nenhum Catálogo cadastrado.'
                        ) ); ?>

                        <?php oaa_get_template( 'templates/oaa-modal-template', array(
                            'modal_id'      => 'oaa-regulamento',
                            'modal_title'   => "Regulamento - {$auction_title}",
                            'body'          => $auction_data[ 'regulamento_do_evento' ],
                            'empty_message' => 'Nenhum Regulamento cadastrado.'
                        ) ); ?>

                        <?php oaa_get_template( 'templates/oaa-modal-template', array(
                            'modal_id'      => 'oaa-informacoes',
                            'modal_title'   => "Informações - {$auction_title}",
                            'body'          => $auction_data[ 'informacoes_gerais' ],
                            'empty_message' => 'Nenhuma Informação cadastrada.'
                        ) ); ?>
                    </div>
                </div>
            </section>

            <section class="oaa-single-auction__auction_lots">
                <?php foreach( $auction_data[ 'lotes' ] as $indice => $lot ): ?>
                    <?php oaa_get_template( 'templates/oaa-lot-card-template', array( 
                        'auction_lot_data'  => $lot,
                        'lot_product_data'  => oaa_get_auction_lot_data( $auction_id, $lot[ 'lote_id' ] )
                    ) ); ?>
                <?php endforeach ?>
            </section>
        </div>
    </div>
</section>

<?php
    get_footer();
?>
