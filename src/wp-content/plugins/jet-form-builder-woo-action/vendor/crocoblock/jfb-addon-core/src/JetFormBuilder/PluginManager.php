<?php


namespace JetWooCore\JetFormBuilder;


use JetWooCore\RegisterMetaManager;

abstract class PluginManager {

	use EditorAssetsManager;
	use RegisterMetaManager;
	use WithInit;

	public function on_plugin_init() {
		$this->meta_manager_init();
		$this->assets_init();
	}

}