<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $woocommerce, $product, $post;

$auction_product            = $product;
$auction_post_id            = get_post_meta( $auction_product->id, 'oaa_auction_product_post_id', true );
$auction_post_fields        = get_field( 'auction', $auction_post_id );
$pre_bid_open               = oaa_check_if_pre_bid_is_open( $auction_product->id );
$auction_lot_animal_id      = get_post_meta( $auction_product->id, 'oaa_auction_animal_post_id', true );
$auction_lot_animal_post    = get_post( $auction_lot_animal_id );
$auction_lot_animal_data    = get_field( 'animal', $auction_lot_animal_id );
$auction_lot_indice         = get_post_meta( $auction_post_id, 'oaa_auction_lot_indice', true );
$auction_lot_data           = $auction_post_fields[ 'lotes' ][ $auction_lot_indice ];
$next_bids                  = oaa_get_bid_next_bids_values( $auction_product->id );
$current_bid_value          = oaa_get_current_bid_value( $auction_product->id );
$bid_started                = get_post_meta( $auction_product->id, 'woo_ua_auction_current_bid', true );

?>

<section class="oaa-bid-template">
    <div class="oaa-bid-template__infos">
        <div class="oaa-bid-template-title">
            <span>LOTE <?php esc_html_e( $auction_lot_data[ 'numero_do_lote' ] ); ?></span>
            <p><?php esc_html_e( $auction_lot_animal_post->post_title ); ?></p>
        </div>

        <div class="oaa-bid-template-list">
            <div class="list-block">
                <p>Raça: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'raca' ]->name ); ?></strong></p>
                <p>Sexo: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'sexo' ]->name ); ?></strong></p>
                <p>Nascimento: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'data_de_nascimento' ] ); ?></strong></p>
                <p>Altura Aproximada: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'altura_aproximada' ] ); ?></strong></p>
                <p>Pelagem: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'pelagem' ]->name ); ?></strong></p>
                <p>Vend: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'criador' ]->name ); ?></strong></p>
                <p>Local: <strong><?php esc_html_e( $auction_lot_animal_data[ 'dados_gerais' ][ 'raca' ]->name ); ?></strong></p>
            </div>
        </div>
    </div>

    <div class="oaa-bid-template__bid_holder">
        <?php if( $pre_bid_open ): ?>
            <div class="oaa-bid">
                <div class="oaa-bid__infos">
                    <p class="oaa-bid-title"><?php esc_html_e( $bid_started ? 'Pré Lance Atual' : 'Preço de Abertura' ); ?></p>
                    <div class="oaa-bid-price">
                        <span class="oaa-bid-price-value">R$ <?php esc_html_e( $current_bid_value ); ?></span>
                        <span class="oaa-bid-price-installments">
                            <?php esc_html_e( isset( $auction_post_fields[ 'total_de_parcelas' ] ) && ! empty( $auction_post_fields[ 'total_de_parcelas' ] ) ? " x {$auction_post_fields[ 'total_de_parcelas' ]} Parcelas" : '' ); ?>
                        </span>
                    </div>
                </div>

                <div class="oaa-bid__pre_bid_form">
                    <form oaa-pre-bid-form="<?php echo esc_attr( $auction_product->id ); ?>">
                        <select name="oaa-bid-form-select" id="oaa-bid-form-select">
                            <?php foreach( $next_bids as $bid ): ?>
                                <option value="<?php esc_html_e( $bid ) ?>">R$ <?php esc_html_e( number_format( $bid, 2, ',', '.' ) ); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button oaa-pre-bid-form-button>Pré Lance</button>
                    </form>
                </div>

                <div class="oaa-bid__buttons">
                    <button class="bg-base-2">Habilite-se</button>
                    <button class="bg-base-1">Regulamento</button>
                </div>
            </div>
        <?php else: ?>
            <div class="oaa-bid">
                <div class="oaa-bid__infos">
                    <p class="oaa-bid-title">Lance Atual</p>
                    <div class="oaa-bid-price">
                        <span class="oaa-bid-price-value">R$ <?php esc_html_e( $current_bid_value ); ?></span>
                        <span class="oaa-bid-price-installments">
                            <?php esc_html_e( isset( $auction_post_fields[ 'total_de_parcelas' ] ) && ! empty( $auction_post_fields[ 'total_de_parcelas' ] ) ? " x {$auction_post_fields[ 'total_de_parcelas' ]} Parcelas" : '' ); ?>
                        </span>
                    </div>
                </div>

                <div class="oaa-bid__bid_form">
                    <form oaa-bid-form="<?php echo esc_attr( $auction_product->id ); ?>">
                        <select name="oaa-form-select" id="oaa-bid-form-select">
                            <?php foreach( $next_bids as $bid ): ?>
                                <option value="<?php esc_html_e( $bid ) ?>">R$ <?php esc_html_e( number_format( $bid, 2, ',', '.' ) ); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button oaa-bid-form-button>Lance</button>
                    </form>
                </div>

                <div class="oaa-bid__buttons">
                    <button class="bg-base-2">Habilite-se</button>
                    <button class="bg-base-1">Regulamento</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
</section>