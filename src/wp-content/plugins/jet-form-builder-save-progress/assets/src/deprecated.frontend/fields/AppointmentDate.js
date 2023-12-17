import BaseField from './BaseField';

const $ = jQuery;

class AppointmentDate extends BaseField {

	type_field() {
		return 'appointment_date';
	}

	onGet() {
		return this.closure.find( `div.field-type-appointment_date[data-field="${ this.fieldName }"] input[type="hidden"]` );
	}

	namespaces() {
		return [
			'jet-form'
		];
	}

	onSet() {
		if ( ! this.value ) {
			this.onSetSimple();
		}
		const [ date, slot, slotEnd ] = this.value.split( '|' );
		const root = this.field.closest( '.jet-apb-calendar' );

		const calendarBody = root.find( '.jet-apb-calendar-body' );
		const calendarHeader = root.find( '.jet-apb-calendar-header' );

		const getDifferenceOfMonths = () => {
			const currentDate = calendarBody.find( '.jet-apb-calendar-date' ).data( 'calendar-date' );
			const firstDate = new Date( currentDate * 1000 );
			const valueDate = new Date( date * 1000 );

			const [ firstMonth, firstYear ] = [ firstDate.getMonth(), firstDate.getFullYear() ];
			const [ valMonth, valYear ] = [ valueDate.getMonth(), valueDate.getFullYear() ];

			const firstCombine = firstMonth + firstYear;
			const valCombine = valMonth + valYear;

			let inFuture;
			let result = 0;

			if ( firstDate > valueDate && firstCombine > valCombine ) {
				const addedMonth = ( firstYear - valYear ) * 12;
				inFuture = false;
				result = ( firstMonth - valMonth + addedMonth );
			}

			if ( firstDate < valueDate && firstCombine < valCombine ) {
				const addedMonth = ( valYear - firstYear ) * 12;
				inFuture = true;
				result = ( valMonth - firstMonth + addedMonth );
			}

			return [ inFuture, result ];
		};

		const [ inFuture, differenceOfMonth ] = getDifferenceOfMonths();


		if ( true === inFuture && differenceOfMonth ) {
			for ( let i = 0; i < differenceOfMonth; i++ ) {
				calendarHeader.find( '[data-calendar-toggle="next"]' ).click();
			}
		} else if ( false === inFuture && differenceOfMonth ) {
			for ( let i = 0; i < differenceOfMonth; i++ ) {
				calendarHeader.find( '[data-calendar-toggle="next"]' ).click();
			}
		}

		const dateElement = calendarBody.find( `[data-calendar-date="${ date }"]` );

		if ( 'true' !== dateElement.attr( 'data-status' ) ) {
			return;
		}

		const hiddenField = calendarBody.siblings( 'input[type="hidden"]' );

		window.addEventListener( 'jet-apb-calendar-slots--loaded', function() {
			const slotElement = root.find( `.jet-apb-calendar-slots [data-slot="${ slot }"]` );

			slotElement.click();
		} );

		dateElement.find( '.jet-apb-calendar-date-body' ).click();
		hiddenField.val( this.value );
	}

	getCustomFieldName( field = null ) {
		return this.getParsedFieldName( field );
	}

	afterChange() {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: this.field.val(),
		} ) );
	}

	events() {
		return [
			{
				type: 'change',
				selector: 'div.field-type-appointment_date input[type="hidden"]',
				callable: this.afterChange,
			},
		];
	}
}

export default AppointmentDate;