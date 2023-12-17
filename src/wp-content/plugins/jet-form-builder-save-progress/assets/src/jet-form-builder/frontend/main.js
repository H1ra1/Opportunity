import { initClearFormStorage, initFields, initMultistep } from './functions';

const { addAction } = JetPlugins.hooks;

addAction(
	'jet.fb.observe.after',
	'jet-form-builder-save-progress',
	/**
	 * @param observable {Observable}
	 */
	function ( observable ) {
		// for repeater
		if ( observable.parent ) {
			initFields( observable );

			return;
		}

		setTimeout( () => {
			initClearFormStorage( observable );
			initFields( observable );
			initMultistep( observable );
		} );
	},
	11,
);