<div class="oaa-auction-card">
    <a href="<?php echo esc_url( $args[ 'url' ] ); ?>" class="oaa-auction-card__thumb">
        <img src="<?php echo esc_url( $args[ 'auction_fields' ][ 'capa_do_leilao' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( ! empty( $args[ 'auction_fields' ][ 'capa_do_leilao' ][ 'alt' ] ) ? $args[ 'auction_fields' ][ 'capa_do_leilao' ][ 'alt' ] : $args[ 'title' ] ); ?>">
    </a>

    <div class="oaa-auction-card__timer_box">
        <p>Tempo para encerramento:</p>
        <?php 
            countdown_clock(
				$end_date   = $args[ 'auction_fields' ][ 'data_de_termino_lances' ],
				$item_id    = $args[ 'id' ],
				$item_class = 'uwa-main-auction-product uwa_auction_product_countdown'   
			);
        ?>
    </div>

    <div class="oaa-auction-card__title_box">
        <p><?php esc_html_e( $args[ 'title' ] ); ?></p>
    </div>

    <div class="oaa-auction-card__term_box">
        <?php if( ! empty( $args[ 'auction_fields' ][ 'data_de_inicio_lances' ] ) && $args[ 'auction_fields' ][ 'data_de_termino_lances' ] ): ?>
            <p>Prazo para Lances:</p>
            <p><strong><?php esc_html_e( oaa_format_date_only( $args[ 'auction_fields' ][ 'data_de_inicio_lances' ] ) ); ?></strong><span>(<?php esc_html_e( oaa_format_time_only( $args[ 'auction_fields' ][ 'data_de_inicio_lances' ] ) ); ?>)</span> à <strong><?php esc_html_e( oaa_format_date_only( $args[ 'auction_fields' ][ 'data_de_termino_lances' ] ) ); ?></strong><span>(<?php esc_html_e( oaa_format_time_only( $args[ 'auction_fields' ][ 'data_de_termino_lances' ] ) ); ?>)</span></p>
        <?php endif; ?>
    </div>

    <a href="<?php echo esc_url( $args[ 'url' ] ); ?>" class="oaa-auction-card__main_button">Ver lotes</a>
</div>