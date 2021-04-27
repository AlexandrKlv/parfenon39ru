<?php set_time_limit(1200);
ini_set('upload_max_filesize', '60M');
ini_set('post_max_size', '60M');

class controller_component_realty extends component {
	
/*	public function action_index() {
		$sql = "SELECT * FROM estate WHERE status=1"; //общий запрос (на все объявления)

		if (isset($_POST['plot'])) { //Была отправлена форма, то есть запрос на часть объявлений (проверяем по plot (площадь от), так как submit может и из другой формы быть отпр.)
			$location = SITE_URL . "/" . $this->component_info['url'] .  $this->model->get_post_to_get_params(); //перенапраление для поиска
			header("location:" . $location);
			exit;
		}
	
		$params = $this->url['params'];
		
		//if (!empty($params))
		
		$tickets = $this->model->actions_params_to_sql(array(), $params);
		$this->data['tickets'] = $tickets;
	
		//echo '<pre>';
		//print_r($params);
		//echo '</pre>';
		//$_SESSION['nah'] = 1;
	
		$this->page['html']  = $this->load_view();
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/style.css');		

		return $this->page;
				
		//$main_id=$this->component_info['id'];		
		//$settings=$this->model->get_params($main_id);
		//$this->data['main_id']=$main_id;
		//$this->data['settings']=$settings;
		
		//разделение url
		//сохраняем все категории в корне каталога	
        //$this->data['st']=$db->query("SELECT * FROM `cats` WHERE `sub` =0 ORDER BY `sort` LIMIT 100");

		//var_dump($uri_items);
		
	}
	*/

