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
            updatePreBidNextBidsValues( BID_VALUE, AUCTION_PRODUCT_ID );
            console.log( response );
        } ).error( ( error ) => console.error( error ) );
    }

    function updatePreBidNextBidsValues( lastBid, auctionProductId ) {
        const PRE_BID_SELECT            = $( '#oaa-pre-bid-form-select' );
        const LAST_BID_VALUE_ELEMENT    = $( '.woo-ua-auction-price.starting-bid'  ).find( 'bdi' );
        const DATA                      = {
            action              : 'oaa_update_pre_bid_next_bids_values_ajax',
            nonce               : main_params.nonce,
            last_bid_value      : lastBid,
            auction_product_id  : auctionProductId
        }

        console.log( LAST_BID_VALUE_ELEMENT );

        $.ajax( {
            url     : main_params.ajax_url,
            method  : 'POST',
            data    : DATA
        } ).done( ( response ) => {
            LAST_BID_VALUE_ELEMENT.html( `<span class="woocommerce-Price-currencySymbol">R$</span> ${ response.current_bid }` );

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

    $( document ).ready( () => {
        console.log( 'OAA Scripts Loaded!' );

        // Actions.
        if( $( '[oaa-pre-bid-form]' ).length > 0 ) {
            $( '[oaa-pre-bid-form]' ).submit( preBid );
        }

        if( $( '[oaa-menu-tab]' ).length > 0 ) {
            $( '[oaa-menu-tab]' ).click( changeMenuTab );
        }
    } );
} ( jQuery ) );