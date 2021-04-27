<?php
	class controller_block_us extends block{
		
		function array_by_id($array){
			if (empty($array)) return $array;
			$tmp = array();
			foreach ($array as $k=>$v) $tmp[$v['id']] = $v;
			return ($tmp);	
		}		
		
		public function action_index(){
			$this->data['us'] = $this->get_global_data('user') ? $this->get_global_data('user') : FALSE;
			//echo '<pre>';
			//print_r($this->data['us']);
			//echo '</pre>';
			$page['head'] = $this->add_css_file(SITE_URL . '/modules/blocks/' . $this->block_name . '/views/style.css');
			$page['html'] = $this->load_view('index');
			return $page;
		}
	}
?>