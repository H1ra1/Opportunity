<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $woocommerce, $product, $post;

$user_id                    = get_current_user_ID();
$auction_product            = $product;
$auction_post_id            = get_post_meta( $auction_product->id, 'oaa_auction_product_post_id', true );
$auction_post_fields        = get_field( 'auction', $auction_post_id );
$auction_lot_animal_id      = get_post_meta( $auction_product->id, 'oaa_auction_animal_post_id', true );
$auction_lot_animal_data    = get_field( 'animal', $auction_lot_animal_id );
$pre_bid_open               = oaa_check_if_pre_bid_is_open( $auction_product->id );
$auction_lot_bids           = $pre_bid_open ? oaa_get_pre_bids_from_user_on_auction( $auction_product->id ) : oaa_get_bids_on_auction( $auction_product->id );
?>

<section class="oaa-bid-menu">
    <div class="oaa-bid-menu__menu_tabs">
        <div class="oaa-menu-tab --active" oaa-menu-tab="fotos_e_videos">
            <p>Fotos / Vídeos</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="genealogia">
            <p>Genealogia</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="comentarios">
            <p>Comentários</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="campanha">
            <p>Campanha</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="raio_x">
            <p>Raio X</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="historico_veterinario">
            <p>Histórico Veterinário</p>
        </div>

        <div class="oaa-menu-tab" oaa-menu-tab="historico_de_lances">
            <p>Histórico de Lances</p>
        </div>
    </div>

    <div class="oaa-bid-menu__menu_tabs_items">
        <div class="oaa-menu-tab-item --active" oaa-menu-tab-item='fotos_e_videos'>
            <p class="oaa-menu-tab-item__title">Fotos / Vídeos</p>

            <div class="oaa-menu-tab-item__holder">
                <?php if( ! empty( $auction_lot_animal_data[ 'video' ] ) ): ?>
                    <div class="oaa-menu-tab-item-video-holder">
                        <iframe width="100%" height="100%" src="<?php echo esc_url( "https://www.youtube.com/embed/" . oaa_get_yt_video_id( $auction_lot_animal_data[ 'video' ] ) ); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>

                <div class="oaa-image-gallery">
                    <div class="gallery gallery-size-thumbnail">
                        <?php foreach( $auction_lot_animal_data[ 'fotos' ] as $foto ): ?>
                            <figure class="gallery-item">
                                <div class="gallery-icon landscape">
                                    <a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="fotos"
                                        data-elementor-lightbox-title="<?php esc_html_e( $foto[ 'caption' ] ); ?>"
                                        data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY3MywidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC93cC1jb250ZW50XC91cGxvYWRzXC8yMDIzXC8xMlwvRk9UT18xNzQ3NjYwNTEyMjAyMzE5NDI1MC0xLmpwZWciLCJzbGlkZXNob3ciOiIyMDNmMGUxIn0%3D"
                                        href="<?php echo esc_url( $foto[ 'url' ] ); ?>"><img
                                            decoding="async" width="150" height="150"
                                            src="<?php echo esc_url( $foto[ 'sizes' ][ 'thumbnail' ] ); ?>"
                                            class="attachment-thumbnail size-thumbnail" alt=""
                                            srcset="<?php echo esc_url( $foto[ 'sizes' ][ 'thumbnail' ] ); ?> 150w, <?php echo esc_url( $foto[ 'sizes' ][ 'woocommerce_thumbnail' ] ); ?> 300w, <?php echo esc_url( $foto[ 'sizes' ][ 'woocommerce_gallery_thumbnail' ] ); ?> 100w, <?php echo esc_url( $foto[ 'sizes' ][ 'variation_swatches_image_size' ] ); ?> 50w"
                                            sizes="(max-width: 150px) 100vw, 150px"></a>
                                </div>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='genealogia'>
            <p class="oaa-menu-tab-item__title">Genealogia</p>

            <div class="oaa-menu-tab-item__holder">
                <?php if( ! empty( $auction_lot_animal_data[ 'genealogia' ] ) ): ?>
                    <img src="<?php echo esc_url( $auction_lot_animal_data[ 'genealogia' ][ 'url' ] ); ?>" alt="<?php echo esc_url( $auction_lot_animal_data[ 'genealogia' ][ 'alt' ] ); ?>">
                <?php else: ?>
                    <div class="oaa-menu-tab-item-empty">
                        <p>Este lote não possui Genealogia!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='comentarios'>
            <p class="oaa-menu-tab-item__title">Comentários</p>

            <div class="oaa-menu-tab-item__holder">
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='campanha'>
            <p class="oaa-menu-tab-item__title">Campanha</p>

            <div class="oaa-menu-tab-item__holder">
                
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='raio_x'>
            <p class="oaa-menu-tab-item__title">Raio X</p>

            <div class="oaa-menu-tab-item__holder">
                <?php if( ! empty( $auction_lot_animal_data[ 'raio_x_gallery' ] ) ): ?>
                    <div class="oaa-image-gallery">
                        <div class="gallery gallery-size-thumbnail">
                            <?php foreach( $auction_lot_animal_data[ 'raio_x_gallery' ] as $raio_x ): ?>
                                <figure class="gallery-item">
                                    <div class="gallery-icon landscape">
                                        <a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="raio_x"
                                            data-elementor-lightbox-title="<?php echo esc_html_e( $raio_x[ 'caption' ] ); ?>"
                                            data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY3MywidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC93cC1jb250ZW50XC91cGxvYWRzXC8yMDIzXC8xMlwvRk9UT18xNzQ3NjYwNTEyMjAyMzE5NDI1MC0xLmpwZWciLCJzbGlkZXNob3ciOiIyMDNmMGUxIn0%3D"
                                            href="<?php echo esc_url( $raio_x [ 'url' ] ); ?>"><img
                                                decoding="async" width="150" height="150"
                                                src="<?php echo esc_url( $raio_x [ 'sizes' ][ 'thumbnail' ] ); ?>"
                                                class="attachment-thumbnail size-thumbnail" alt=""
                                                srcset="<?php echo esc_url( $raio_x [ 'sizes' ][ 'thumbnail' ] ); ?> 150w, <?php echo esc_url( $raio_x [ 'sizes' ][ 'woocommerce_thumbnail' ] ); ?> 300w, <?php echo esc_url( $raio_x [ 'sizes' ][ 'woocommerce_gallery_thumbnail' ] ); ?> 100w, <?php echo esc_url( $raio_x [ 'sizes' ][ 'variation_swatches_image_size' ] ); ?> 50w"
                                                sizes="(max-width: 150px) 100vw, 150px"></a>
                                    </div>
                                </figure>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="oaa-menu-tab-item-empty">
                        <p>Este lote não possui foto de Raio X!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='historico_veterinario'>
            <p class="oaa-menu-tab-item__title">Histórico Veterinário</p>

            <div class="oaa-menu-tab-item__holder">
                <?php if( ! empty( $auction_lot_animal_data[ 'historico_veterinario_data' ] ) ): ?>
                    <div class="oaa-menu-tab-item-table">
                        <?php foreach( $auction_lot_animal_data[ 'historico_veterinario_data' ] as $vet_data ): ?>
                            <div class="oaa-menu-tab-item-table__item">
                                <span><?php esc_html_e( $vet_data[ 'titulo' ] ); ?>:</span>
                                <span><?php esc_html_e( $vet_data[ 'valor' ] ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="oaa-menu-tab-item-empty">
                        <p>Este lote não possui Histórico Veterinário!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="oaa-menu-tab-item" oaa-menu-tab-item='historico_de_lances'>
            <p class="oaa-menu-tab-item__title">Histórico de Lances</p>

            <div class="oaa-menu-tab-item__holder">
                <?php oaa_get_template( 'templates/oaa-bids-historic-template', array(
                    'bids'          => $auction_lot_bids,
                    'pre_bid_open'  => $pre_bid_open
                 ) ); ?>
            </div>
        </div>
    </div>
</section>