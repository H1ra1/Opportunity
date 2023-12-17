const {
	      FormTokenField: WpFormTokenField,
      } = wp.components;

const {
	      useMemo,
      } = wp.element;

function FormTokenField( {
	suggestions = [],
	value = [],
	valueProp = 'value',
	labelProp = 'label',
	...props
} ) {

	const [ valueToLabel, labelToValue ] = useMemo( () => {
		const valToLabel = {};
		const labelToVal = {};

		for ( const suggestion of suggestions ) {
			const val   = suggestion[ valueProp ] ?? '';
			const label = suggestion[ labelProp ] ?? '';

			valToLabel[ val ]   = label;
			labelToVal[ label ] = val;
		}

		return [ valToLabel, labelToVal ];
	}, [] );

	const labelSuggestions = useMemo(
		() => suggestions.map( current => current[ labelProp ] || '' ).filter(
			current => (
				current && !value.includes( labelToValue[ current ] )
			),
		),
		[ value ],
	);

	return <WpFormTokenField
		displayTransform={ countrySlug => (
			valueToLabel[ countrySlug ] ?? countrySlug
		) }
		saveTransform={ countryLabel => (
			labelToValue[ countryLabel ] ?? countryLabel
		) }
		suggestions={ labelSuggestions }
		value={ value }
		{ ...props }
	/>;
}

export default FormTokenField;