	public function action_index(){
		if (isset($_POST['plot'])) { //Была отправлена форма, то есть запрос на часть объявлений (проверяем по plot (площадь от), так как submit может и из другой формы быть отпр.)
			$location = SITE_URL . "/" . $this->component_info['url'] .  $this->model->get_post_to_get_params(); //перенапраление для поиска
			header("location:" . $location);
			exit;
		}
		if ($this->get_global_data('user')) {
			//print_r($this->get_global_data('user'));
			$uzver = $this->get_global_data('user');
			if (isset($uzver['id'])){
				$agent = $uzver['id'];
				if ($uzver['status']!=0) $status = 1;
				if ($uzver['status']!=0) $this->data['real']=$uzver['status'];
			}
		}
		$actions = $this->url['actions'];
		$params = $this->url['params'];
		
		$result = $this->model->actions_params_to_sql(array(0=>'cities', 1=>'districts', 2=>'all'), $params);		

		$tickets = isset($result[0]) ? $result[0] : FALSE;
		$count_pages = isset($result[1]) ? ceil(((int)$result[1]) / 10) : 1;
		
		$this->data['tickets'] = $tickets!==FALSE ? $tickets : array();

		//echo '<pre>';
		//print_r($actions);
		//print_r($params);
		//echo '</pre>';
		
		$this->data['cities'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_cities WHERE status>0"));
		
		// Поиск только конкретных районов (иначе их может быть много)
		$city_idx=0;
		if (isset( $_SESSION['block_realtySearch']['cities'])) foreach ( $_SESSION['block_realtySearch']['cities'] as $city_id2=>$number_one){
			$city_idx = $city_id2;
			break;
		}
		$this->data['city_id'] = $city_idx;		
		//$tmp_where = $city_idx ? "id_city=" . $city_idx : "1" ;
		$tmp_where = "id_city=" . $city_idx;
		$sql = "SELECT * FROM es_districts WHERE " . $tmp_where; 
		unset($tmp_where);
		if (isset($actions[1])) if ($actions[1]!='districts'){
			$distr = explode('+', $actions[1]);
			if (!empty($distr)) {
				$sql .= " AND (0";
				foreach($distr as $dist){
					$sql .= " OR enname='" . $dist . "'";
				}
				$sql .= ")";
			}
		}
		//print_r($sql);
		$this->data['districts'] = $this->model->array_by_id($this->dbh->query($sql)); //[17] => array( [id]=>17 ...
		/*
		if (!empty($this->data['districts'])) {
			$tmp = array();
			foreach ($this->data['districts'] as $k=>$v) $tmp[$v['id']] = $v;
			
		}
		*/
		
		$this->data['types'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_types WHERE 1"));

		$this->data['numRooms'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_num_rooms WHERE 1"));
		
		//добавляем каждому ticket названия его района, типа, комнат
		if (!empty($this->data['tickets'])) foreach ($this->data['tickets'] as $key=>$ticket){
			$this->data['tickets'][$key]['city_name'] = (isset($this->data['cities'][$this->data['tickets'][$key]['city_id']]))  ? $this->data['cities'][$this->data['tickets'][$key]['city_id']]['name'] : 'город, которого нет';
			$this->data['tickets'][$key]['districts_name'] = (isset($this->data['districts'][$this->data['tickets'][$key]['district_id']]))  ? $this->data['districts'][$this->data['tickets'][$key]['district_id']]['name'] : 'не указан';
			$this->data['tickets'][$key]['type_name'] = (isset($this->data['types'][$this->data['tickets'][$key]['type_id']]))  ? $this->data['types'][$this->data['tickets'][$key]['type_id']]['name'] : 'недвижимость';
			$this->data['tickets'][$key]['numRooms_name'] = (isset($this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]))  ? $this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]['name'] : 'Количество комнат не указано';
		}
		//echo '<pre>';
		//print_r($this->data['tickets']);
		//echo '</pre>';
		//print_r($this->data['districts']);

		//$this->data['districts'] = $this->dbh->query($sql); //можно оптимизировать по районам

		//$_SESSION['nah'] = 2;
		//$this->model->nah('es_cities');
		//echo '1';
		$this->data['count_pages'] = $count_pages;
		$this->data['num_page'] = isset($params['page']) ? $params['page'] : 1;
		$this->data['sort'] = isset($params['sort']) ? $params['sort'] : '';

		$this->data['pages_nav'] = $this->model->pages_nav($this->data['count_pages'], 15, $this->data['num_page'], 3);
		
		//echo $count_pages;
		
		/*
		
		$this->model->nah('es_cities');
		$this->model->nah('es_types');
		$this->model->nah('es_districts');
		$this->model->nah('es_num_rooms');
		
		*/		

		$this->page['html']  = $this->load_view('index');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/style.css');		
		return $this->page;
	}
	
	public function action_else(){
		
		$actions = $this->url['actions'];
		$params = $this->url['params'];
		if ($this->get_global_data('user')) {
			//print_r($this->get_global_data('user'));
			$uzver = $this->get_global_data('user');
			if (isset($uzver['id'])){
				$agent = $uzver['id'];
				if ($uzver['status']!=0) $status = 1;
				if ($uzver['status']!=0) $this->data['real']=$uzver['status'];
			}
		}
		
		
		$this->data['path'] = SITE_URL . '/realty';
		$this->data['path'] .= isset($actions[0]) ? '/'.$actions[0] : '/cities'; 
		$this->data['path'] .= isset($actions[1]) ? '/'.$actions[1] : '/districts'; 
		$this->data['path'] .= isset($actions[2]) ? '/'.$actions[2] : '/all'; 
		
		if (isset($actions[3])){
			$tmpitem = explode('-', $actions[3]);
			$item = isset($tmpitem[1]) ? $tmpitem[count($tmpitem)-1] : 0;
			$tmparr = $this->dbh->query("SELECT * FROM estate WHERE id=".$item." LIMIT 1");
			$this->data['item'] = (!empty($tmparr)) ? $tmparr[0] : FALSE;
			if ($this->data['item']) $this->dbh->exec("UPDATE estate SET views=" . ($this->data['item']['views'] + 1) ." WHERE id=".$this->data['item']['id']);
//			print_r($this->data['item']);
			if ($this->data['item']['district_id']) $this->data['districty'] = $this->dbh->query("SELECT * FROM es_districts WHERE id=" . $this->data['item']['district_id']);
			else  $this->data['districty']=0;
//print_r(	$this->data['districty']);		
			if ($this->data['districty']) $this->data['districty'] = $this->data['districty'][0]['name']; else unset($this->data['districty']);
			//print_r($this->data['item']);
			//exit;
		}
		
		$result = $this->model->actions_params_to_sql($actions, $params);		
		//print_r($result);
		$tickets = isset($result[0]) ? $result[0] : FALSE;
		$count_pages = isset($result[1]) ? ceil(((int)$result[1]) / 10) : 1;
		
		$this->data['tickets'] = $tickets!==FALSE ? $tickets : array();

		//echo '<pre>';
		//print_r($actions);
		//print_r($params);
		//echo '</pre>';
		
		$this->data['cities'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_cities WHERE 1"));
		
		// Поиск только конкретных районов (иначе их может быть много)
		$city_idx=0;
		if (isset( $_SESSION['block_realtySearch']['cities'])) foreach ( $_SESSION['block_realtySearch']['cities'] as $city_id2=>$number_one){
			$city_idx = $city_id2;
			break;
		}
		$this->data['city_id'] = $city_idx;		
		//$tmp_where = $city_idx ? "id_city=" . $city_idx : "1" ;
		$tmp_where = "id_city=" . $city_idx;
		$sql = "SELECT * FROM es_districts WHERE " . $tmp_where; 
		unset($tmp_where);
		if (isset($actions[1])) if ($actions[1]!='districts'){
			$distr = explode('+', $actions[1]);
			if (!empty($distr)) {
				$sql .= " AND (0";
				foreach($distr as $dist){
					$sql .= " OR enname='" . $dist . "'";
				}
				$sql .= ")";
			}
		}
		//print_r($sql);
		$this->data['districts'] = $this->model->array_by_id($this->dbh->query($sql)); //[17] => array( [id]=>17 ...
			//print_r($sql);
	
		/*
		if (!empty($this->data['districts'])) {
			$tmp = array();
			foreach ($this->data['districts'] as $k=>$v) $tmp[$v['id']] = $v;
			
		}
		*/
		
		$this->data['types'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_types WHERE 1"));

		$this->data['numRooms'] = $this->model->array_by_id($this->dbh->query("SELECT * FROM es_num_rooms WHERE 1"));
		
		//добавляем каждому ticket названия его района, типа, комнат
		if (!empty($this->data['tickets'])) foreach ($this->data['tickets'] as $key=>$ticket){
			$this->data['tickets'][$key]['city_name'] = (isset($this->data['cities'][$this->data['tickets'][$key]['city_id']]))  ? $this->data['cities'][$this->data['tickets'][$key]['city_id']]['name'] : 'город, которого нет';
			$this->data['tickets'][$key]['districts_name'] = (isset($this->data['districts'][$this->data['tickets'][$key]['district_id']]))  ? $this->data['districts'][$this->data['tickets'][$key]['district_id']]['name'] : 'не указан';
			$this->data['tickets'][$key]['type_name'] = (isset($this->data['types'][$this->data['tickets'][$key]['type_id']]))  ? $this->data['types'][$this->data['tickets'][$key]['type_id']]['name'] : 'недвижимость';
			$this->data['tickets'][$key]['type_enname'] = (isset($this->data['types'][$this->data['tickets'][$key]['type_id']]))  ? $this->data['types'][$this->data['tickets'][$key]['type_id']]['enname'] : 'ned';
			$this->data['tickets'][$key]['numRooms_name'] = (isset($this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]))  ? $this->data['numRooms'][$this->data['tickets'][$key]['num_rooms_id']]['name'] : 'Количество комнат не указано';
		}

		if (isset($this->data['item'])) if (!empty($this->data['item'])) {
			$this->data['item']['city_name'] = (isset($this->data['cities'][$this->data['item']['city_id']]))  ? $this->data['cities'][$this->data['item']['city_id']]['name'] : 'город, которого нет';
			$this->data['item']['districts_name'] = (isset($this->data['districts'][$this->data['item']['district_id']]))  ? $this->data['districts'][$this->data['item']['district_id']]['name'] : 'не указан';
			$this->data['item']['type_name'] = (isset($this->data['types'][$this->data['item']['type_id']]))  ? $this->data['types'][$this->data['item']['type_id']]['name'] : 'недвижимость';
			$this->data['item']['type_enname'] = (isset($this->data['types'][$this->data['item']['type_id']]))  ? $this->data['types'][$this->data['item']['type_id']]['enname'] : 'ned';
			$this->data['item']['numRooms_name'] = (isset($this->data['numRooms'][$this->data['item']['num_rooms_id']]))  ? $this->data['numRooms'][$this->data['item']['num_rooms_id']]['name'] : 'Количество комнат не указано';
		}

		//echo '<pre>';
		//print_r($this->data['tickets']);
		//echo '</pre>';
		//print_r($this->data['districts']);

		//$this->data['districts'] = $this->dbh->query($sql); //можно оптимизировать по районам

		//$_SESSION['nah'] = 2;
		
		$this->data['count_pages'] = $count_pages;
		$this->data['num_page'] = isset($params['page']) ? $params['page'] : 1;
		$this->data['sort'] = isset($params['sort']) ? $params['sort'] : '';
		
		$this->data['pages_nav'] = $this->model->pages_nav($this->data['count_pages'], 15, $this->data['num_page'], 3);
		
		//echo $count_pages;
		
		/*
		
		$this->model->nah('es_cities');
		$this->model->nah('es_types');
		$this->model->nah('es_districts');
		$this->model->nah('es_num_rooms');
		
		*/
		$this->page['html']  = $this->load_view('index');
		if (isset($item)) if ($item) 	{
			$agent = $this->dbh->query("SELECT * FROM users WHERE id=".$this->data['item']['agent_id']." LIMIT 1");
			//print_r($this->data['item']);
			$this->data['agent'] = !empty($agent) ? $agent[0] : FALSE;
			//print_r($agent);
			//print_r($item['agent_id']);
			$this->page['html']  = $this->load_view('item');
		}
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/style.css');		
		return $this->page;
	}
	
	public function action_add(){
		$this->load_helper('image');
		$really_errs = array();
		$errs = array();
		
		$agent = 0;
		$status = 0;
		if ($this->get_global_data('user')) {
			//print_r($this->get_global_data('user'));
			$uzver = $this->get_global_data('user');
			if (isset($uzver['id'])){
				$agent = $uzver['id'];
				if ($uzver['status']!=0) {$status = 1; }
				
				//print_r($uzver);
				
				$this->data['uzver'] = $uzver;
			}
		}
		
		if (isset($_POST['resp1'])){
			
				if ((!isset($_SESSION['captchasuf']) || !isset($_POST['captchasuf']) || $_SESSION['captchasuf'] != $_POST['captchasuf'])){
					$really_errs['capcha'] = 'Пример решен неверно.'; 
				}

			$action=0; if (isset($_POST['tipob'])) $action = $_POST['tipob']; else $errs['tipob'] = 1;
			$cn=0; if (isset($_POST['myname'])) $cn = $_POST['myname']; else {$really_errs['myname'] = 1;$errs['myname'] = 1;}
			$contact=0; if (isset($_POST['myphone'])) $contact = $_POST['myphone']; else {$really_errs['myphone'] = 1;$errs['myphone'] = 1;}
			$type=0; if (isset($_POST['tip'])) $type = $_POST['tip']; else $errs['tip'] = 1;
			$city=0; if (isset($_POST['resp1'])) $city = $_POST['resp1']; else $errs['resp1'] = 1;
			
			if (($type>0) AND ($type<4)){
				if ($_POST['etazh']=='') {$really_errs['etazh'] = 1; } 
				if ($_POST['etazhey']=='') {$really_errs['etazhey'] = 1; }
				if ($_POST['pricex']=='') {$really_errs['pricex'] = 1; }
				if ($_POST['squarex']=='') {$really_errs['squarex'] = 1; }
				if (trim($_POST['street'])=='') {$really_errs['street'] = 1;} 
				//echo 'zzz'; exit;
			}
			
			$district = 0;
			if (isset($city)) $districts=$this->dbh->query("SELECT * FROM es_districts WHERE id_city=".$city);
			if (!isset($districts)) {$errs['rayonx'] = 1;} 
			elseif (!empty($districts)) foreach ($districts as $districto){
				/*if (isset($_POST['rayonx'.$districto['id']])){
					$district = $districto['id'];
					break;
					
				}
				*/
				if (isset($_POST['rayonx'])) if ($_POST['rayonx']==$districto['id']) $district = $districto['id'];
			}
			if ($district==0) {$errs['rayonx'] = 1;}
			
			if (isset($_POST['numroomsx'])) $numrooms = $_POST['numroomsx']; else $errs['numroomsx'] = 1;
			
			$house_type=0; if (isset($_POST['tpd'])) $house_type = $_POST['tpd']; else $errs['tpd'] = 1;
			$street=0; if (isset($_POST['street'])) $street = $_POST['street']; else $errs['street'] = 1;
			$dm=0; if (isset($_POST['dm'])) $dm = $_POST['dm']; else $errs['dm'] = 1;
			$kv=0; if (isset($_POST['kv'])) $kv = $_POST['kv']; else $errs['kv'] = 1;
			$floor=0; if (isset($_POST['etazh'])) $floor = $_POST['etazh']; else $errs['etazh'] = 1;
			$floor_num=0; if (isset($_POST['etazhey'])) $floor_num = $_POST['etazhey']; else $errs['etazhey'] = 1;
			$price=0; if (isset($_POST['pricex'])) $price = $_POST['pricex']; else $errs['pricex'] = 1;
			$square=0; if (isset($_POST['squarex'])) $square = $_POST['squarex']; else $errs['squarex'] = 1;
			$description=0; if (isset($_POST['descx'])) $description = $_POST['descx']; else $description='';
			
			$flagstock = 0; //$FILES ======================-!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			for ($tmp = 1; $tmp<=10; $tmp++){
				if(is_uploaded_file($_FILES['image'.$tmp]['tmp_name'])) {
					$str = 'ph'.$tmp;
					$$str = $this->helper_image->img_upload('image'.$tmp, 1000, ROOT_DIR . '/uploads/images/realty/', 200);
					//$this->data['image'.$tmp] = $this->helper_image->img_upload('image'.$tmp, 1000, ROOT_DIR . '/uploads/images/realty/', 200);	
				}
				else {
					$str = 'ph'.$tmp;
					$$str = '';
					//$this->data['image'.$tmp] = '';
				}
			}

			/*
			if (isset($_POST['image1'])) {$ph1 = $_POST['image1']; $flagstock=1;} else $ph1='';
			if (isset($_POST['image2'])) {$ph2 = $_POST['image2']; $flagstock=1;} else $ph2='';
			if (isset($_POST['image3'])) {$ph3 = $_POST['image3']; $flagstock=1;} else $ph3='';
			if (isset($_POST['image4'])) {$ph4 = $_POST['image4']; $flagstock=1;} else $ph4='';
			if (isset($_POST['image5'])) {$ph5 = $_POST['image5']; $flagstock=1;} else $ph5='';
			if (isset($_POST['image6'])) {$ph6 = $_POST['image6']; $flagstock=1;} else $ph6='';
			if (isset($_POST['image7'])) {$ph7 = $_POST['image7']; $flagstock=1;} else $ph7='';
			if (isset($_POST['image8'])) {$ph8 = $_POST['image8']; $flagstock=1;} else $ph8='';
			if (isset($_POST['image9'])) {$ph9 = $_POST['image9']; $flagstock=1;} else $ph9='';
			if (isset($_POST['image10'])) {$ph10 = $_POST['image10']; $flagstock=1;} else $ph10='';
			*/
			//if ($flagstock!=0) {} else {$errs['image'] = 1;}
			
			if (isset($_POST['videox1'])) $videox1 = $_POST['videox1']; else $videox1 = '';
			if (isset($_POST['videox2'])) $videox2 = $_POST['videox2']; else $videox2 = '';
			if (isset($_POST['videox3'])) $videox3 = $_POST['videox3']; else $videox3 = '';
			$dog = isset($_POST['dog']) ? $_POST['dog'] : 0;
 			$views = 0;
			$time = time();
			
			if (empty($really_errs)){
				$sql = "INSERT INTO estate ('type_id', 'city_id', 'district_id', 'num_rooms_id', 'agent_id', 'price', 'square', 'description', 'floor', 'floor_num', 'house_type', 'street', 'views', 'contact_name', 'contact_phone', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'photo7', 'photo8', 'photo9', 'photo10', 'video1', 'video2', 'video3', 'date_add', 'date_edit', 'status', 'action', 'dog', 'dm', 'kv') VALUES ('".SQLite3::escapeString($type)."', '".SQLite3::escapeString($city)."', '".SQLite3::escapeString($district)."', '".SQLite3::escapeString($numrooms)."', '".SQLite3::escapeString($agent)."', '".SQLite3::escapeString($price)."', '".SQLite3::escapeString($square)."', '".SQLite3::escapeString($description)."', '".SQLite3::escapeString($floor)."', '".SQLite3::escapeString($floor_num)."', '".SQLite3::escapeString($house_type)."', '".SQLite3::escapeString($street)."', '".SQLite3::escapeString($views)."', '".SQLite3::escapeString($cn)."', '".SQLite3::escapeString($contact)."', '".SQLite3::escapeString($ph1)."', '".SQLite3::escapeString($ph2)."', '".SQLite3::escapeString($ph3)."', '".SQLite3::escapeString($ph4)."', '".SQLite3::escapeString($ph5)."', '".SQLite3::escapeString($ph6)."', '".SQLite3::escapeString($ph7)."', '".SQLite3::escapeString($ph8)."', '".SQLite3::escapeString($ph9)."', '".SQLite3::escapeString($ph10)."', '".SQLite3::escapeString($videox1)."', '".SQLite3::escapeString($videox2)."', '".SQLite3::escapeString($videox3)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($status)."', '".SQLite3::escapeString($action)."', '" . SQLite3::escapeString($dog) . "', '" . SQLite3::escapeString($dm) . "', '" . SQLite3::escapeString($kv) . "')";
				$st = $this->dbh->exec($sql);
				if ($st) {
					$_SESSION['estate_ok'] = 1;
					header("location:" . SITE_URL . '/realty/add');
					exit;
				} else {
					$errs['base'] = 1;
				}
			}
			
			//print_r($sql);
		}
		$this->data['src_captcha'] = SITE_URL . '/user_cms/helpers/captcha.php?suffix=suf';
		$this->data['cities'] = $this->dbh->query("SELECT * FROM es_cities WHERE 1");
		
		$this->data['districts'] = 1!=0 ? $this->dbh->query("SELECT * FROM es_districts WHERE id_city=1") : array();
			
		$this->data['types'] = $this->dbh->query("SELECT * FROM es_types WHERE 1");

		$this->data['numRooms'] = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1");

		if (!TRUE) $this->data['errs'] = $errs;
		if (TRUE) $this->data['really_errs'] = $really_errs;
		
		$this->data['block_dirs'] = SITE_URL . "/modules/blocks/realtySearch";
		$this->page['html']  = $this->load_view('add');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/style.css');		
		return $this->page;		
	}
	
	public function action_editx(){
		$this->load_helper('image');

		//$actions = $this->url['actions'];
		//$params = $this->url['params'];

		$id = (isset($this->url['params']['id'])) ? $this->url['params']['id'] : 0;
		if ($id<=0) $errs['find'] = 1;
	
		$errs = array();
		
		$agent = 0;
		$status = 0;
		if ($this->get_global_data('user')) {
			//print_r($this->get_global_data('user'));
			$uzver = $this->get_global_data('user');
			if (isset($uzver['id'])){
				$agent = $uzver['id'];
				if ($uzver['status']!=0) $status = 1;
				if ($uzver['status']!=0) $this->data['real']=$uzver['status'];
			}
		}
		
		$userflag = FALSE;
		$thisestate = $this->dbh->query("SELECT * FROM estates WHERE id=".$id." LIMIT 1");
		if (!empty($thisestate)){ 
			$thisestate = $thisestate[0];
			if (isset($thisestate['agent_id'])) {
				if ($agent==$thisestate['agent_id']) $userflag = TRUE;
			}
		}
		if ($agent = 1) $userflag = TRUE;
		if (!$userflag) $errs['user'] = 1;
		
	if (TRUE)
		if (isset($_POST['resp1'])){
			$action = 0; if (isset($_POST['tipob'])) $action = $_POST['tipob']; else $errs['tipob'] = 1;
			$cn = 0; if (isset($_POST['myname'])) $cn = $_POST['myname']; else $errs['myname'] = 1;
			$contact = 0; if (isset($_POST['myphone'])) $contact = $_POST['myphone']; else $errs['myphone'] = 1;
			$type=0; if (isset($_POST['tip'])) $type = $_POST['tip']; else $errs['tip'] = 1;
			$city=1; if (isset($_POST['resp1'])) $city = $_POST['resp1']; else $errs['resp1'] = 1;
			
			$district = 0;
			if (isset($city)) $districts=$this->dbh->query("SELECT * FROM es_districts WHERE id_city=".$city);
			if (!isset($districts)) {$errs['rayonx'] = 1;} 
			elseif (!empty($districts)) foreach ($districts as $districto){
				if (isset($_POST['rayonx'.$districto['id']])){
					$district = $districto['id'];
					break;
				}
			}
			if ($district=0) {$errs['rayonx'] = 1;}
			
			if (isset($_POST['numroomsx'])) $numrooms = $_POST['numroomsx']; else $errs['numroomsx'] = 1;
			//echo '<pre>';
			//print_r($_POST);
			//echo '</pre>';
			
			$house_type=0; if (isset($_POST['tpd'])) $house_type = $_POST['tpd']; else $errs['tpd'] = 1;
			$street=''; if (isset($_POST['street'])) $street = $_POST['street']; else $errs['street'] = 1;
			$dm=''; if (isset($_POST['dm'])) $dm = $_POST['dm']; else $errs['dm'] = 1;
			$kv=''; if (isset($_POST['kv'])) $kv = $_POST['kv']; else $errs['kv'] = 1;
			$floor=0; if (isset($_POST['etazh'])) $floor = $_POST['etazh']; else $errs['etazh'] = 1;
			$floor_num=0; if (isset($_POST['etazhey'])) $floor_num = $_POST['etazhey']; else $errs['etazhey'] = 1;
			$price=0; if (isset($_POST['pricex'])) $price = $_POST['pricex']; else $errs['pricex'] = 1;
			$square=0; if (isset($_POST['squarex'])) $square = $_POST['squarex']; else $errs['squarex'] = 1;
			$description=0; if (isset($_POST['descx'])) $description = $_POST['descx']; else $description='';
			
			$flagstock = 0; //$FILES ======================-!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			for ($tmp = 1; $tmp<=10; $tmp++){
				if(is_uploaded_file($_FILES['image'.$tmp]['tmp_name'])) {
					$str = 'ph'.$tmp;
					$$str = $this->helper_image->img_upload('image'.$tmp, 1000, ROOT_DIR . '/uploads/images/realty/', 200);
					//$this->data['image'.$tmp] = $this->helper_image->img_upload('image'.$tmp, 1000, ROOT_DIR . '/uploads/images/realty/', 200);	
				}
				else {
					$str = 'ph'.$tmp;
					$$str = '';
					//$this->data['image'.$tmp] = '';
				}
			}

			/*
			if (isset($_POST['image1'])) {$ph1 = $_POST['image1']; $flagstock=1;} else $ph1='';
			if (isset($_POST['image2'])) {$ph2 = $_POST['image2']; $flagstock=1;} else $ph2='';
			if (isset($_POST['image3'])) {$ph3 = $_POST['image3']; $flagstock=1;} else $ph3='';
			if (isset($_POST['image4'])) {$ph4 = $_POST['image4']; $flagstock=1;} else $ph4='';
			if (isset($_POST['image5'])) {$ph5 = $_POST['image5']; $flagstock=1;} else $ph5='';
			if (isset($_POST['image6'])) {$ph6 = $_POST['image6']; $flagstock=1;} else $ph6='';
			if (isset($_POST['image7'])) {$ph7 = $_POST['image7']; $flagstock=1;} else $ph7='';
			if (isset($_POST['image8'])) {$ph8 = $_POST['image8']; $flagstock=1;} else $ph8='';
			if (isset($_POST['image9'])) {$ph9 = $_POST['image9']; $flagstock=1;} else $ph9='';
			if (isset($_POST['image10'])) {$ph10 = $_POST['image10']; $flagstock=1;} else $ph10='';
			*/
			//if ($flagstock!=0) {} else {$errs['image'] = 1;}
			
			if (isset($_POST['videox1'])) $videox1 = $_POST['videox1']; else $videox1 = '';
			if (isset($_POST['videox2'])) $videox2 = $_POST['videox2']; else $videox2 = '';
			if (isset($_POST['videox3'])) $videox3 = $_POST['videox3']; else $videox3 = '';
			
			$views = 0;
			$time = time();
			
			//if (TRUE){
			if (TRUE){
				$sql = "UPDATE estate SET 'type_id'='".SQLite3::escapeString($type)."', 'city_id'='".SQLite3::escapeString($city)."', 'district_id'='".SQLite3::escapeString($district)."', 'num_rooms_id'='".SQLite3::escapeString($numrooms)."', 'agent_id'='".SQLite3::escapeString($agent)."', 'price'='".SQLite3::escapeString($price)."', 'square'='".SQLite3::escapeString($square)."', 'description'='".SQLite3::escapeString($description)."', 'floor'='".SQLite3::escapeString($floor)."', 'floor_num'='".SQLite3::escapeString($floor_num)."', 'house_type'='".SQLite3::escapeString($house_type)."', 'street'='".SQLite3::escapeString($street)."', 'views'='".SQLite3::escapeString($views)."', 'contact_name'='".SQLite3::escapeString($cn)."', 'contact_phone'='".SQLite3::escapeString($contact)."', 'photo1'='".SQLite3::escapeString($ph1)."', 'photo2'='".SQLite3::escapeString($ph2)."', 'photo3'='".SQLite3::escapeString($ph3)."', 'photo4'='".SQLite3::escapeString($ph4)."', 'photo5'='".SQLite3::escapeString($ph5)."', 'photo6'='".SQLite3::escapeString($ph6)."', 'photo7'='".SQLite3::escapeString($ph7)."', 'photo8'='".SQLite3::escapeString($ph8)."', 'photo9'='".SQLite3::escapeString($ph9)."', 'photo10'='".SQLite3::escapeString($ph10)."', 'video1'='".SQLite3::escapeString($videox1)."', 'video2'='".SQLite3::escapeString($videox2)."', 'video3'='".SQLite3::escapeString($videox3)."',  'date_edit'='".SQLite3::escapeString(time())."', 'action'='".SQLite3::escapeString($action)."' WHERE id=".$id;
				
				//$sql = "INSERT INTO estate ('type_id', 'city_id', 'district_id', 'num_rooms_id', 'agent_id', 'price', 'square', 'description', 'floor', 'floor_num', 'house_type', 'street', 'views', 'contact_name', 'contact_phone', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'photo7', 'photo8', 'photo9', 'photo10', 'video1', 'video2', 'video3', 'date_add', 'date_edit', 'status', 'action') VALUES ('".SQLite3::escapeString($type)."', '".SQLite3::escapeString($city)."', '".SQLite3::escapeString($district)."', '".SQLite3::escapeString($numrooms)."', '".SQLite3::escapeString($agent)."', '".SQLite3::escapeString($price)."', '".SQLite3::escapeString($square)."', '".SQLite3::escapeString($description)."', '".SQLite3::escapeString($floor)."', '".SQLite3::escapeString($floor_num)."', '".SQLite3::escapeString($house_type)."', '".SQLite3::escapeString($street)."', '".SQLite3::escapeString($views)."', '".SQLite3::escapeString($cn)."', '".SQLite3::escapeString($contact)."', '".SQLite3::escapeString($ph1)."', '".SQLite3::escapeString($ph2)."', '".SQLite3::escapeString($ph3)."', '".SQLite3::escapeString($ph4)."', '".SQLite3::escapeString($ph5)."', '".SQLite3::escapeString($ph6)."', '".SQLite3::escapeString($ph7)."', '".SQLite3::escapeString($ph8)."', '".SQLite3::escapeString($ph9)."', '".SQLite3::escapeString($ph10)."', '".SQLite3::escapeString($videox1)."', '".SQLite3::escapeString($videox2)."', '".SQLite3::escapeString($videox3)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($status)."', '".SQLite3::escapeString($action)."')";
				
				$st = $this->dbh->exec($sql);
				if ($st) {
					$_SESSION['estate_ok'] = 1;
					header("location:" . SITE_URL . '/realty/cities/districts/all/all-'.$id);
					exit;
				} else {
					$errs['base'] = 1;
				}
			}
			
			//print_r($sql);
		}
		
		$this->data['cities'] = $this->dbh->query("SELECT * FROM es_cities WHERE 1");
		
		$this->data['city'] = $this->dbh->query("SELECT * FROM es_cities WHERE 1");
		
		//$this->data['city'] = isset()
		
		$this->data['districts'] = 1!=0 ? $this->dbh->query("SELECT * FROM es_districts WHERE id_city=1") : array();
			
		$this->data['types'] = $this->dbh->query("SELECT * FROM es_types WHERE 1");

		$this->data['numRooms'] = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1");

		if (!TRUE) $this->data['errs'] = $errs;
		
		$this->data['block_dirs'] = SITE_URL . "/modules/blocks/realtySearch";
		$this->page['html']  = $this->load_view('editx');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/style.css');		
		return $this->page;		
	}
	
	
	
	
	
	
}
