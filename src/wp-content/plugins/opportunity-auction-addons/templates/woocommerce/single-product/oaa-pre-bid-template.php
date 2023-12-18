<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $woocommerce, $product, $post;

$auction_product        = $product;
$auction_post_id        = get_post_meta( $auction_product->id, 'oaa_auction_product_post_id', true );
$auction_post_fields    = get_field( 'auction', $auction_post_id );
$pre_bid_open           = oaa_check_if_pre_bid_is_open( $auction_product->id );

$next_bids = oaa_get_pre_bid_next_bids_values( $auction_product->id );
?>

<?php if( $pre_bid_open ): ?>
<section class="oaa-pre-bid">
    <div class="oaa-pre-bid__pre_bid_form">
        <form oaa-pre-bid-form="<?php echo esc_attr( $auction_product->id ); ?>">
            <select name="oaa-pre-bid-form-select" id="oaa-pre-bid-form-select">
                <?php foreach( $next_bids as $bid ): ?>
                    <option value="<?php esc_html_e( $bid ) ?>">R$ <?php esc_html_e( number_format( $bid, 2, ',', '.' ) ); ?></option>
                <?php endforeach; ?>
            </select>

            <button oaa-pre-bid-form-button>Dar Pré Lance</button>
        </form>
    </div>


</section>
<?php endif; ?>