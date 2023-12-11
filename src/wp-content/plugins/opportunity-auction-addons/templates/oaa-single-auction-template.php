<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    $auction_id     = get_the_ID();
    $auction_title  = get_the_title();
    $auction_data   = get_field( 'auction', $auction_id );

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
                            <p><strong>Prazo para Pré-Lances:</strong></p>
                            <p>Início: <strong>Terça-feira, 05/12/0023 às 18:00</strong></p>
                            <p>Término: <strong>Terça-feira, 05/12/0023 às 18:00</strong></p>
                        </div>

                        <div class="list-block">
                            <p>Transmissão: <strong>Terça-feira, 05/12/0023 às 18:00</strong></p>
                            <p>Condições: <strong>40 PARCELAS (2+2+2+2+2+30)</strong></p>
                            <p>Comissão de Compra: <strong>8%</strong></p>
                            <p>Incremento Mínimo: <strong>R$ 30,00</strong></p>
                        </div>
                    </div>

                    <div class="oaa-auction-infos__timer_box">
                        <p>TEMPO PARA ENCERRAMENTO:</p>

                        <?php 
                            countdown_clock(
                                $end_date   = $auction_data[ 'data_de_termino' ],
                                $item_id    = $auction_id,
                                $item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
                            );
                        ?>
                    </div>

                    <div class="oaa-auction-infos__menu">
                        <a href="#">Pré-catálogo</a>
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
