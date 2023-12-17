import InputField from './fields/InputField';
import CheckboxField from './fields/CheckboxField';
import RadioField from './fields/RadioField';
import MediaField from './fields/MediaField';
import RepeaterField from './fields/RepeaterField';
import WysiwygField from './fields/WysiwygField';
import RangeField from './fields/RangeField';
import TextareaField from './fields/TextareaField';
import SelectField from './fields/SelectField';
import AppointmentDate from './fields/AppointmentDate';
import AppointmentProvider from './fields/AppointmentProvider';
import BookingCheckInOut from './fields/BookingCheckInOut';
import MultiStepManager from './MultiStepManager';
import NamespaceBase from './NamespaceBase';

const $config = window.JetFormSaveProgress;
const storageKey = formId => (
	'jet_form_progress_' + formId
);
const $ = jQuery;
const { applyFilters } = wp.hooks;

class Manager extends NamespaceBase {

	initializedForms = [];

	Instances() {
		return applyFilters( 'jet-fb.save-progress.register.fields', [
			new InputField(),
			new CheckboxField(),
			new RadioField(),
			new MediaField(),
			new RepeaterField(),
			new WysiwygField(),
			new RangeField(),
			new TextareaField(),
			new SelectField(),
			new AppointmentProvider(),
			new AppointmentDate(),
			new BookingCheckInOut(),
		] );
	}

	getFormId( closure ) {
		if ( ! parseInt( closure ) ) {
			return closure.data( 'form-id' ) || closure.closest( 'form' ).data( 'form-id' );
		}
		return closure;
	};

	getFormStorage( closure ) {
		const def = { fields: {}, multi_step: {} };
		const form_id = this.getFormId( closure );
		const storage = JSON.parse( localStorage.getItem( storageKey( form_id ) ) );

		return (
			storage || def
		);
	};

	clearFormStorage( closure ) {
		const form_id = this.getFormId( closure );

		localStorage.removeItem( storageKey( form_id ) );
	}

	setFormStorage( closure, value = {}, key = 'fields' ) {
		const form_id = this.getFormId( closure );
		const storage = this.getFormStorage( form_id );

		localStorage.setItem(
			storageKey( form_id ),
			JSON.stringify( {
				...storage,
				[ key ]: { ...storage[ key ], ...value },
			} ),
		);
	};

	clearField( closure, field_name ) {
		const form_id = this.getFormId( closure );
		const storage = this.getFormStorage( form_id );

		storage.fields = storage.fields ?? {};
		delete storage.fields[ field_name ];

		localStorage.setItem(
			storageKey( form_id ),
			JSON.stringify( {
				...storage,
			} ),
		);
	}

	initProgress( closure, form_config, $root = null ) {
		const fields = Object.entries( form_config );
		const self = this;

		fields.forEach( ( [ nameField, dataField ] ) => {
			const instance = self.Instances().find( field => field.type === dataField.type );

			if ( instance.namespaces().length && ! instance.namespaces().includes( self._namespace ) ) {
				return;
			}

			if ( ! instance ) {
				throw new Error( `Undefined field type: ${ dataField.type }` );
			}
			if ( $root ) {
				instance.setRoot( $root );
			}

			instance.setNamespace( self._namespace ).setClosure( closure ).setName( nameField ).setDataField( dataField );

			const field = instance.onGet();

			if ( field && field.length ) {
				instance.setField( field );
				instance.onSet();
				instance.fieldTrigger();
			}

		} );
	};

	initMultiStep( formRoot, multiStep, namespace ) {
		const { toPage = 1 } = multiStep;

		new MultiStepManager( formRoot, toPage ).setNamespace( namespace ).addEvents().init();
	}

	init( event, $scope ) {
		const $root = this;
		const self = $scope.find( 'form' );
		const form_id = self.data( 'form-id' );

		if ( ! $config[ form_id ] ) {
			return;
		}

		if ( $config[ form_id ].clear_storage ) {
			$( document ).on( this._success_hook, ( event, response, $form, data ) => {
				if ( form_id !== $form.data( 'form-id' ) ) {
					return;
				}

				this.clearFormStorage( form_id );
			} );
		}

		if ( ! $config[ form_id ].enable ) {
			return;
		}

		if ( JetSPManager.initializedForms.includes( form_id ) ) {
			return;
		}

		const form_config = this.getFormStorage( form_id );

		if ( ! form_config ) {
			return;
		}

		const { fields = {}, multi_step = {} } = form_config;

		try {
			this.initProgress( self, fields, $root );
			this.initMultiStep( self, multi_step, this._namespace );
		} catch ( e ) {
			console.error( e );
		}

		JetSPManager.initializedForms.push( form_id );
	}

	eventCallbackWrapper( event, callable, field, additional ) {
		const self = $( event.target ),
			$form = self.closest( 'form' ),
			formId = $form.data( 'form-id' );

		if ( $config[ formId ] && $config[ formId ].enable ) {
			field.setNamespace(
				$form.hasClass( 'jet-form-builder' ) ? 'jet-form-builder' : 'jet-form',
			);
			field.setFormID( formId );
			field.setField( self );
			callable.call( field, ...additional );

			return true;
		}

		return false;
	}

	handleEvents() {
		this.Instances().forEach( field => {
			const events = applyFilters( `jet-fb.save-progress.events.${ field.type }`, field.events() );

			if ( ! events.length ) {
				throw new Error( `Please define events for the ${ field.type } field in the 'events' method` );
			}

			events.forEach( ( { type, selector = [], callable } ) => {
				let parsedSelector;
				if ( 'object' === typeof selector && undefined !== selector.length ) {
					parsedSelector = selector.join( ', ' );
				}
				if ( 'string' === typeof selector ) {
					parsedSelector = selector;
				}

				$( document ).on( type, parsedSelector, ( e, ...args ) => {
					this.eventCallbackWrapper( e, callable, field, args );
				} );

			} );
		} );
	}
}

export { storageKey };
export default Manager;

