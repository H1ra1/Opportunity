( function( $ ) {

    function preBid( $event ) {
        $event.preventDefault();
        
        const FORM                  = $( $event.currentTarget );
        const SELECT                = FORM.find( 'select' );
        const BID_VALUE             = SELECT.val();
        const AUCTION_PRODUCT_ID    = FORM.attr( 'oaa-pre-bid-form' );
        const DATA                  = {
            action              : 'oaa_new_pre_bid_ajax',
            nonce               : main_params.nonce,
            bid_value           : BID_VALUE,
            auction_product_id  : AUCTION_PRODUCT_ID
        }

        $.ajax( {
            url     : main_params.ajax_url,
            method  : 'POST',
            data    : DATA
        } ).done( ( response ) => {
            if( response.success )
                updateBidNextBidsValues( BID_VALUE, AUCTION_PRODUCT_ID );
        } ).error( ( error ) => console.error( error ) );
    }

    function bid( $event ) {
        $event.preventDefault();
        
        const FORM                  = $( $event.currentTarget );
        const SELECT                = FORM.find( 'select' );
        const BID_VALUE             = SELECT.val();
        const AUCTION_PRODUCT_ID    = FORM.attr( 'oaa-bid-form' );
        const DATA                  = {
            action              : 'uwa_ajax_placed_bid',
            nonce               : main_params.nonce,
            uwa_bid_value       : BID_VALUE,
            uwa_place_bid       : AUCTION_PRODUCT_ID
        }

        $.ajax( {
            url     : main_params.ajax_url,
            method  : 'POST',
            data    : DATA,
            dataType: 'json'
        } ).done( ( response ) => {
            if( response.allstatus == 1 )
                updateBidNextBidsValues( BID_VALUE, AUCTION_PRODUCT_ID );
        } ).error( ( error ) => console.error( error ) );
    }

    function updateBidNextBidsValues( lastBid, auctionProductId ) {
        const PRE_BID_SELECT            = $( '#oaa-bid-form-select' );
        const LAST_BID_VALUE_ELEMENT    = $( '.oaa-bid-price-value'  );
        const DATA                      = {
            action              : 'oaa_update_bid_next_bids_values_ajax',
            nonce               : main_params.nonce,
            last_bid_value      : lastBid,
            auction_product_id  : auctionProductId
        }

        $.ajax( {
            url     : main_params.ajax_url,
            method  : 'POST',
            data    : DATA
        } ).done( ( response ) => {
            LAST_BID_VALUE_ELEMENT.html( `R$ ${ response.current_bid.toLocaleString( 'pt-br', { style: 'currency', currency: 'BRL' } ) }` );

            PRE_BID_SELECT.html( '' );

            response.next_bids.forEach( ( nextBid ) => {
                PRE_BID_SELECT.append( `<option value="${ nextBid }">${ nextBid.toLocaleString( 'pt-br', { style: 'currency', currency: 'BRL' } ) }</option>` )
            } );
        } ).error( ( error ) => console.error( error ) );
    }

    function changeMenuTab( element ) {
        const CURRENT_TAB           = $( element.currentTarget );
        const TAB_TO_ACTIVE_TAG     = CURRENT_TAB.attr( 'oaa-menu-tab' );
        const TAB_TO_ACTIVE_ELEMENT = $( `[oaa-menu-tab-item=${TAB_TO_ACTIVE_TAG}]` );
        const TABS                  = $( '[oaa-menu-tab]' );
        const TABS_ITEMS            = $( '[oaa-menu-tab-item]' );

        TABS.removeClass( '--active' );
        TABS_ITEMS.removeClass( '--active' );


        CURRENT_TAB.addClass( '--active' );
        TAB_TO_ACTIVE_ELEMENT.addClass( '--active' );
        console.log( TAB_TO_ACTIVE_ELEMENT );
    }

    function oaaControlModal( $element ) {7
        const CURENT_BUTTON         = $( $element.currentTarget );
        const ID                    = CURENT_BUTTON.attr( 'oaa-modal-open' );
        const MODAL_TO_ACTIVE       = $( `[oaa-modal=${ ID }]` );
        const MODAL_BOX             = MODAL_TO_ACTIVE.find( '.oaa-modal' );
        const CURRENT_CLOSE_BUTTON  = MODAL_TO_ACTIVE.find( '[oaa-modal-close]' );

        MODAL_TO_ACTIVE.addClass( '--active' );
        MODAL_BOX.fadeIn( 'slow' );

        CURRENT_CLOSE_BUTTON.click( () => {
            MODAL_BOX.fadeOut( 'slow', () => {
                MODAL_TO_ACTIVE.removeClass( '--active' );
            } );
        } );

        MODAL_TO_ACTIVE.click( ( $event ) => {
            $event.stopPropagation();

            if( !$( $event.target ).hasAttr( 'oaa-modal' ) ) return;

            MODAL_BOX.fadeOut( 'slow', () => {
                MODAL_TO_ACTIVE.removeClass( '--active' );
            } );
        } );
    }

    $( document ).ready( () => {
        console.log( 'OAA Scripts Loaded!' );

        // Actions.
        if( $( '[oaa-pre-bid-form]' ).length > 0 ) {
            $( '[oaa-pre-bid-form]' ).submit( preBid );
        }

        if( $( '[oaa-bid-form]' ).length > 0 ) {
            $( '[oaa-bid-form]' ).submit( bid );
        }

        if( $( '[oaa-menu-tab]' ).length > 0 ) {
            $( '[oaa-menu-tab]' ).click( changeMenuTab );
        }

        if( $( '[oaa-modal-open]' ).length > 0 ) {
            $( '[oaa-modal-open]' ).click( oaaControlModal );
        }
    } );
} ( jQuery ) );