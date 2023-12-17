import * as addressTab from './address-tab';

const {
	addFilter
} = wp.hooks;

addFilter( 'jet.fb.register.settings-page.tabs', 'jet-form-builder', tabs => {
	tabs.push( addressTab );

	return tabs;
} );

