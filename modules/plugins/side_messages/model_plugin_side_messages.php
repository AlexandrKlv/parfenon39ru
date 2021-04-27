<?php

	class model_plugin_side_messages extends model {

		public function getAllNotes() 
		{
			$sql = 'SELECT * FROM `comments` ORDER BY `curDate` DESC LIMIT 5';
			return $this->dbh->query($sql);
		}

		public function action_activate() {
			$this->page['html'] = '';
			return $this->page;
		}
		
		public function action_deactivate() {
			
		}

	}

?>