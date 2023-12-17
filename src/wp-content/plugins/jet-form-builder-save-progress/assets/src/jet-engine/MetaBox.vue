<template>
	<div>
		<JetFormEditorRow :label="label( 'enable' ) + ':'">
			<input type="checkbox" :name="fieldName( 'enable' )" v-model="meta.enable"/>
		</JetFormEditorRow>
		<JetFormEditorRow :label="label( 'clear_storage' ) + ':'">
			<input type="checkbox" :name="fieldName( 'clear_storage' )" v-model="meta.clear_storage"/>
		</JetFormEditorRow>
	</div>
</template>

<script>

import { JetFormEditorRow } from 'jfb-editor';
import {
	labels,
	options,
} from '../source-meta';

export default {
	name: options.slug,
	components: {
		JetFormEditorRow,
	},
	data() {
		return {
			options,
			meta: {
				enable: false,
				clear_storage: false,
			},
		}
	},
	created() {
		this.meta = { ...this.meta, ...window.JetSaveProgressSettings.meta };
	},
	methods: {
		label: attr => labels[ attr ],
		help: attr => help[ attr ],

		withPrefix( suffix = '' ) {
			return `${ options.id }${ suffix }`;
		},
		fieldName( name ) {
			return this.withPrefix( `[${ name }]` );
		},
		uniqId( name ) {
			return this.withPrefix( `__${ name }` );
		},
	},
}
</script>