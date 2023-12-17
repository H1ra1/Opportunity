import * as addressTab from './address';

const {
	addFilter
} = wp.hooks;

addFilter( 'jet.engine.formTabs.register', 'jet-engine', tabs => {
	tabs.push( addressTab );

	return tabs;
} );