<?php

	class model_plugin_search extends model {

		public function action_activate() {
			$this->page['html'] = '';
			return $this->page;
		}
		
		public function action_deactivate() {
			
		}

	}

?>