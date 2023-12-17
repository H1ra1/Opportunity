import * as plugin from './save-plugin';

const {
	addFilter
} = wp.hooks;

addFilter( 'jet.fb.register.plugin.jf-actions-panel.after', 'jet-form-builder', plugins => {
	plugins.push( plugin );

	return plugins;
} );

