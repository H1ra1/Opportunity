const { __ } = wp.i18n;

const label = {
	api_key: __( 'Google Places API key', 'jet-form-builder-address-autocomplete' ),
	disable_js: __( 'Disable Google Maps API JS file', 'jet-form-builder-address-autocomplete' ),
};

const help = {
	disable_js: __( 'Disable Google Maps API JS file, if it already included by another plugin or theme', 'jet-form-builder-address-autocomplete' ),
	apiPref: __( 'How to obtain your Google Places API key? More info', 'jet-form-builder-address-autocomplete' ),
	apiLinkLabel: __( 'here', 'jet-form-builder-address-autocomplete' ),
	apiLink: 'https://console.cloud.google.com/apis/credentials',
};

export {
	label,
	help,
};