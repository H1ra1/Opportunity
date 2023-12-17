import BaseField from './BaseField';

class AppointmentProvider extends BaseField {

	type_field() {
		return 'appointment_provider';
	}

	onGet() {
		const field = this.baseFindFieldByName( 'input' );

		if ( ! field.length ) {
			return this.baseFindFieldByName( 'select' );
		}

		return field;
	}

	namespaces() {
		return [
			'jet-form'
		];
	}

	onSet() {
		const self = this;

		const field = this.field.filter( function() {
			return this.value === self.value;
		} );
		const wrapper = field.closest( this.className( '__field-wrap' ) );

		if ( ! wrapper.length ) {
			this.onSetSimple();

			return;
		}
		const checkMark = wrapper.find( this.className( '__field-template' ) );

		checkMark.click();
	}

	afterChange() {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: this.field.val(),
		} ) );
	}

	getCustomFieldName( field = null ) {
		return this.getParsedFieldName( field );
	}

	events() {
		return [
			{
				type: 'change.JetEngine',
				selector: [
					'.jet-form__fields-group.appointment-provider .jet-form__field.radio-field',
					'.jet-form__field.select-field.appointment-provider',
				],
				callable: this.afterChange,
			},
		];
	}

}

export default AppointmentProvider;