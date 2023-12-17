import Manager, { storageKey } from './Manager';

window.JetSPManager = new Manager();
JetSPManager.handleEvents();

( function( $ ) {
	const getUrlParams = ( { url = '' } = {} ) => {
		let sourceUrl = decodeURIComponent( url ? url : window.location.href );
		const urlParts = sourceUrl.split( '?' );

		if ( ! urlParts[ 1 ] || ! urlParts[ 1 ].length ) {
			return {};
		}
		const arrParams = urlParts[ 1 ].split( '&' );
		const response = {};

		arrParams.forEach( param => {
			const [ key, value = '' ] = param.split( '=' );
			response[ key ] = value;
		} );

		return response;
	};

	const maybeClearStorage = request => {
		if ( ! request.jfb_clear_storage ) {
			return;
		}
		localStorage.removeItem( storageKey( request.jfb_clear_storage ) );
	};

	maybeClearStorage( getUrlParams() );

	const JFB = new Manager()
		.setNamespace( 'jet-form-builder' )
		.setSuccessHook( 'jet-form-builder/ajax/on-success' );

	const JE = new Manager()
		.setNamespace( 'jet-form' )
		.setSuccessHook( 'jet-engine/form/ajax/on-success' );

	$( document ).on(
		'jet-form-builder/after-init',
		JFB.init.bind( JFB ),
	);
	$( document ).on(
		'jet-engine/booking-form/init',
		JE.init.bind( JE ),
	);
} )( jQuery )