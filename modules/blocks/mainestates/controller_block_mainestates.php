<?php
	class controller_block_mainestates extends block{
		
		function array_by_id($array){
			if (empty($array)) return $array;
			$tmp = array();
			foreach ($array as $k=>$v) $tmp[$v['id']] = $v;
			return ($tmp);	
		}		
		
		public function action_index(){

			/*NEWS*/
			
			$this->data['newz'] = $this->dbh->query("SELECT * FROM news_items WHERE 1 ORDER BY date_edit DESC, date_add DESC LIMIT 30");
			
			/*END NEWS*/
			$this->data['cities'] = $this->array_by_id($this->dbh->query("SELECT * FROM es_cities WHERE 1"));
			$this->data['districts'] = $this->array_by_id($this->dbh->query("SELECT * FROM es_districts WHERE 1")); 
			$this->data['types'] = $this->array_by_id($this->dbh->query("SELECT * FROM es_types WHERE 1"));

			$this->data['numRooms'] = $this->array_by_id($this->dbh->query("SELECT * FROM es_num_rooms WHERE 1"));
		
		//добавляем каждому ticket названия его района, типа, комнат
		
			$arr1 = $this->array_by_id($this->dbh->query("SELECT * FROM estate WHERE status>0 ORDER BY date_add  DESC LIMIT 30"));
			$arr2 = $this->array_by_id($this->dbh->query("SELECT * FROM estate WHERE status>0 AND imp>0 ORDER BY imp ASC, date_add DESC LIMIT 30"));
			//echo '<pre>';
			//print_r($arr2);
			//echo '</pre>';
			$arr3 = $this->array_by_id($this->dbh->query("SELECT * FROM estate WHERE status>0 ORDER BY price ASC, square DESC LIMIT 30"));
//print_r($arr2);
			$res1 = array();
			$res2 = array();
			$i1=1;
			$i2=1;
			
			if (!empty($arr2)) foreach($arr2 as $k=>$v){
				if ($i2>15) break;
				$res2[$k] = $v;
				$i2++;
			}
			
			if (!empty($arr1)) foreach($arr1 as $k=>$v){
				if ($i1>20) break;
				if (!isset($res2[$k])) {
					$res1[$k] = $v;
					$i1++;
				}
			}
			
			if (!empty($arr3)) foreach($arr3 as $k=>$v){
				if ($i2>15) break;
				if (!isset($res2[$k])) {
					$res2[$k] = $v;
					$i2++;
				}				
			}

			$this->data['tickets'] = $res1;
			if (!empty($this->data['tickets'])) foreach ($this->data['tickets'] as $key=>$ticket){
				$this->data['tickets'][$key]['city_name'] = (isset($this->data['cities'][$this->data['tickets'][$key]['city_id']]))  ? $this->data['cities'][$this->data['tickets'][$key]['city_id']]['name'] : 'город, которого нет';
				$this->data['tickets'][$key]['districts_name'] = (isset($this->data['districts'][$this->data['tickets'][$key]['district_id']]))  ? $this->data['districts'][$this->data['tickets'][$key]['district_id']]['name'] : 'не указан';
				$this->data['tickets'][$key]['type_name'] = (isset($this->data['types'][$this->data['tickets'][$key]['type_id']]))  ? $this->data['types'][$this->data['tickets'][$key]['type_id']]['name'] : 'недвижимость';
				$this->data['tickets'][$key]['numRooms_name'] = (isset($this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]))  ? $this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]['name'] : 'Количество комнат не указано';
			}
			$res1 = $this->data['tickets'];

			$this->data['tickets'] = $res2;
			if (!empty($this->data['tickets'])) foreach ($this->data['tickets'] as $key=>$ticket){
				$this->data['tickets'][$key]['city_name'] = (isset($this->data['cities'][$this->data['tickets'][$key]['city_id']]))  ? $this->data['cities'][$this->data['tickets'][$key]['city_id']]['name'] : 'город, которого нет';
				$this->data['tickets'][$key]['districts_name'] = (isset($this->data['districts'][$this->data['tickets'][$key]['district_id']]))  ? $this->data['districts'][$this->data['tickets'][$key]['district_id']]['name'] : 'не указан';
				$this->data['tickets'][$key]['type_name'] = (isset($this->data['types'][$this->data['tickets'][$key]['type_id']]))  ? $this->data['types'][$this->data['tickets'][$key]['type_id']]['name'] : 'недвижимость';
				$this->data['tickets'][$key]['numRooms_name'] = (isset($this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]))  ? $this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]['name'] : 'Количество комнат не указано';
			}
			$res2 = $this->data['tickets'];

			$this->data['res1'] = $res1;
			$this->data['res2'] = $res2;

			$page['head'] = $this->add_css_file(SITE_URL . '/modules/blocks/' . $this->block_name . '/views/style.css');
			$page['html'] = $this->load_view('index');
			return $page;
		}
	}
?>