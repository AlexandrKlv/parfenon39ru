<?php
	class controller_block_realtySearch extends block{
		public function action_index(){
			/*
			if (isset($_SESSION['nah'])) {
				echo $_SESSION['nah'];
				unset($_SESSION['nah']);
			}
			*/
			$tmp = explode('www/', $this->block_dir);
			$this->data['block_dir'] = isset($tmp[1]) ? SITE_URL . '/' . $tmp[1] : SITE_URL . "/modules/blocks/realtySearch";
			$this->data['cities'] = $this->dbh->query("SELECT * FROM es_cities WHERE 1");
			
			if (isset($_SESSION['block_realtySearch'])){
				$this->data['realtyChecked'] = $_SESSION['block_realtySearch'];
				//echo '<pre>';
				//print_r($_SESSION['block_realtySearch']);
				//echo '</pre>';
				unset($_SESSION['block_realtySearch']);				
			}

			$city_id=0;
			if (!empty($this->data['cities'])) foreach ($this->data['cities'] as $city){
				$city_id = $city['id'];
				break; //xu-xu
			}
			if (isset($this->data['realtyChecked']['cities'])) foreach ($this->data['realtyChecked']['cities'] as $city_id1=>$number_one){
				$city_id = $city_id1;
				break;
			}

			$this->data['city_id'] = $city_id;
			
			$this->data['districts'] = $city_id!=0 ? $this->dbh->query("SELECT * FROM es_districts WHERE id_city=" . $city_id) : array();
				
			$this->data['types'] = $this->dbh->query("SELECT * FROM es_types WHERE 1");

			$this->data['numRooms'] = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1");
			
			
			$page['head'] = $this->add_css_file(SITE_URL . '/modules/blocks/' . $this->block_name . '/views/style.css');
			$page['html'] = $this->load_view('index');
			return $page;
		}
	}
?>