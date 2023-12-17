import BaseField from './BaseField';

class BookingCheckInOut extends BaseField {

	type_field() {
		return 'booking_check_in_out';
	}

	onGet() {
		return this.baseFindFieldByName( 'input' );
	}

	namespaces() {
		return [
			'jet-form'
		];
	}

	onSet() {
		if ( ! this.value ) {
			return;
		}

		if ( 'text' === this.field.attr( 'type' ) ) {
			this.onSetSimple();

			return;
		}

		const [ checkIn, checkOut ] = this.value.split( ' - ' );

		const separateWrapper = this.field.closest( '.jet-abaf-separate-fields' );

		this.baseFindFieldByName( 'input', separateWrapper, `${ this.fieldName }__in` ).val( checkIn );
		this.baseFindFieldByName( 'input', separateWrapper, `${ this.fieldName }__out` ).val( checkOut );
	}

	getCustomFieldName( field = null ) {
		return this.getParsedFieldName( field );
	}

	afterChange() {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: this.field.val()
		} ) );
	}

	events() {
		return [
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field[data-field="checkin-checkout"]',
				callable: this.afterChange
			}
		];
	}
}

export default BookingCheckInOut;