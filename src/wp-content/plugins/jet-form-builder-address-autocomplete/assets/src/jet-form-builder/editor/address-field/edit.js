import {
	countriesList,
	labels,
	help,
	types,
} from '@/source-field';

import FormTokenField from '../FormTokenField';
import preview from './preview';

const {
	      AdvancedFields,
	      GeneralFields,
	      ToolBarFields,
	      FieldWrapper,
	      BaseHelp,
      } = JetFBComponents;

const {
	      TextControl,
	      PanelBody,
	      ExternalLink,
      } = wp.components;
const {
	      __,
      } = wp.i18n;

const {
	      InspectorControls,
	      useBlockProps,
      } = wp.blockEditor;

function AddressEdit( props ) {
	const blockProps = useBlockProps();

	const {
		      attributes,
		      setAttributes,
		      isSelected,
		      editProps: { uniqKey },
	      } = props;

	if ( attributes.isPreview ) {
		return <div style={ {
			width: '100%',
			display: 'flex',
			justifyContent: 'center',
		} }>
			{ preview }
		</div>;
	}

	return [
		<ToolBarFields
			key={ uniqKey( 'ToolBarFields' ) }
			{ ...props }
		/>,
		isSelected && <InspectorControls
			key={ uniqKey( 'InspectorControls' ) }
		>
			<GeneralFields
				key={ uniqKey( 'GeneralFields' ) }
				{ ...props }
			/>
			<PanelBody
				title={ __( 'Field Settings' ) }
				key={ uniqKey( 'PanelBody' ) }
			>
				<FormTokenField
					autoComplete={ 'off' }
					label={ labels.countries }
					value={ attributes.countries }
					suggestions={ countriesList }
					onChange={ countries => setAttributes( { countries } ) }
					maxSuggestions={ countriesList.length }
					tokenizeOnSpace
					__experimentalExpandOnFocus
				/>
				<FormTokenField
					label={ labels.types }
					value={ attributes.types }
					suggestions={ types }
					onChange={ types => setAttributes( { types } ) }
					tokenizeOnSpace
					__experimentalExpandOnFocus
					__experimentalShowHowTo={ '' }
				/>
				<BaseHelp>
					{ __( 'Separate with commas or the Enter key.' ) + ' ' }
					{ __(
						`You can only use one of the following types. 
Or several of those listed in Tables 1 and 2.`,
						'jet-form-builder-address-autocomplete',
					) }
				</BaseHelp>
				<ExternalLink href={ help.types_link }>
					{ __(
						'Place Types',
						'jet-form-builder-address-autocomplete',
					) }
				</ExternalLink>
			</PanelBody>
			<AdvancedFields
				key={ uniqKey( 'AdvancedFields' ) }
				{ ...props }
			/>
		</InspectorControls>,
		<div { ...blockProps } key={ uniqKey( 'viewBlock' ) }>
			<FieldWrapper
				key={ uniqKey( 'FieldWrapper' ) }
				{ ...props }
			>
				<TextControl
					placeholder={ attributes.placeholder }
					key={ uniqKey( 'place_holder_block' ) }
					onChange={ () => {
					} }
				/>
			</FieldWrapper>
		</div>,
	];
}

export default AddressEdit;