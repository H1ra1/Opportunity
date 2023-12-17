<template>
	<div>
		<JetFormEditorRow :label="labels.countries">
			<select v-model="response.countries" multiple size="10">
				<option v-for="({ label, value }) in countriesList" :value="value">{{ label }}</option>
			</select>
		</JetFormEditorRow>
		<JetFormEditorRow :label="labels.types">
			<select v-model="response.types" multiple size="5">
				<option v-for="({ label, value }) in types" :value="value">{{ label }}</option>
			</select>
			<template v-slot:helpLabel>
				{{ help.types_link_label }}
				<a :href="help.types_link">{{ help.types_link_name }}</a>
			</template>
		</JetFormEditorRow>
	</div>
</template>

<script>
import { JetFormEditorRow } from "jfb-editor";
import * as field from "@/source-field";

export default {
	name: 'address_autocomplete',
	components: {
		JetFormEditorRow,
	},
	props: [ 'value' ],
	data() {
		return {
			response: { ...field.defaultResponse },
			labels: field.labels,
			countriesList: field.countriesList,
			types: field.types,
			help: field.help
		}
	},
	created() {
		this.response = { ...this.response, ...this.value };
	},
	watch: {
		response( newResponse ) {
			this.$emit( 'input', newResponse );
		}
	},
	methods: {}
};
</script>
