import BaseField from "./BaseField";

class SelectField extends BaseField {

	type_field() {
		return 'select';
	}

	onGet() {
		return this.baseFindField( 'select' );
	}

	/**
	 * trigger( 'change' ) for compatibility
	 * with select-autocomplete
	 */
	onSet() {
		this.field.val( this.dataField.value ).trigger( 'change' );
	}

	afterChange() {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: this.field.val(),
		} ) );
	}

	events() {
		return [
			{
				type: 'change.JetFormBuilderMain',
				selector: `.jet-form-builder__field.select-field`,
				callable: this.afterChange,
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field.select-field:not(.appointment-provider)',
				callable: this.afterChange,
			},
		];
	}
}

export default SelectField;