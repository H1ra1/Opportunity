<div class="oaa-lot-card">
    <a href="<?php echo esc_url( $args[ 'lot_product_data' ][ 'url' ] ); ?>" class="oaa-lot-card__thumb" lote="Lote <?php echo esc_attr( $args[ 'auction_lot_data' ][ 'numero_do_lote' ] ); ?>">
        <img src="<?php echo esc_url( $args[ 'lot_product_data' ][ 'animal' ][ 'fotos' ][ 0 ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $args[ 'lot_product_data' ][ 'animal' ][ 'fotos' ][ 0 ][ 'alt' ] ); ?>">
    </a>

    <div class="oaa-lot-card__title_box">
        <p><?php esc_html_e( $args[ 'auction_lot_data' ][ 'animal' ]->post_title ); ?></p>
    </div>

    <div class="oaa-lot-card__resume_box">
        <p><?php echo apply_filters( 'the_content', $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'comentario_resumido' ] ); ?></p>
    </div>

    <div class="oaa-lot-card__details_list">
        <div class="list-block">
            <p>Raça: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'raca' ]->name ); ?></strong></p>
            <p>Sexo: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'sexo' ]->name ); ?></strong></p>
            <p>Nascimento: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'data_de_nascimento' ] ); ?></strong></p>
            <p>Altura Aproximada: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'altura_aproximada' ] ); ?></strong></p>
            <p>Pelagem: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'pelagem' ]->name ); ?></strong></p>
            <?php echo ! empty( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'registro' ] ) ? "<p>Registro: <strong>{$args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'registro' ]}</strong></p>" : ''; ?>
            <p>Vend: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'criador' ]->name ); ?></strong></p>
            <p>Local: <strong><?php esc_html_e( $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'cidade_localizacao_do_animal' ]->name . "/" . $args[ 'lot_product_data' ][ 'animal' ][ 'dados_gerais' ][ 'uf_localizacao_do_animal' ]->name ); ?></strong></p>
        </div>
    </div>

    <div class="oaa-lot-card__bid_current_box">
        <p>Lance Atual</p>

        <div class="bid-current-installments">
            <p>
                <strong>R$ <?php esc_html_e( $args[ 'lot_product_data' ][ 'current_bid' ] ); ?></strong>
                <?php if( ! empty( $args[ 'lot_product_data' ][ 'auction' ][ 'total_de_parcelas' ] ) ): ?>
                <span>x <?php esc_html_e( $args[ 'lot_product_data' ][ 'auction' ][ 'total_de_parcelas' ] ); ?> Parcelas</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <a href="<?php echo esc_url( $args[ 'lot_product_data' ][ 'url' ] ); ?>" class="oaa-lot-card__button --light">Dar pré lance</a>
    <a href="<?php echo esc_url( $args[ 'lot_product_data' ][ 'url' ] ); ?>" class="oaa-lot-card__button --dark">Mais informações</a>
</div>