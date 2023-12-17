const { __ } = wp.i18n;

const labels = {
	enable: __( 'Save form progress', 'jet-form-builder-save-progress' ),
	clear_storage: __( 'Clear saved form data after successful submission', 'jet-form-builder-save-progress' ),
};

const options = {
	id: '_jf_save_progress',
	slug: 'jf-save-progress',
};

export {
	labels,
	options,
};