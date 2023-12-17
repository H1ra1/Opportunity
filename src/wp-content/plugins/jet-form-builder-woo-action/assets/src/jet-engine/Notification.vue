<template>
	<div class="jet-fb-woo-notification">
		<JetFormEditorRow :label="label( 'product_id_from' )">
			<div
				v-for="({ value, label }) in allSource.product_id_from"
				:key="value"
			>
				<input
					v-model="instance.product_id_from"
					type="radio"
					:value="value"
					:id="`wc_product_id_from_${value}`"
				/>
				<label
					:for="`wc_product_id_from_${value}`"
				>
					{{ label }}
				</label>
			</div>
		</JetFormEditorRow>
		<JetFormEditorRow v-if="'manual' === instance.product_id_from" :label="label( 'product_manual' )">
			<input
				type="number"
				:value="getProductManual( 0, 'id' )"
				@change="setField( [ { id: $event.target.value } ], 'product_manual' )"
			>
		</JetFormEditorRow>
		<JetFormEditorRow v-if="'field' === instance.product_id_from" :label="label( 'product_id_field' )">
			<select v-model="instance.product_id_field">
				<option value="">--</option>
				<option v-for="field in fields" :value="field">{{ field }}</option>
			</select>
		</JetFormEditorRow>
		<JetFormEditorRow :label="label( 'wc_price' )">
			<template #helpLabel>
				{{ help( 'wc_price' ) }}
			</template>
			<select v-model="instance.wc_price">
				<option value="">--</option>
				<option v-for="field in fields" :value="field">{{ field }}</option>
			</select>
		</JetFormEditorRow>
		<JetFormEditorRow :label="label( 'wc_heading_order_details' )">
			<input type="text" v-model="instance.wc_heading_order_details"/>
		</JetFormEditorRow>
		<JetFormEditorRow :label="label( 'wc_order_details' )">
			<template #helpControl>
				{{ help( 'wc_order_details' ) }}
			</template>
			<button type="button" class="button button-secondary" @click="toggleModal">{{ 'Set up' }}</button>
		</JetFormEditorRow>
		<div class="jet-form-editor__row">
			<div class="jet-form-editor__row-label">{{ label( 'wc_fields_map' ) }}</div>
			<div class="jet-form-editor__row-control">
				<div class="jet-form-editor__row-notice">{{ help( 'wc_fields_map' ) }}</div>
				<div class="jet-form-editor__row-fields">
					<div class="jet-form-editor__row-map"
						 v-for="( fieldData, fieldId ) in allSource.wc_fields">
                <span>{{ fieldData.label }} <span class="jet-form-editor-required"
												  v-if="fieldData.required">*</span></span>
						<select @input="setField( $event.target.value, `wc_fields_map__${ fieldId }` )"
								:value="instance[ `wc_fields_map__${ fieldId }` ]">-->
							<option value="">--</option>
							<option v-for="field in fields" :value="field">{{ field }}</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<FormEditorModal
			header="Set up WooCommerce order details"
			v-if="isVisibleModal"
			@on-cancel-modal="toggleModal"
			:done-button="isSaving ? 'Saving...' : 'Save'"
		>
			<JfbRepeater
				:incoming-items="details"
				:single-item="{
					type: 'field',
					label: '',
					field: '',
				}"
				@change-items="onChangeItems"
				button-add-label="+ Add new item"
			>
				<template #default="{ currentIndex }">
					<div>
						<label :for="'label_' + currentIndex">Label</label>
						<input
							type="text"
							v-model="details[ currentIndex ].label"
							:id="'label_' + currentIndex"
							class="item-control"
						>
					</div>
					<div>
						<label :for="'field_' + currentIndex">Field</label>
						<select v-model="details[ currentIndex ].field" class="item-control">
							<option value="">--</option>
							<option v-for="field in fields" :value="field">{{ field }}</option>
						</select>
					</div>
				</template>
			</JfbRepeater>
		</FormEditorModal>
	</div>
</template>

<style scoped lang="scss">
.jet-form-repeater-ui__item--controls > div {
	display: flex;
	justify-content: space-between;
	&:not(:last-child) {
		margin-bottom: 1em;
	}
	& > label {
		flex: 1;
	}
	& > .item-control {
		flex: 3 0 10%;
	}
}
</style>

<script>
import {
	Actions,
	JetFormEditorRow,
} from "jfb-editor"
import FormEditorModal from './FormEditorModal';
import JfbRepeater from './JfbRepeater';

window.jfbEventBus = window.jfbEventBus || new Vue();

Vue.config.devtools = true;

const { label, help, ...source } = new Actions.EditorData( 'redirect_to_woo_checkout' ).importAction();

export default {
	name: 'redirect_to_woo_checkout',
	components: {
		JetFormEditorRow,
		FormEditorModal,
		JfbRepeater,
	},
	props: {
		value: Object,
		fields: Array,
		jsonSource: Array,
	},
	data: function() {
		return {
			instance: {},
			details: [],
			allSource: source,
			isVisibleModal: false,
			isSaving: false,
		};
	},
	created: function() {
		this.instance = this.value || {};
		const { details } = Actions.getAction( 'redirect_to_woo_checkout' );

		this.details = details;

		window.jfbEventBus.$on( 'on-done-modal', this.saveDetails.bind( this ) );
	},
	watch: {
		instance( newResponse ) {
			this.$emit( 'input', newResponse );
		},
	},

	methods: {
		toggleModal() {
			this.isVisibleModal = ! this.isVisibleModal;
		},
		label: attr => label( attr ),
		help: attr => help( attr ),
		onChangeItems( items ) {
			this.details = items;
		},
		saveDetails() {
			const self = this;
			self.isSaving = true;

			jQuery.ajax( {
				url: window.ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: {
					post_id: self.allSource.post_id,
					action: self.allSource.action,
					nonce: self.allSource.nonce,
					details: self.details,
				},
			} ).done( function( response ) {
				self.isSaving = false;

				if ( ! response.success ) {
					alert( response.data.message );
				} else {
					Actions.setAction(
						'redirect_to_woo_checkout',
						{ details: self.details },
					);
					self.isVisibleModal = false;
				}

			} ).fail( function( jqXHR, textStatus, errorThrown ) {
				self.isSaving = false;
				alert( errorThrown );
			} );
		},
		setField: function( value, key ) {
			this.$set( this.instance, key, value );
			this.$emit( 'input', this.instance );
		},
		changeFieldMap: function( value, key ) {
			if ( ! this.instance.fields_map ) {
				this.$set( this.instance, 'wc_fields_map', {} );
			}
			this.$set( this.instance.wc_fields_map, key, value );
		},
		getFieldMap: function( key ) {
			return this.instance.wc_fields_map && this.instance.wc_fields_map[ key ] ? this.instance.wc_fields_map[ key ] : '';
		},
		getProductManual( index, key = '', ifEmpty = 0 ) {
			if ( 'object' !== typeof this.instance.product_manual || 0 >= this.instance.product_manual.length ) {
				return ifEmpty;
			}
			if ( ! key ) {
				return this.instance.product_manual[ index ] ? this.instance.product_manual[ index ] : ifEmpty;
			}

			return 'object' === typeof this.instance.product_manual[ index ]
				? this.instance.product_manual[ index ][ key ]
				: ifEmpty;
		}
	},

}
</script>