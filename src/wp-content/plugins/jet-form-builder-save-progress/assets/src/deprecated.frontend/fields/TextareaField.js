import BaseField from "./BaseField";

class TextareaField extends BaseField {

	type_field() {
		return 'textarea';
	}

	onGet() {
		return this.baseFindField( 'textarea' );
	}

	onSet() {
		this.onSetSimple();
	}

	afterChange() {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: this.field.val()
		} ) );
	}

	events() {
		return [
			{
				type: 'change.JetFormBuilderMain',
				selector: '.jet-form-builder__field.textarea-field',
				callable: this.afterChange
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field.textarea-field',
				callable: this.afterChange
			}
		];
	}
}

export default TextareaField;