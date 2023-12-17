import BaseField from './BaseField';

const $ = jQuery;

class MediaField extends BaseField {

	type_field() {
		return 'media';
	}

	parseNamespaceBeforeSave( namespace ) {
		return 'jet-form' === namespace ? 'jet-engine' : namespace;
	}

	onGet() {
		return this.baseFindField( 'input' ).closest(
			this.className( '-file-upload' ),
		);
	}

	onSet() {
		const activeMedia = this.getActiveMediaItems();

		this.clearRemovedMedia();
		if ( ! activeMedia.length ) {
			return;
		}
		this.insertMediaPlaceholders( activeMedia );

		const $valueField = this.field.find(
			this.className( '-file-upload__value' ),
		);
		const $fieldsField = this.field.find(
			this.className( '-file-upload__files' ),
		);
		const { value_format = 'url', max_files = '1' } = JSON.parse( $fieldsField.attr( 'data-args' ) );
		let $value = $valueField.val();

		if ( $value ) {
			$value = JSON.parse( $value );
		}

		if ( parseInt( max_files ) === 1 ) {
			switch ( value_format ) {
				case 'url':
					$value = activeMedia[ 0 ].url;
					break;
				case 'id':
					$value = activeMedia[ 0 ].id;
					break;
				case 'both':
					$value = activeMedia[ 0 ];
			}
		} else {
			switch ( value_format ) {
				case 'url':
					$value = [ ...$value, ...activeMedia.map( ( { url } ) => url ) ];
					break;
				case 'id':
					$value = [ ...$value, ...activeMedia.map( ( { id } ) => id ) ];
					break;
				case 'both':
					$value = [ ...$value, ...activeMedia ];
			}
		}

		$valueField.val( JSON.stringify( $value ) );

	}

	afterRemove( fileURL, fileID ) {
		const oldValue = this.getVal( { closure: this.form_id } );

		const ifThis = currentMedia => {
			return currentMedia.url === fileURL || parseInt( currentMedia.id ) === parseInt( fileID );
		};

		const findIndex = oldValue.findIndex( ifThis );

		if ( - 1 === findIndex ) {
			oldValue.push( { url: fileURL, id: fileID, status: 'removed' } );
		} else {
			oldValue.splice( findIndex, 1 );
		}

		if ( ! oldValue.length ) {
			this.clear();

			return;
		}

		JetSPManager.setFormStorage(
			this.form_id,
			this.val( { value: oldValue } ),
		);
	}

	afterUpload( request, oldInputVal ) {
		const oldValue = this.getVal();

		const wrapper = this.field.closest( this.className( '-file-upload' ) ).find( this.className( '-file-upload__files' ) );

		const { value_format = 'url', max_files = '1' } = JSON.parse( wrapper.attr( 'data-args' ) );

		const saveImageVal = ( imageVal, status = 'active' ) => {
			let item = {};

			if ( [ 'url', 'id' ].includes( value_format ) ) {
				item[ value_format ] = imageVal;
			}

			let image;
			switch ( value_format ) {
				case 'id':
					image = wrapper.find( `[data-id="${ imageVal }"]` );
					item.url = image.attr( 'data-file' );
					break;
				case 'url':
					image = wrapper.find( `[data-file="${ imageVal }"]` );
					item.id = image.attr( 'data-id' );
					break;
				case 'both':
					item = { ...imageVal };
					break;
			}
			item.status = status;

			return item;
		};

		if ( 'object' === typeof request && request?.length ) {
			request.forEach( imageVal => {
				oldValue.push( saveImageVal( imageVal ) );
			} );
		} else if ( undefined !== request ) {
			oldValue.push( saveImageVal( request ) );
		}

		if ( 1 === + max_files && Object.keys( oldInputVal ).length ) {
			const oldImage = saveImageVal( oldInputVal, 'removed' );
			const removedImage = oldValue.findIndex( image => {
				const isBoth = (
					oldImage.id
					&& oldImage.url
					&& (
					image.url === oldImage.url && image.id === oldImage.id
					)
				);
				const isId = (
					oldImage.id && image.id === oldImage.id
				);
				const isUrl = (
					oldImage.url && image.url === oldImage.url
				);

				return (
					isBoth || isId || isUrl
				);
			} );

			if ( - 1 !== removedImage ) {
				oldValue[ removedImage ].status = 'removed';
			} else {
				oldValue.push( oldImage );
			}
		}

		JetSPManager.setFormStorage( this.form_id, this.val( { value: oldValue } ) );
	}

