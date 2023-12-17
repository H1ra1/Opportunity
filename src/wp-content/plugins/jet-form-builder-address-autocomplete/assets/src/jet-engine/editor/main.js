import AddressFields from "./AddressFields.vue";

const { addFilter } = wp.hooks;

addFilter( 'jet.engine.register.fields', 'jet-engine', fields => {
	fields.push( AddressFields );

	return fields;
} );
