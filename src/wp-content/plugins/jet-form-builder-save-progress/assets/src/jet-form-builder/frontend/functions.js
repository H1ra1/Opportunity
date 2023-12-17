import SimpleField from './fields/SimpleField';
import RepeaterField from './fields/RepeaterField';
import HierarchicalField from './fields/HierarchicalField';

const $config = window.JetFormSaveProgress || {};

/**
 * @param observable {Observable}
 */
function initClearFormStorage( observable ) {
	const formID = observable.getSubmit().getFormId();

	if ( !$config[ formID ]?.clear_storage ) {
		return;
	}

	const { submitter } = observable.getSubmit();

	// isn't ajax-type
	if ( submitter.hasOwnProperty( 'status' ) ) {
		submitter.watchSuccess( () => removeFormStorage( formID ) );
	}

	const request = getUrlParams();

	if ( !request.jfb_clear_storage ) {
		return;
	}

	removeFormStorage( formID );
}

/**
 * @param observable {Observable}
 */
function initFields( observable ) {
	const formID = observable.getSubmit().getFormId();

	if ( !$config[ formID ]?.enable ) {
		return;
	}

	const storageFields = getStorageFields( observable );
	const callbacks     = [];

	for ( const input of observable.getInputs() ) {
		const field = getFieldByType( input );

		if ( !field ) {
			continue;
		}

		if ( storageFields.hasOwnProperty( input.name ) ) {
			callbacks.push( field.load( storageFields[ input.name ] ) );
		}
		else {
			field.onReady();
		}
	}

	Promise.all( callbacks.map( current => new Promise( current ) ) ).then(
		() => {
			// silence is golden
		},
	);
}

/**
 * @param observable {Observable}
 */
function initMultistep( observable ) {
	const formID = observable.getSubmit().getFormId();

	if ( !observable.multistep || !$config[ formID ]?.enable ) {
		return;
	}
	const { multi_step = {} } = getFormStorage( formID );

	if ( multi_step.toPage ) {
		observable.multistep.index.current = multi_step.toPage;
	}

	observable.multistep.index.watch(
		() => updateMultiStepStorage( observable ),
	);
}

/**
 * @param observable {Observable}
 * @return {Object}
 */
function getStorageFields( observable ) {
	const storage = getStorage( observable );

	if ( !observable.parent ) {
		return storage.fields ?? {};
	}

	// Get current repeater

	if ( !storage?.value || 'object' !== typeof storage.value ) {
		return {};
	}

	const rowIndex = observable.parent.findIndex( observable );

	// Get fields from current repeater row
	return storage.value[ rowIndex ] ?? storage.value[ rowIndex ]?.fields ?? {};
}

/**
 * @param observable {Observable|RepeaterData}
 * @return {*}
 */
function getStorage( observable ) {
	const { Observable } = JetFormBuilderAbstract;

	if ( !(
		observable instanceof Observable
	) ) {
		observable = observable.value.current[ 0 ];
	}

	const formID      = observable.getSubmit().getFormId();
	const form_config = getFormStorage( formID );

	if ( !observable.parent ) {
		return form_config;
	}

	return form_config.fields[ observable.parent.name ] ?? {};
}

const getFields = () => [
	RepeaterField,
	HierarchicalField,
	SimpleField,
];

/**
 * @type {SimpleField[]}
 */
let fields = [];

/**
 * @param input {InputData}
 * @returns {null|SimpleField}
 */
function getFieldByType( input ) {
	if ( !fields?.length ) {
		fields = getFields();
	}

	for ( const field of fields ) {
		/**
		 * @type {SimpleField}
		 */
		const current = new field();

		if ( !current.isSupported( input ) ) {
			continue;
		}
		current.setInput( input );

		return current;
	}

	return null;
}

function getFormStorage( formID ) {
	const def     = { fields: {}, multi_step: {} };
	const storage = JSON.parse( localStorage.getItem( storageKey( formID ) ) );

	return (
		storage || def
	);
}

/**
 * @param field {SimpleField}
 */
function updateFieldsStorage( field ) {
	const formID = field.input.getSubmit().getFormId();

	if ( !field.input.hasParent() ) {
		unSafeUpdateFieldStorage( formID, field.input.name, field.getValue() );

		return;
	}

	const { parent } = field.input.root;

	const storage  = getStorage( parent );
	const rowIndex = parent.findIndex( field.input.root );

	if ( -1 === rowIndex ) {
		return;
	}

	storage.value[ rowIndex ][ field.input.name ] = {
		value: field.getValue(),
	};

	unSafeUpdateFieldStorage( formID, parent.name, storage.value );
}

function unSafeUpdateFieldStorage( formID, name, value ) {
	const storage = getFormStorage( formID );

	localStorage.setItem(
		storageKey( formID ),
		JSON.stringify( {
			...storage,
			fields: {
				...(
					storage?.fields ?? {}
				),
				[ name ]: { value },
			},
		} ),
	);
}

/**
 * @param observable {Observable}
 */
function updateMultiStepStorage( observable ) {
	const formID  = observable.getSubmit().getFormId();
	const storage = getFormStorage( formID );

	localStorage.setItem(
		storageKey( formID ),
		JSON.stringify( {
			...storage,
			multi_step: {
				toPage: observable.multistep.index.current,
			},
		} ),
	);
}

function removeFormStorage( formID ) {
	localStorage.removeItem( storageKey( formID ) );
}

function storageKey( formId ) {
	return 'jet_form_progress_' + formId;
}

function getUrlParams( { url = '' } = {} ) {
	let sourceUrl  = decodeURIComponent( url ? url : window.location.href );
	const urlParts = sourceUrl.split( '?' );

	if ( !urlParts[ 1 ] || !urlParts[ 1 ].length ) {
		return {};
	}
	const arrParams = urlParts[ 1 ].split( '&' );
	const response  = {};

	arrParams.forEach( param => {
		const [ key, value = '' ] = param.split( '=' );
		response[ key ]    = value;
	} );

	return response;
}

export {
	initFields,
	initClearFormStorage,
	initMultistep,
	updateFieldsStorage,
	getStorage,
};