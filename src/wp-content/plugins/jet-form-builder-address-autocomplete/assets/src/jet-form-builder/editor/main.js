import * as addressField from './address-field';

const {
	addFilter
} = wp.hooks;

addFilter( 'jet.fb.register.fields', 'jet-form-builder', blocks => {
	blocks.push( addressField );

	return blocks;
} );