	events() {
		return [
			{
				type: 'jet-form-builder/on-upload-media',
				selector: '.jet-form-builder-file-upload__value',
				callable: this.afterUpload,
			},
			{
				type: 'jet-form-builder/on-remove-media-item',
				selector: '.jet-form-builder-file-upload__value',
				callable: this.afterRemove,
			},
			{
				type: 'jet-engine/form/on-upload-media',
				selector: '.jet-engine-file-upload__value',
				callable: this.afterUpload,
			},
			{
				type: 'jet-engine/form/on-remove-media-item',
				selector: '.jet-engine-file-upload__value',
				callable: this.afterRemove,
			},
		];
	}

	insertMediaPlaceholders( storageValue = this.value ) {
		const placeholdersWrapper = this.field.find( this.className( '-file-upload__files' ) );
		const args = placeholdersWrapper.attr( 'data-args' );
		if ( ! args ) {
			return;
		}
		const { value_format = 'id' } = JSON.parse( args );

		for ( const { url, id, status = 'active' } of storageValue ) {
			if ( 'active' !== status ) {
				continue;
			}
			const allowedForPreview = [ 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'svg' ];
			const previewExtPreg = new RegExp(
				'\\.(' + allowedForPreview.join( '|' ) + ')$',
			);
			placeholdersWrapper.append(
				this.createMediaContent(
					previewExtPreg.test( url ) ? url : '',
					value_format,
					id,
				),
			);
		}
	};

	createMediaContent( url, format, index ) {
		const image = url ? `<img src="${ url }" alt="">` : '';

		return $(
			`<div class="${ this.namespace( '-file-upload__file' ) }"
			 data-file="${ url }"
			 data-id="${ index }" data-format="${ format }" draggable="true">
			 	${ image }
				<div class="${ this.namespace( '-file-upload__file-remove' ) }">
					<svg width="22" height="22" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M4.375 7H6.125V12.25H4.375V7ZM7.875 7H9.625V12.25H7.875V7ZM10.5 1.75C10.5 1.51302 10.4134 1.30794 10.2402 1.13477C10.0762 0.961589 9.87109 0.875 9.625 0.875H4.375C4.12891 0.875 3.91927 0.961589 3.74609 1.13477C3.58203 1.30794 3.5 1.51302 3.5 1.75V3.5H0V5.25H0.875V14C0.875 14.237 0.957031 14.4421 1.12109 14.6152C1.29427 14.7884 1.50391 14.875 1.75 14.875H12.25C12.4961 14.875 12.7012 14.7884 12.8652 14.6152C13.0384 14.4421 13.125 14.237 13.125 14V5.25H14V3.5H10.5V1.75ZM5.25 2.625H8.75V3.5H5.25V2.625ZM11.375 5.25V13.125H2.625V5.25H11.375Z"></path>
					</svg>
				</div>
			</div>`,
		);
	};

	getActiveMediaItems() {
		const activeMediaItems = [];

		for ( const mediaItem of this.value ) {
			const { status = 'active' } = mediaItem;

			if ( 'active' !== status ) {
				continue;
			}
			delete mediaItem.status;

			activeMediaItems.push( mediaItem );
		}

		return activeMediaItems;
	}

	clearRemovedMedia() {
		for ( const { url = '', id = '', status = 'active' } of this.value ) {
			if ( 'removed' !== status ) {
				continue;
			}
			const field = url
				? this.field.find( this.className( `-file-upload__file[data-file="${ url }"]` ) )
				: this.field.find( this.className( `-file-upload__file[data-id="${ id }"]` ) );

			if ( field.length ) {
				field.remove();
			}
		}
	}

}

export default MediaField;