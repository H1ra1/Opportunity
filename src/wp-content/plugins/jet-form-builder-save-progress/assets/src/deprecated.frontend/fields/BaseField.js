import NamespaceBase from '../NamespaceBase';

const $ = jQuery;
const { applyFilters } = wp.hooks;
const $config = window.JetFormSaveProgress;

class BaseField extends NamespaceBase {

	get type() {
		if ( ! this.type_field() ) {
			throw new Error( 'Please define the type of the field in the `type_field` method' )
		}
		return this.type_field();
	}

	onSet() {
		throw new Error( `Please define the 'onSet' method in the '${ this.type }'` );
	}

	onGet() {
		throw new Error( `Please define the 'onGet' method in the '${ this.type }'` );
	}

	get value() {
		return this.dataField.value;
	}

	setFormID( id ) {
		this.form_id = id;
	}

	setRoot( $root ) {
		this.$root = $root;
	}

	callFuncWithAnotherNamespace( initial, changeTo, callable ) {
		let engineBike = false;
		if ( this._namespace === initial ) {
			engineBike = true;
			this._namespace = changeTo;
		}

		const response = callable( this );

		if ( engineBike && this._namespace === changeTo ) {
			this._namespace = initial;
		}

		return response;
	}

	type_field() {
		return false;
	}

	setClosure( value ) {
		this.closure = value;

		return this;
	}

	setName( value ) {
		this.fieldName = value

		return this;
	}

	setDataField( value ) {
		this.dataField = value

		return this;
	}

	setField( field ) {
		this.field = field;

		return this;
	}

	baseFindField( tag ) {
		return this.closure.find( `${ tag }[data-field-name="${ this.fieldName }"]` );
	}

	baseFindFieldByName( tag, closure = this.closure, fieldName = this.fieldName ) {
		let field = closure.find( `${ tag }[name="${ fieldName }"]` );

		if ( ! field.length ) {
			return closure.find( `${ tag }[name$="][${ fieldName }]"]` );
		}

		return field
	}

	onSetSimple() {
		this.field.val( this.dataField.value );
	}
	fieldTrigger() {
		if ( 'jet-form-builder' === this._namespace ) {
			this.field.trigger( 'change.JetFormBuilderMain' )
		} else {
			this.field.trigger( 'change.JetEngine' )
		}
	}

	getCustomFieldName( field = null ) {
		if ( null === field ) {
			field = this.field;
		}

		return field.data( 'field-name' );
	}

	inRepeater( field = null ) {
		if ( null === field ) {
			field = this.field;
		}
		const fieldName = field.attr( 'name' );

		return /^([\w-]+)\[(\d+)\]\[[\w-]+\]$/.test( fieldName );
	}

	getParsedFieldName( field = null ) {
		if ( null === field ) {
			field = this.field;
		}

		const name = field.attr( 'name' );
		if ( this.inRepeater( field ) ) {
			const [ full, parsedName ] = name.match( /^[\w-]+\[\d+\]\[([\w-]+)\]$/ );

			return parsedName;
		}
		return name;
	}

	getClosestRepeater( field = null ) {
		if ( null === field ) {
			field = this.field;
		}

		return this.callFuncWithAnotherNamespace( 'jet-engine', 'jet-form', self => {
			return [
				field.closest( self.className( '-repeater' ) ),
				field.closest( self.className( '-repeater__row' ) ),
			];
		} );
	};

	insertRepeaterRow( repeater, lastRow, newValue = {} ) {
		const $form = this.form_id ? this.form_id : repeater.closest( 'form' );

		const { fields } = JetSPManager.getFormStorage( $form );
		const thisRepeater = fields[ repeater.data( 'field-name' ) ];

		lastRow = $( lastRow );
		const lastIndex = lastRow.data( 'index' );
		const values = thisRepeater ? thisRepeater.value : {};

		const rowValue = { ...( values[ lastIndex ] ? values[ lastIndex ].fields : {} ), ...newValue };

		values[ lastIndex ] = {
			status: 'active',
			fields: rowValue,
		};

		JetSPManager.setFormStorage( $form, this.val( {
			field: repeater,
			type:  'repeater',
			value: values,
		} ) );
	}

	val( {
			 value,
			 type = this.type,
			 checkInRepeater = true,
			 field = this.field,
		 } ) {
		const fieldName = this.getCustomFieldName( field );

		const simpleVal = {
			[ fieldName ]: { type, value },
		};

		if ( ! checkInRepeater ) {
			return simpleVal;
		}

		if ( this.inRepeater( field ) ) {
			const [ $repeater, currentRow ] = this.getClosestRepeater( field );

			this.insertRepeaterRow( $repeater, currentRow, this.val( {
				value,
				field,
				checkInRepeater: false,
			} ) );
		} else {
			return simpleVal;
		}
	}

	clear( { ifEmpty = [], field = this.field, closure = this.field } = {} ) {
		const fieldName = field.data( 'field-name' );

		JetSPManager.clearField( closure, fieldName );
	}

	getVal( { ifEmpty = [], field = this.field, closure = this.field } = {} ) {
		const { fields } = JetSPManager.getFormStorage( closure );
		const fieldName = field.data( 'field-name' );
		const inRepeater = this.inRepeater();

		if ( inRepeater ) {
			const [ $repeater, currentRow ] = this.getClosestRepeater(),
				  repeaterName              = $repeater.data( 'field-name' ),
				  currentIndex              = currentRow.data( 'index' );

			if ( fields[ repeaterName ]
				&& fields[ repeaterName ].value[ currentIndex ]
				&& fields[ repeaterName ].value[ currentIndex ].fields[ fieldName ]
			) {
				return fields[ repeaterName ].value[ currentIndex ].fields[ fieldName ].value
			}

			return ifEmpty;
		}

		return fields[ fieldName ] ? fields[ fieldName ].value : ifEmpty;
	};

	events() {
		return [];
	}

	namespaces() {
		return [];
	}

}

export default BaseField;