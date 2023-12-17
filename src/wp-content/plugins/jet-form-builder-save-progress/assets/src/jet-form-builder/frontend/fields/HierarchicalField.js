import SimpleField from './SimpleField';

function HierarchicalField() {
	SimpleField.call( this );

	this.isSupported = function ( input ) {
		const [ level ] = input.nodes;

		return level.classList.contains( 'jet-form-builder-hr-select-level' );
	};

	this.onLoadAsync = function ( data ) {
		const { value, loading } = this.input;

		if ( !loading.current ) {
			value.current = data.value;

			return Promise.resolve();
		}

		return new Promise( resolve => {
			const clearWatcher = loading.watch( () => {
				/**
				 * @type {InputData}
				 */
				const prevLevel = this.input.getPrevLevel();
				/**
				 * @type {{ field: SimpleField }}
				 */
				const progress  = prevLevel[ 'save-progress' ];

				if ( !progress.field.isLoaded ) {
					return;
				}
				clearWatcher();
				value.current = data.value;
				resolve();
			} );
		} );
	};
}

HierarchicalField.prototype = Object.create( SimpleField.prototype );

export default HierarchicalField;
