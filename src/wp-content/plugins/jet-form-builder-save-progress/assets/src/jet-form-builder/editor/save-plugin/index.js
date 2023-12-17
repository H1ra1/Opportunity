import PluginSaveProgress from "./render";

const { __ } = wp.i18n;

const base = {
	name: 'jf-save-progress',
	title: __( 'Form Progress' )
};

const settings = {
	render: PluginSaveProgress,
	icon: null
};

export {
	base,
	settings
};