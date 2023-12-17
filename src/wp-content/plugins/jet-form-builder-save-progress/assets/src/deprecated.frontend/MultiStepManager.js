import NamespaceBase from './NamespaceBase';

const $ = jQuery;

class MultiStepManager extends NamespaceBase {
	constructor( root, pageId ) {
		super();

		this.root = root;
		this.pageId = pageId;
	}

	init() {
		if ( 1 >= this.pageId ) {
			return;
		}

		let currentPage = this.root.find( this.className( `-page[data-page="1"]` ) );

		if ( ! currentPage.length ) {
			return;
		}

		for ( let i = 1; i < this.pageId; i++ ) {
			const button = currentPage.find( this.className( '__next-page' ) );

			if ( button.attr( 'disabled' ) ) {
				break;
			}
			button.click();

			currentPage = currentPage.next();
		}
	}

	switchPage( event, $fromPage, $toPage ) {
		const [ fromPage, toPage ] = [ $fromPage.data( 'page' ), $toPage.data( 'page' ) ];

		JetSPManager.setFormStorage( this.root, { toPage }, 'multi_step' );
	}

	addEvents() {
		$( document )
			.on( 'jet-engine/form/switch-page', this.switchPage.bind( this ) )
			.on( 'jet-form-builder/switch-page', this.switchPage.bind( this ) )

		return this;
	}
}

export default MultiStepManager;