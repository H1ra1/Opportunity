import AddressEdit from './edit';
import metadata from '@blocks/address-field/block.json';

const { __ } = wp.i18n;

const { name, icon } = metadata;

metadata.attributes.isPreview = {
	type: 'boolean',
	default: false,
};

/**
 * Available items for `useEditProps`:
 *  - uniqKey
 *  - formFields
 *  - blockName
 *  - attrHelp
 */
const settings = {
	title: __( 'Address Autocomplete Field', 'jet-form-builder' ),
	description: __(
		`Suggests up to five places in order to auto-fill the Address field.`,
		'jet-form-builder',
	),
	className: name.replace( '/', '-' ),
	icon: <span dangerouslySetInnerHTML={ { __html: icon } }></span>,
	edit: AddressEdit,
	useEditProps: [ 'uniqKey', 'blockName', 'attrHelp' ],
	example: {
		attributes: {
			isPreview: true,
		},
	},
};

export {
	metadata,
	name,
	settings,
};