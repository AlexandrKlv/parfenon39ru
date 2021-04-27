<?php

	class controller_plugin_search extends plugin {

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
			$this->page['title'] = 'Форма поиска на всех страницах сайта ' . SITE_NAME;
			$this->page['keywords'] = 'Форма поиска на всех страницах сайта';
			$this->page['description'] = 'Форма поиска на всех страницах сайта';

			// $this->data['siteSearch'] = 'Поиск по сайту.';

			$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/plugins/search/views/search.css');
			$this->page['html'] = $this->load_view();
			return $this->page;
		}
	}
	
?>