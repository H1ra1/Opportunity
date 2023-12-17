import SimpleField from './SimpleField';

/**
 * @property {RepeaterData} input
 */
function RepeaterField() {
	SimpleField.call( this );
}

RepeaterField.prototype = Object.create( SimpleField.prototype );

RepeaterField.prototype.isSupported = function ( input ) {
	const [ node ] = input.nodes;

	return 1 === +node.dataset.repeater;
};

RepeaterField.prototype.onLoad = function ( { value } ) {
	const rows = Object.keys( value );

	for ( const index of rows ) {
		/**
		 * @type {ObservableRow|null}
		 */
		const observedRow = this.input.value[ index ] ?? null;

		if ( !observedRow ) {
			this.input.addNew();
		}
	}

	/**
	 *
	 * @type {[string, ObservableRow][]}
	 */
	const currentRows = Object.entries( this.input.value.current );

	for ( const [ rowIndex, row ] of currentRows ) {
		if ( rows.includes( rowIndex ) ) {
			continue;
		}
		row.remove();
	}
};

RepeaterField.prototype.getValue = function () {
	/**
	 * @type {ObservableRow[]}
	 */
	const rows     = Object.values( this.input.value.current );
	const response = [];

	for ( const row of rows ) {
		const current = {};

		for ( const input of row.getInputs() ) {
			if ( ! input.hasOwnProperty( 'save-progress' ) ) {
				continue;
			}
			/**
			 * @see SimpleField.onReady
			 * @type {SimpleField}
			 */
			const field = input[ 'save-progress' ].field;

			current[ input.name ] = { value: field.getValue() };
		}

		response.push( current );
	}

	return response;
};

export default RepeaterField;