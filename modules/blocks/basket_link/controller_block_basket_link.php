<?php
	class controller_block_basket_link extends block{
		public function action_index(){
			$db = new PDO("sqlite:db.sqlite");
			$sql = "SELECT url FROM main WHERE component='catalog' LIMIT 1"; 
			$st = $db->query($sql); 
			$ar = $st->fetchAll();
			$this->data['compUrl'] = (!empty($ar)) ? $ar[0]['url'] : '';
			
			$page['head'] = $this->add_css_file(SITE_URL . '/modules/blocks/' . $this->block_name . '/views/style.css');
			$page['html'] = $this->load_view('index');
			return $page;
		}
	}
?>