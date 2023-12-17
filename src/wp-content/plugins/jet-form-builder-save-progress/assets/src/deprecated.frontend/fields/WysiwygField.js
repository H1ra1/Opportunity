import BaseField from './BaseField';

const $ = jQuery;
let hasInit;

class WysiwygField extends BaseField {

	type_field() {
		return 'wysiwyg';
	}

	onGet() {
		let field;
		const self = this;

		this.closure.find( '.wp-editor-area' ).each( function () {
			const textarea = $( this );

			if ( self.fieldName === self.getParsedFieldName( textarea ) ) {
				field = textarea;
			}
		} );

		return field;
	}

	onSet() {
		const self = this;

		$( document ).on(
			'init.JetFormBuilderMain',
			'.jet-form-builder__field.wysiwyg-field',
			function ( event, editor ) {
				const config = jQuery( event.target ).data( 'editor' );

				if ( config?.textarea_name !== self.fieldName ) {
					return;
				}

				editor.on( 'init', function ( e ) {
					editor.setContent( self.value );
				} );
			},
		);
	}

	afterChange( editor ) {
		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: editor.getContent(),
			field: $( this.field.find( 'textarea' ) ),
		} ) );
	}

	getCustomFieldName( field = null ) {
		return this.getParsedFieldName( field );
	}

	events() {
		return [
			{
				type: 'change.JetFormBuilderMain',
				selector: '.jet-form-builder__field.wysiwyg-field',
				callable: this.afterChange,
			},
			{
				type: 'change.JetEngine',
				selector: '.jet-form__field.wysiwyg-field',
				callable: this.afterChange,
			},
		];
	}
}

export default WysiwygField;