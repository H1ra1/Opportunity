import MetaBox from "./MetaBox";

const { addFilter } = wp.hooks;

addFilter( 'jet.engine.register.metaBoxes', 'jet-engine', boxes => {
	boxes.push( MetaBox );

	return boxes;
} );
