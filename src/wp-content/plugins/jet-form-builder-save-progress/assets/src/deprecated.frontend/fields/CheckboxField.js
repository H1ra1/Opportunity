import BaseField from "./BaseField";
const $ = jQuery;

class CheckboxField extends BaseField {

	type_field() {
		return 'checkbox';
	}

	onGet() {
		return this.baseFindField( 'input' );
	}

	onSet() {
		const self = this;

		self.field.each( function () {
			if ( 'object' !== typeof self.value ) {
				return;
			}

			if ( self.value[ this.value ] ) {
				$( this ).attr( 'checked', self.value[ this.value ].checked ? 'checked' : false );
				if ( 'jet-form-builder' === self._namespace ) {
					$( this ).trigger( 'change.JetFormBuilderMain' );
				} else {
					$( this ).trigger( 'change.JetEngine' );
				}
			}
		} );
	}

	afterChange() {
		let value = this.getVal();

		value = {
			...value,
			[ this.field.val() ]: { checked: this.field.is( ':checked' ) }
		};

		JetSPManager.setFormStorage( this.form_id, this.val( { value } ) );
	}

	events() {
		return [
			{
				type: 'change.JetFormBuilderMain',
				selector: '.jet-form-builder__field.checkboxes-field',
				callable: this.afterChange
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field.checkboxes-field',
				callable: this.afterChange
			}
		];
	}
}

export default CheckboxField;