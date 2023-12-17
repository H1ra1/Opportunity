<template>
	<div class="jet-form-repeater-ui">
		<div class="jet-form-repeater-ui__items">
			<div
				class="jet-form-repeater-ui__item"
				v-for="( item, index ) in items"
				:key="'details-item-' + index"
			>
				<div class="jet-form-repeater-ui__item--nav">
					<span class="dashicons dashicons-arrow-up-alt2" @click="onMoveItem( index, index - 1 )"></span>
					<span class="dashicons dashicons-arrow-down-alt2" @click="onMoveItem( index, index + 1 )"></span>
				</div>
				<div class="jet-form-repeater-ui__item--controls">
					<slot :current="item" :current-index="index"></slot>
				</div>
				<div class="jet-form-repeater-ui__item--actions">
					<span @click="deleteItem( index )" class="dashicons dashicons-trash"></span>
				</div>
			</div>
		</div>
		<div class="jet-form-repeater-ui__actions">
			<input class="button button-secondary" type="button" @click="addNewItem" :value="buttonAddLabel">
		</div>
	</div>
</template>

<script>

window.jfbEventBus = window.jfbEventBus || new Vue();

export default {
	name: "JfbRepeater",
	props: {
		incomingItems: Array,
		singleItem: Object,
		buttonAddLabel: String,
	},
	data() {
		return {
			items: [],
		};
	},
	created() {
		this.items = JSON.parse( JSON.stringify( this.incomingItems ) );
	},
	watch: {
		items( value ) {
			this.$emit( 'change-items', value );
		}
	},
	methods: {
		deleteItem( index ) {
			this.items.splice( index, 1 );
		},
		changeCurrent( valueToSet, index ) {
			const prevClone = JSON.parse( JSON.stringify( this.items ) );

			prevClone[ index ] = {
				...prevClone[ index ],
				...valueToSet,
			};

			this.items = prevClone;
		},
		onMoveItem( oldIndex, newIndex ) {
			const prevClone = JSON.parse( JSON.stringify( this.items ) );

			[ prevClone[ newIndex ], prevClone[ oldIndex ] ] = [ prevClone[ oldIndex ], prevClone[ newIndex ] ];

			this.items = prevClone;
		},
		addNewItem() {
			this.items.push( JSON.parse( JSON.stringify( this.singleItem ) ) )
		},
	},
}
</script>

<style scoped lang="scss">
.jet-form-repeater-ui {
	&__item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		-webkit-box-shadow: 0 2px 4px rgba(22, 43, 64, .1);
		box-shadow: 0 2px 4px rgba(22, 43, 64, .1);
		margin-bottom: 1.5em;
		padding: 1em 0;
		span {
			display: block;
			width: 33px;
			text-align: center;
			cursor: pointer;
			opacity: 0.4;
			&:hover {
				opacity: 1;
			}
		}

		&--nav {
			padding-left: 1em;
			flex: 1;
		}
		&--actions {
			flex: 1;
			display: flex;
			justify-content: flex-end;
			padding-right: 1em;
		}
		&--controls {
			flex: 7;
		}
	}
}
</style>