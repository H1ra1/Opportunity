<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    $auction_id     = get_the_ID();
    $auction_title  = get_the_title();
    $auction_data   = get_field( 'auction', $auction_id );
    $pre_bid_open   = oaa_check_if_pre_bid_is_open( $auction_id, false );

    // pprint( $auction_data );
    pprint( $GLOBALS[ 'wp_filter' ][ 'woocommerce_after_single_product_summary' ] );

    get_header();
?>

<section id="content" class="site-content">
    <div class="container">
        <div class="oaa-single-auction">
            <section class="oaa-single-auction__auction_holder fxb-row fxb-row-col-sm fxb-row-col-md">
                <div class="oaa-auction-thumb fxb-col fxb fxb-center-y fxb-center-x">
                    <img src="<?php echo esc_url( $auction_data[ 'capa_do_leilao' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( ! empty( $auction_data[ 'capa_do_leilao' ][ 'alt' ] ) ? $auction_data[ 'capa_do_leilao' ][ 'alt' ] : $auction_title ); ?>">
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
                            <p>Transmissão: <strong>Terça-feira, 05/12/0023 às 18:00</strong></p>
                            <p>Condições: <strong><?php echo esc_html_e( $auction_data[ 'total_de_parcelas' ] ); ?> PARCELAS (<?php echo esc_html_e( $auction_data[ 'condicoes_de_pagamento' ] ); ?>)</strong></p>
                            <p>Comissão de Compra: <strong>8%</strong></p>
                            <p>Incremento Mínimo: <strong>R$ <?php echo esc_html_e( number_format( $auction_data[ 'incremento_de_lance' ], 2, ',', '.' ) ); ?></strong></p>
                        </div>
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
                        <a href="#">Catálogo</a>
                        <a href="#">Regulamento</a>
                        <a href="#">Informações</a>
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
