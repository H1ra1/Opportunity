( function( $ ) {

    function disableAcfInput( element ) {
        const INPUT = $( element ).find( 'input' );

        // Disable input.
        INPUT.attr( 'disabled', 'disabled' );
    }

    function preBid( $event ) {
        $event.preventDefault();
        
        console.log( 'ok' );
    }

    $( document ).ready( () => {
        console.log( 'OAA Admin Scripts Loaded!' );

        // Actions.
        if( $( '[oaa-pre-bid-form]' ).length > 0 ) {
            $( '[oaa-pre-bid-form]' ).submit( preBid );
        }

        // Actions when body change.
        $('body').on('DOMSubtreeModified', function(){
            if( $( '.disabled-input' ).length > 0 ) {
                $( '.disabled-input' ).each( ( index, element ) => disableAcfInput( element ) );
            }
        });
    } );
} ( jQuery ) );