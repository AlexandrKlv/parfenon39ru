<?php 

/**
* main component
*/
class component extends module {

	public $view;
	public $view_dir;
	public $component_dir;
	public $component_dir_core;
	public $page;
	public $model;
	public $component_name;
	public $component_config;
	public $component_info;
	public $data = array();
	
	function __construct($config, $url, $component, $dbh) {
		parent::__construct($config, $url, $component, $dbh);
		
		$this->view   = $component['view'];
  		$this->view_dir         = ROOT_DIR .          '/modules/components/'.$component['name'].'/'.END_NAME.'/views';
  		$this->view_dir_core    = ROOT_DIR . '/user_cms/modules/components/'.$component['name'].'/'.END_NAME.'/views';
  		$this->page['title']            = '';
  		$this->page['keywords']         = '';
  		$this->page['description']      = '';
  		$this->page['html']             = '';
		$this->page['head']             = '';
		$this->component_dir            = ROOT_DIR . '/modules/components/'.$component['name'].'/'.END_NAME;
		$this->component_dir_core       = ROOT_DIR . '/user_cms/modules/components/'.$component['name'].'/'.END_NAME;
		$this->component_name           = $component['name'];
		$this->model                    = $this->load_model();
		$this->component_config         = $this->get_component_config($component['name']);
		$this->component_info           = isset($component['info']) ? $component['info'] : $this->get_component_info($component['name']);
	}

	public function action_index() {
		$this->data['page_name'] = 'Название страницы не задано';
		$this->data['content'] = '<p style="margin: 20px 0;">Контент страницы не задан</p>';
		$this->data['bread_crumbs'] = '';
		$this->page['title'] = 'Тайтл страницы не задан';
		$this->page['keywords'] = 'Ключевики страницы не заданы';
		$this->page['description'] = 'Описание страницы не задано';
		$this->page['html'] = $this->load_view();
		$this->page['head'] = '';
		return $this->page;
	}

	public function action_else() {
		return $this->action_404();
	}

	public function action_404($view_name = 'index') {
		$sapi_name = php_sapi_name();
		if ($sapi_name == 'cgi' || $sapi_name == 'cgi-fcgi') {
		    header('Status: 404 Not Found');
		} else {
		    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		}
		$this->data['page_name'] = 'Страница не найдена';
		$this->data['content'] = '<p style="margin: 20px 0;">Ошибка 404 бывает в следующих случаях:	<ol><li>Страницу удалили</li><li>Страницу переместили</li><li>Страница еще не создана</li></ol>Воспользуйтесь меню сайта для поиска нужной информации!</p>';
		$this->data['bread_crumbs'] = '<a href="' . SITE_URL . '">Главная</a>->Ошибка 404';
		$page['title'] = 'Страница не найдена. Ошибка 404';
		$page['keywords'] = '';
		$page['description'] = '';
		$page['html'] = $this->load_view($view_name);
		return $page;
	}
	
	public function load_view($name = 'index') {
		$full_name = $this->view_dir . '/' . $name . '.tpl';
		$full_name_core = $this->view_dir_core . '/' . $name . '.tpl';
		
		if (file_exists($full_name)) {
	        $view = $full_name;
	    } elseif (file_exists($full_name_core)) {
	        $view = $full_name_core;
	    } elseif (file_exists($this->view_dir . '/' . $this->view . '.tpl')) {
	        $view = $this->view_dir . '/' . $this->view . '.tpl';
	    } elseif (file_exists($this->view_dir_core . '/' . $this->view . '.tpl')) {
	        $view = $this->view_dir_core . '/' . $this->view . '.tpl';
	    } else {
	    	exit('Error3: file not found: ' . $full_name);
	    }
		
		extract($this->data);
		
		ob_start();
		include $view;
		return ob_get_clean();
	}

	public function load_model($type = '', $name = '') {
		if(!$name || !$type) { // подгружаем родной компонент
			$model_full_name = 'model_component_' . $this->component_name;
			return new $model_full_name($this->dbh);
		} else {
			$model_full_name = 'model_' . $type . '_' . $name;
			$this->$model_full_name = new $model_full_name($this->dbh);
		}
	}
	
	protected function mb_strtr($str, $from, $to = '') {
		if(is_array($from)) {
			$new_from = array_keys($from);
			return str_replace($new_from, $from, $str);
			
		} else {
			$from = preg_split('~~u', $from, null, PREG_SPLIT_NO_EMPTY);
			$to = preg_split('~~u', $to, null, PREG_SPLIT_NO_EMPTY);
			return str_replace($from, $to, $str);
		}
	}
}