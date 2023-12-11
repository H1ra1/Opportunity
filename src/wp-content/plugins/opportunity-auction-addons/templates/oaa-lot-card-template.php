<div class="oaa-lot-card">
    <a href="<?php echo esc_url( $args[ 'lot_product_data' ][ 'url' ] ); ?>" class="oaa-lot-card__thumb">
        <img src="" alt="">
    </a>

    <div class="oaa-lot-card__title_box">
        <p><?php esc_html_e( $args[ 'auction_lot_data' ][ 'animal' ]->post_title ); ?></p>
    </div>

    <div class="oaa-lot-card__details_list">
        <div class="list-block">
            <p>Raça: <strong>Quarto</strong></p>
            <p>Sexo: <strong>Quarto</strong></p>
            <p>Nascimento: <strong>Quarto</strong></p>
            <p>Altura Aproximada: <strong>Quarto</strong></p>
            <p>Vend: <strong>Quarto</strong></p>
            <p>Local: <strong>Quarto</strong></p>
        </div>
    </div>

    <div class="oaa-lot-card__bid_current_box">
        <p>Lance Atual</p>

        <div class="bid-current-installments">
            <p><strong>R$ 650,00</strong> x 40 Parcelas</p>
        </div>
    </div>

    <a href="#" class="oaa-lot-card__button --light">Dar pré lance</a>
    <a href="<?php echo esc_url( $args[ 'lot_product_data' ][ 'url' ] ); ?>" class="oaa-lot-card__button --dark">Mais informações</a>
</div>