import BaseField from './BaseField';

const $ = jQuery;

class RepeaterField extends BaseField {

	type_field() {
		return 'repeater';
	}

	onGet() {
		return this.baseFindField( 'div' );
	}

	onSet() {
		if ( 'object' !== typeof this.value ) {
			return;
		}
		const repItems = Object.entries( this.value );

		for ( const [ index, rowValues ] of repItems ) {
			const { fields = {}, status = 'active' } = rowValues;
			let rowElement = this.field.find( `[data-index="${ index }"]` );

			if ( rowElement.length && 'active' !== status ) {
				const $editors = rowElement.find( '.wp-editor-area' );

				$editors.each( function() {
					const self = $( this );

					if ( window.wp && window.wp.editor ) {
						wp.editor.remove( self.attr( 'id' ) );
					}
				} )
				rowElement.remove();
			}

			if ( 'active' !== status  ) {
				continue;
			}

			if ( ! rowElement.length ) {
				const className = this.className( '-repeater__new' );
				const button = this.field.find( className );
				button.click();

				rowElement = this.field.find( this.className( '-repeater__row:last' ) );
			}

			this.$root.initProgress( rowElement, fields );
		}
	}

	afterNew() {
		const
			$repeater = this.field.closest( this.className( '-repeater' ) ),
			$items    = $repeater.find( this.className( '-repeater__items' ) ),
			$children = $items.children( this.className( '-repeater__row' ) );

		const items     = Array( ...$children ),
		      lastAdded = items.pop();

		this.insertRepeaterRow( $repeater, lastAdded );
	}

	afterRemove() {
		const $repeaterItem = this.field.closest( this.className( '-repeater__row' ) ),
		      index         = $repeaterItem.data( 'index' ),
		      $repeater     = this.field.closest( this.className( '-repeater' ) );

		const items = this.getVal( {
			closure: this.form_id,
			ifEmpty: {},
			field: $repeater,
		} );

		items[ index ] = {
			status: 'removed',
		};

		JetSPManager.setFormStorage( this.form_id, this.val( {
			value: items,
			checkInRepeater: false,
			field: $repeater,
		} ) );
	}

	events() {
		return [
			{
				type: 'jet-form-builder/repeater-add-new',
				selector: '.jet-form-builder-repeater__new',
				callable: this.afterNew,
			},
			{
				type: 'jet-form-builder/on-remove-repeater-item',
				callable: this.afterRemove,
			},
			{
				type: 'jet-engine/form/repeater-add-new',
				selector: '.jet-form-repeater__new',
				callable: this.afterNew,
			},
			{
				type: 'jet-engine/form/on-remove-repeater-item',
				callable: this.afterRemove,
			},
		];
	}
}

export default RepeaterField;