import { updateFieldsStorage } from '../functions';

function SimpleField() {
	this.input    = null;
	this.isLoaded = false;
}

SimpleField.prototype = {
	/**
	 * @type {InputData}
	 */
	input: null,
	isLoaded: false,
	/**
	 * @param {InputData} input
	 */
	isSupported( input ) {
		const [ node ] = input.nodes;

		// for all
		return 'file' !== node?.type;
	},
	/**
	 * @param input {InputData}
	 */
	setInput( input ) {
		this.input = input;

		this.input[ 'save-progress' ] = { field: this };
	},
	/**
	 * @param data
	 * @return {(function(*): void)|*}
	 */
	load( data ) {
		return resolve => {
			this.onLoadAsync( data ).finally( () => {
				this.onReady();
				resolve();
			} );
		};
	},
	/**
	 * @param data
	 * @return {Promise<void>}
	 */
	onLoadAsync( data ) {
		this.onLoad( data );

		return Promise.resolve();
	},
	/**
	 * @param data {{
	 *     type: String,
	 *     value: mixed
	 * }}
	 */
	onLoad( data ) {
		this.input.value.current = data.value;
	},
	onReady() {
		this.isLoaded = true;
		this.input.watch( () => updateFieldsStorage( this ) );
	},
	getValue() {
		return this.input.value.current;
	},
};

export default SimpleField;