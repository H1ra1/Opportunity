import BaseField from './BaseField';

const { applyFilters } = wp.hooks;

class InputField extends BaseField {

	type_field() {
		return 'input';
	}

	onGet() {
		return this.baseFindField( 'input' );
	}

	onSet() {
		this.onSetSimple();
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
				selector: [
					'.jet-form-builder__field.text-field',
					'.jet-form-builder__field.date-field',
					'.jet-form-builder__field.datetime-field',
					'.jet-form-builder__field.time-field',
					'.jet-form-builder__field.jet-address-autocomplete',
				],
				callable: this.afterChange,
			},
			{
				type: 'change.JetEngine',
				selector: [
					'.jet-form__field.text-field',
					'.jet-form__field.date-field',
					'.jet-form__field.datetime-field',
					'.jet-form__field.time-field',
					'.jet-form__field.jet-address-autocomplete',
				],
				callable: this.afterChange,
			},
		];
	}
}

export default InputField;