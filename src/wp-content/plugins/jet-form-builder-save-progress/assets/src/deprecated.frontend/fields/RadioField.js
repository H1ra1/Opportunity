import BaseField from './BaseField';

const $ = jQuery;

class RadioField extends BaseField {

	type_field() {
		return 'radio';
	}

	onGet() {
		return this.baseFindFieldByName( 'input' );
	}

	onSet() {
		const self = this;

		self.field.each( function() {
			$( this ).attr( 'checked', this.value === self.value ? 'checked' : false );
		} );
	}

	getCustomFieldName( field = null ) {
		return this.getParsedFieldName( field );
	}

	afterChange() {
		if ( ! this.field[0]?.checked ) {
			return;
		}
		const value = this.field.val();

		JetSPManager.setFormStorage( this.form_id, this.val( {
			value,
		} ) );
	}

	events() {
		return [
			{
				type: 'change.JetFormBuilderMain',
				selector: '.jet-form-builder__field.radio-field',
				callable: this.afterChange,
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__fields-group:not(.appointment-provider) .jet-form__field.radio-field',
				callable: this.afterChange,
			},
		];
	}
}

export default RadioField;