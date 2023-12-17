<template>
	<div :class="{ 'jet-form-editor-modal':true }">
		<div :class="{ 'jet-form-editor-modal__overlay':true }" @click="onClickCancel"></div>
		<div class="jet-form-editor-modal__body">
			<div class="jet-form-editor-modal__header"><h4>{{ header }}</h4></div>
			<div class="jet-form-editor-modal__content">
				<slot></slot>
			</div>
			<div class="jet-form-editor-modal__actions">
				<button
					type="button"
					class="button button-primary button-large"
					@click="onClickDone"
				>
					{{ doneButton }}
				</button>
				<button
					type="button"
					class="button button-secondary button-large"
					@click="onClickCancel"
				>
					{{ 'Cancel' }}
				</button>
			</div>
		</div>
	</div>
</template>

<script>

window.jfbEventBus = window.jfbEventBus || new Vue();

export default {
	name: "FormEditorModal",
	props: {
		header: String,
		doneButton: String,
	},
	methods: {
		onClickDone() {
			window.jfbEventBus.$emit( 'on-done-modal' );
		},
		onClickCancel() {
			this.$emit( 'on-cancel-modal' );
		},
	},
}
</script>

<style scoped lang="scss">
.jet-form-editor-modal {
	position: fixed;
	z-index: 999;
	left: 0;
	right: 0;
	bottom: 0;
	top: 0;
	align-items: center;
	justify-content: center;
	display: flex;
	&__body {
		box-sizing: border-box;
		width: 600px;
		max-width: 90vw;
		background: #fff;
		position: relative;
		z-index: 2;
	}
	&__header {
		padding: 0.5em 1em;
		border-bottom: 1px solid #e2e4e7;
		background: #f3f4f5;
	}
	&__overlay {
		background: rgba(0, 0, 0, .7);
		position: absolute;
		z-index: 1;
		left: 0;
		right: 0;
		bottom: 0;
		top: 0;
	}
	&__content {
		padding: 1em 30px 1em;
		overflow-y: auto;
		max-height: 600px;
	}
	&__actions {
		padding: 15px 30px;
		border-top: 1px solid #e2e4e7;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		& button:first-child {
			margin-right: 1em;
		}
	}
}
</style>