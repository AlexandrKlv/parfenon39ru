<?php

	class controller_plugin_side_messages extends plugin {

		function __construct($config, $url, $plugin_name, $dbh) 
		{
			parent::__construct($config, $url, $plugin_name, $dbh);
	  		$this -> view_dir         = ROOT_DIR .          '/modules/plugins/'.$plugin_name.'/views';
	  		$this -> view_dir_core    = ROOT_DIR . '/user_cms/modules/plugins/'.$plugin_name.'/views';
	  		$this -> view_dir_simple  = '/modules/plugins/'.$plugin_name.'/views';
	  		$this -> page['html']             = '';
			$this -> page['head']             = '';
			$this -> plugin_dir            = ROOT_DIR . '/modules/plugins/'.$plugin_name.'/'.END_NAME;
			$this -> plugin_dir_core       = ROOT_DIR . '/user_cms/modules/plugins/'.$plugin_name.'/'.END_NAME;
			$this -> plugin_name           = $plugin_name;
			$this -> model                 = $this->load_model();
	  	}

		public function action_index() 
		{
			$this->page['title'] = 'Форма отображение последних сообщений из гостевой книги ' . SITE_NAME;
			$this->page['keywords'] = 'Форма отображение последних сообщений из гостевой книги';
			$this->page['description'] = 'Форма отображение последних сообщений из гостевой книги';
			
			// echo '<pre>';
			// print_r($this->model->getAllNotes());
			// echo '</pre>';

			$allNotesArr = $this->model->getAllNotes();
			$this->data['allNotesArr'] = $allNotesArr;

			$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/plugins/side_messages/views/side_messages.css');
			$this->page['html'] = $this->load_view();
			return $this->page;
		}
	}
	
?>