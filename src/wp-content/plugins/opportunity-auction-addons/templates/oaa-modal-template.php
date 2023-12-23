<div class="oaa-modal-container" oaa-modal="<?php echo esc_attr( $args[ 'modal_id' ] ); ?>">
    <div class="oaa-modal" <?php echo isset( $args[ 'pdf' ] ) && ! empty( $args[ 'pdf' ] ) ? 'style="overflow-y: hidden;"' : ''; ?>>
        <div class="oaa-modal__header">
            <p><?php esc_html_e( $args[ 'modal_title' ] ); ?></p>
            <button oaa-modal-close>x</button>
        </div>
    
        <div class="oaa-modal__body" <?php echo isset( $args[ 'pdf' ] ) && ! empty( $args[ 'pdf' ] ) ? 'style="height: 90%;"' : ''; ?>>
            <?php if( ( isset( $args[ 'body' ] ) && ! empty( $args[ 'body' ] ) ) || ( isset( $args[ 'pdf' ] ) && ! empty( $args[ 'pdf' ] ) ) ): ?>
                <?php if( isset( $args[ 'body' ] ) && ! empty( $args[ 'body' ] ) ): ?>
                    <?php echo apply_filters( 'the_content', $args[ 'body' ] ); ?>
                <?php endif; ?>

                <?php if( isset( $args[ 'pdf' ] ) && ! empty( $args[ 'pdf' ] ) ): ?>
                    <object data="<?php echo esc_url( $args[ 'pdf' ] ); ?>" type="application/pdf" width="100%" height="100%">
                        <p>Não é possível exibir o arquivo PDF <a href="<?php echo esc_url( $args[ 'pdf' ] ); ?>">Clique aqui para baixar</a>.</p>
                    </object>
                <?php endif; ?>
            <?php else: ?>
                <div class="oaa-modal-empty">
                    <p><?php esc_html_e( $args[ 'empty_message' ] ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>