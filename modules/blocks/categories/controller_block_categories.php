<?php
	class controller_block_categories extends block{
		//var $dbr = new PDO("sqlite:db.sqlite");
		public function kit($sub,$i,$num){
			//$db=$this->dbr;
			if ($i>$num) return(array());
			$db=new PDO("sqlite:db.sqlite");			
			$sql = "SELECT id,name,url FROM cats WHERE sub=".$sub." ORDER BY sort DESC";
			$st=$db->query($sql);
			$ar=$st->fetchAll();
			foreach ($ar as $k=>$v){
				$ar[$k]['sub']=$this->kit($ar[$k]['id'], $i+1, $num);
			}
			return($ar);
		
		}
		public function action_index(){
			$db=new PDO("sqlite:db.sqlite");			
			$sql = "SELECT url FROM main WHERE component='catalog' LIMIT 1"; 
			$st = $db->query($sql); 
			$ar = $st->fetchAll();
			$this->data['compUrl'] = (!empty($ar)) ? $ar[0]['url'] : '';
			
			$sql="SELECT params FROM settings WHERE 1 LIMIT 1";
			$st=$db->query($sql);
			$ar=$st->fetch();
			$str=$ar['params'];
			$settings=unserialize($str);
			$num = $settings['categories'];
			
			$result=$this->kit(0,1,$num);
			
			$this->data['cats'] = $result;
			//$this->data['num'] = $num;
			//echo '<pre>';
			//print_r($result);
			//echo '</pre>';

			$page['head'] = $this->add_css_file(SITE_URL . '/modules/blocks/' . $this->block_name . '/views/style.css');
			$page['html'] = $this->load_view('index');
			return $page;
		}
	}
?>