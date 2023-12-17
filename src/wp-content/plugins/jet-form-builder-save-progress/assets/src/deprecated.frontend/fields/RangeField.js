import BaseField from "./BaseField";
const $ = jQuery;

class RangeField extends BaseField {

	type_field() {
		return 'range';
	}

	onGet() {
		return this.baseFindField( 'input' );
	}

	onSet() {
		this.field.val( this.value );

		JetFormBuilder.updateRangeField( { target: $( this.field ) } );
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
				selector: '.jet-form-builder__field.range-field',
				callable: this.afterChange
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field.range-field',
				callable: this.afterChange
			}
		];
	}
}

export default RangeField;