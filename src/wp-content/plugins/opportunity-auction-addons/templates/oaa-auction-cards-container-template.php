<div class="oaa-auction-cards-container">
    <?php if( isset( $args[ 'cards' ] ) && is_array( $args[ 'cards' ] ) ): ?>
        <?php foreach( $args[ 'cards' ] as $card ): ?>
            <?php echo $card; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>