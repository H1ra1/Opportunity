import { Actions } from 'jfb-editor';

const { __ } = wp.i18n;

const getLocalizedFullPack = new Actions.EditorData( 'redirect_to_checkout' ).setLabels( {
	product_manual: __( 'Input product ID', 'jet-form-builder-woo-action' ),
	product_id_from: __( 'Get product ID from', 'jet-form-builder-woo-action' ),
	product_id_field: __( 'Product ID field', 'jet-form-builder-woo-action' ),
	wc_price: __( 'WooCommerce Price field', 'jet-form-builder-woo-action' ),
	wc_order_details: __( 'WooCommerce order details', 'jet-form-builder-woo-action' ),
	wc_fields_map: __( 'WooCommerce checkout fields map', 'jet-form-builder' ),
	wc_details__type: __( 'Type', 'jet-form-builder-woo-action' ),
	wc_details__label: __( 'Label', 'jet-form-builder-woo-action' ),
	wc_details__date_format: __( 'Date format', 'jet-form-builder-woo-action' ),
	wc_details__field: __( 'Select form field', 'jet-form-builder-woo-action' ),
	wc_details__link_label: __( 'Link text', 'jet-form-builder-woo-action' ),
	wc_heading_order_details: __( 'Heading for Order Details', 'jet-form-builder-woo-action' ),
} ).exportAll();

export { getLocalizedFullPack };