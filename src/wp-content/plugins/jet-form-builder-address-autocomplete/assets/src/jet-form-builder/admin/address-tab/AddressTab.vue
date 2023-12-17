<template>
	<div>
		<cx-vui-input
			:label="label.api_key"
			:wrapper-css="[ 'equalwidth' ]"
			:description='`${ help.apiPref } <a href="${ help.apiLink }" target="_blank">${ help.apiLinkLabel }</a>`'
			:size="'fullwidth'"
			v-model="current.api_key"
		/>
		<cx-vui-switcher
			:label="label.disable_js"
			:description="help.disable_js"
			:wrapper-css="[ 'equalwidth' ]"
			v-model="current.disable_js"
		/>
	</div>
</template>
<script>
import {
	help,
	label,
} from "@/source-meta";

export default {
	name: 'jfb-address-tab',
	props: {
		incoming: {
			type: Object,
			default() {
				return {};
			},
		},
	},
	data() {
		return {
			label, help,
			current: {},
		};
	},
	created() {
		this.current = JSON.parse( JSON.stringify( this.incoming ) );
	},
	methods: {
		getRequestOnSave() {
			return {
				data: this.current,
			};
		},
	},
}

</script>