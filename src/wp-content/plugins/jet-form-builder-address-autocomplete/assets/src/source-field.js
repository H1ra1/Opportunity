import countriesList from './countries.json';

const { __ } = wp.i18n;

const defaultResponse = {
	countries: [],
	types: [],
};

const labels = {
	countries: __( 'Countries allowed' ),
	types: __( 'Place types' ),
};

const help = {
	types_link: 'https://developers.google.com/maps/documentation/places/web-service/supported_types',
};

const valueToLabelCountries = {};
const labelToValueCountries = {};
const labelCountries        = [];

for ( const { value, label } of countriesList ) {
	valueToLabelCountries[ value ] = label;
	labelToValueCountries[ label ] = value;
	labelCountries.push( label );
}

const types = [
	{
		value: 'geocode',
		label: 'Geocode',
	},
	{
		value: 'address',
		label: 'Address',
	},
	{
		value: 'establishment',
		label: 'Establishment',
	},
	{
		value: '(regions)',
		label: 'Regions',
	},
	{
		value: '(cities)',
		label: 'Cities',
	},
];

const valueToLabelTypes = {};
const labelToValueTypes = {};
const labelTypes        = [];

for ( const { value, label } of types ) {
	valueToLabelTypes[ value ] = label;
	labelToValueTypes[ label ] = value;
	labelTypes.push( label );
}

export {
	labels,
	types,
	help,
	defaultResponse,
	valueToLabelCountries,
	labelToValueCountries,
	labelCountries,
	valueToLabelTypes,
	labelToValueTypes,
	labelTypes,
	countriesList,
};

