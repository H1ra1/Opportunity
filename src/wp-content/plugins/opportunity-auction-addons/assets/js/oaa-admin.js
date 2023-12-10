( function( $ ) {

    function disableAcfInput( element ) {
        const INPUT = $( element ).find( 'input' );

        // Disable input.
        INPUT.attr( 'disabled', 'disabled' );
    }

    $( document ).ready( () => {
        console.log( 'OAA Admin Scripts Loaded!' );

        // Actions

        // Actions when body change
        $('body').on('DOMSubtreeModified', function(){
            if( $( '.disabled-input' ).length > 0 ) {
                $( '.disabled-input' ).each( ( index, element ) => disableAcfInput( element ) );
            }
        });
    } );
} ( jQuery ) );