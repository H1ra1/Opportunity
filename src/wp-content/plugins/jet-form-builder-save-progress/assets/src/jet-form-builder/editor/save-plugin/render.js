import {
	labels,
	options,
} from "@/source-meta";

const {
		  ToggleControl,
	  } = wp.components;

const { useMetaState } = JetFBHooks;

export default function PluginSaveProgress() {

	const [ saveOptions, setSaveOptions ] = useMetaState( options.id );

	return <>
		<ToggleControl
			label={ labels.enable }
			checked={ saveOptions.enable }
			onChange={ enable => {
				setSaveOptions( prev => ( { ...prev, enable } ) );
			} }
		/>
		<ToggleControl
			label={ labels.clear_storage }
			checked={ saveOptions.clear_storage }
			onChange={ clear_storage => {
				setSaveOptions( prev => ( { ...prev, clear_storage } ) );
			} }
		/>
	</>;
}