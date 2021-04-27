<?php 
class controller_component_realty extends component {

	public function action_index() {
		$sql = "SELECT * FROM estate WHERE 1";
		
		$params = $this->url['params'];
		$numpage = isset($params['page']) ? $params['page'] : 1;

		$start = ($numpage-1) * 10;
		if ($start<0) $start=0;
		
		
		$result_count = $this->dbh->query_count($sql);		
		$count_pages = ceil(((int)$result_count) / 10);
		
		$this->data['estates'] = $this->dbh->query("SELECT * FROM estate WHERE 1 ORDER BY imp DESC, status, date_add DESC LIMIT ".$start.", 10");
		
		$this->data['agents'] = $this->dbh->query("SELECT * FROM users WHERE 1");

		$this->data['count_pages'] = $count_pages;
		$this->data['num_page'] = isset($params['page']) ? $params['page'] : 1;
		
		$this->data['pages_nav'] = $this->model->pages_nav($this->data['count_pages'], 20, $this->data['num_page'], 3);

		$tmpa = 0;
		$tmparr = array();
		if (isset($this->data['estates'])) if (!empty($this->data['estates'])){
			foreach($this->data['estates'] as $estate) {
				$tmparr[$tmpa] = $estate;
				$tmpa++;
			}
			for ($tmpi=0; $tmpi<count($tmparr)-1; $tmpi++)
				for ($tmpj=$tmpi+1; $tmpj < count($tmparr); $tmpj++){
					if ((isset($tmparr[$tmpi])) and (isset($tmparr[$tmpj])))
						if (($tmparr[$tmpi]['imp'] > 0) and ($tmparr[$tmpj]['imp'] > 0) and ($tmparr[$tmpj]['imp']<$tmparr[$tmpi]['imp'])) 
							{$tu = $tmparr[$tmpi]; $tmparr[$tmpi]=$tmparr[$tmpj]; $tmparr[$tmpj]=$tu;}
				}
				
			$this->data['estates'] = $tmparr;	
		}

		//$this->page['html'] = str_replace('&#65279;', '', $this->load_view('left_menu') . $this->load_view('index'));
		$this->page['html'] = $this->load_view('left_menu') . $this->load_view('index');
		//$this->page['html'] .= $this->load_view('index');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/back_end/views/catalog.css');

		return $this->page;
	}	
	
	public function action_activ(){
		$params = $this->url['params'];
		if (isset($params['id'])){
			$this->dbh->exec("UPDATE users SET status=1 WHERE id=".$params['id']);
		}
		header("location:" . SITE_URL . '/admin/realty/agents');
		exit;
	}
	
	public function action_delete(){
		$params = $this->url['params'];
		if (isset($params['id'])){
			$this->dbh->exec("DELETE FROM users WHERE id=".$params['id']);
		}
		header("location:" . SITE_URL . '/admin/realty/agents');
		exit;
	}

	public function action_agents() {
		$this->data['agents'] = $this->dbh->query("SELECT * FROM users WHERE 1");
		
		$this->page['html'] = $this->load_view('left_menu') . $this->load_view('agents');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/back_end/views/catalog.css');

		return $this->page;
	}	
	
	public function action_estactiv(){		
	
  
	
		$params = $this->url['params'];
		if (isset($params['id'])){
			$this->dbh->exec("UPDATE estate SET status=1 WHERE id=".$params['id']);
		}

		$tmp = $this->dbh->query("SELECT * FROM estate WHERE id=".$params['id']. " LIMIT 1");
		if ($tmp) {
			for ($i=1; $i<=10; $i++) if ($tmp[0]['photo'.$i]){
				$file = $tmp[0]['photo'.$i];
				$this->model->saveimg($file);
			}
		}
		
		header("location:" . SITE_URL . '/admin/realty');
		exit;		
	}

	public function action_imp(){		
		$params = $this->url['params'];
		if (isset($params['id'])){
			$this->dbh->exec("UPDATE estate SET imp=1000 WHERE id=".$params['id']);
		}
		header("location:" . SITE_URL . '/admin/realty');
		exit;		
	}

	public function action_noimp(){		
		$params = $this->url['params'];
		if (isset($params['id'])){
			$this->dbh->exec("UPDATE estate SET imp=0 WHERE id=".$params['id']);
		}
		header("location:" . SITE_URL . '/admin/realty');
		exit;		
	}

	public function action_estdelete(){		
		$params = $this->url['params'];
		if (isset($params['id'])){
		    //echo $params['id']; exit;
			$this->dbh->exec("DELETE FROM estate WHERE id=".$params['id']);
		}
		header("location:" . SITE_URL . '/admin/realty');
		exit;		
	}
	
	
/*
	public function action_estedit(){		

		$this->page['html'] = $this->load_view('left_menu') . $this->load_view('estedit');
		$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/' . $this->component_name . '/back_end/views/catalog.css');

		return $this->page;
		
	}
*/


	public function action_editx(){
		
		$this->load_helper('image');

		$params = $this->url['params'];
		$id = 0;
		if (isset($params['id'])){
			//$this->dbh->exec("UPDATE users SET status=1 WHERE id=".$params['id']);
			$id = $params['id'];
			$allx = $this->dbh->query("SELECT * FROM estate WHERE id=".$id." LIMIT 1");
			//print_r($allx);
		}
		
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
			$impo = isset($_POST['impo']) ? $_POST['impo'] : 0; 
			$action = 0; if (isset($_POST['tipob'])) $action = $_POST['tipob']; else $errs['tipob'] = 1;
			$cn = 0; if (isset($_POST['myname'])) $cn = $_POST['myname']; else $errs['myname'] = 1;
			$contact = 0; if (isset($_POST['myphone'])) $contact = $_POST['myphone']; else $errs['myphone'] = 1;
			$type=0; if (isset($_POST['tip'])) $type = $_POST['tip']; else $errs['tip'] = 1;
			$city=1; if (isset($_POST['resp1'])) $city = $_POST['resp1']; else $errs['resp1'] = 1;
			
			$district = 0;
			if (isset($city)) $districts=$this->dbh->query("SELECT * FROM es_districts WHERE id_city=".$city);
			if (!isset($districts)) {$errs['rayonx'] = 1;} 
			elseif (!empty($districts)) {
				//print_r($districts);
				foreach ($districts as $districto){
					/*if (isset($_POST['rayonx'.$districto['id']])){
						$district = $districto['id'];
						break;
					}
					*/
					if (isset($_POST['rayonx'])) if ($_POST['rayonx']==$districto['id']) $district = $districto['id'];
				}
			}
			//print_r($district);
			if ($district==0) {$errs['rayonx'] = 1;}
			
			if (isset($_POST['numroomsx'])) $numrooms = $_POST['numroomsx']; else $errs['numroomsx'] = 1;
			//print_r($_POST);
			
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
			/*
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
*/
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
			
			//if (isset($_POST['videox1'])) $videox1 = $_POST['videox1']; else $videox1 = '';
			//if (isset($_POST['videox2'])) $videox2 = $_POST['videox2']; else $videox2 = '';
			//if (isset($_POST['videox3'])) $videox3 = $_POST['videox3']; else $videox3 = '';
			$dog = isset($_POST['dog']) ? $_POST['dog'] : 0;
 			$views = 0;
			$time = time();
			//if (empty($errs)){
			if (TRUE){
//print_r('zzz'.$district);
 
				$sql = "UPDATE estate SET imp='".SQLite3::escapeString($impo)."', type_id='".SQLite3::escapeString($type)."', city_id='".SQLite3::escapeString($city)."', district_id='".SQLite3::escapeString($district)."', num_rooms_id='".SQLite3::escapeString($numrooms)."', agent_id='".SQLite3::escapeString($agent)."', price='".SQLite3::escapeString($price)."', square='".SQLite3::escapeString($square)."', description='".SQLite3::escapeString($description)."', floor='".SQLite3::escapeString($floor)."', floor_num='".SQLite3::escapeString($floor_num)."', house_type='".SQLite3::escapeString($house_type)."', street='".SQLite3::escapeString($street)."', views='".SQLite3::escapeString($views)."', contact_name='".SQLite3::escapeString($cn)."', contact_phone='".SQLite3::escapeString($contact)."',  date_edit='".SQLite3::escapeString(time())."', status='".SQLite3::escapeString($status)."', action='".SQLite3::escapeString($action)."', dog='".SQLite3::escapeString($dog)."', dm='".SQLite3::escapeString($dm)."', kv='".SQLite3::escapeString($kv)."' WHERE id=".$id;

				
				/*
			$sql = "INSERT INTO estate ('type_id', 'city_id', 'district_id', 'num_rooms_id', 'agent_id', 'price', 'square', 'description', 'floor', 'floor_num', 'house_type', 'street', 'views', 'contact_name', 'contact_phone', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'photo7', 'photo8', 'photo9', 'photo10', 'video1', 'video2', 'video3', 'date_add', 'date_edit', 'status', 'action', 'dog', 'dm', 'kv') VALUES ('".SQLite3::escapeString($type)."', '".SQLite3::escapeString($city)."', '".SQLite3::escapeString($district)."', '".SQLite3::escapeString($numrooms)."', '".SQLite3::escapeString($agent)."', '".SQLite3::escapeString($price)."', '".SQLite3::escapeString($square)."', '".SQLite3::escapeString($description)."', '".SQLite3::escapeString($floor)."', '".SQLite3::escapeString($floor_num)."', '".SQLite3::escapeString($house_type)."', '".SQLite3::escapeString($street)."', '".SQLite3::escapeString($views)."', '".SQLite3::escapeString($cn)."', '".SQLite3::escapeString($contact)."', '".SQLite3::escapeString($ph1)."', '".SQLite3::escapeString($ph2)."', '".SQLite3::escapeString($ph3)."', '".SQLite3::escapeString($ph4)."', '".SQLite3::escapeString($ph5)."', '".SQLite3::escapeString($ph6)."', '".SQLite3::escapeString($ph7)."', '".SQLite3::escapeString($ph8)."', '".SQLite3::escapeString($ph9)."', '".SQLite3::escapeString($ph10)."', '".SQLite3::escapeString($videox1)."', '".SQLite3::escapeString($videox2)."', '".SQLite3::escapeString($videox3)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($time)."', '".SQLite3::escapeString($status)."', '".SQLite3::escapeString($action)."', '" . SQLite3::escapeString($dog) . "', '" . SQLite3::escapeString($dm) . "', '" . SQLite3::escapeString($kv) . "')";*/
				$st = $this->dbh->exec($sql);

				if ($impo) {
					$imz = $this->dbh->query("SELECT * FROM estate WHERE imp<1000 AND imp>'".($impo-1)."'");
					if (!empty($imz)) {
						foreach ($imz as $imx){
							$this->dbh->exec("UPDATE estate SET imp='".($imx['imp']+1)."' WHERE id=" . $imx['id']);
						}
						/*
						echo '<pre>';
						print_r($imz);
						echo '</pre>';
						echo '<br><br><br><br>';
						*/
						$ranimps = $this->dbh->query("SELECT * FROM estate WHERE imp>0 AND imp<1000 ORDER BY imp LIMIT 10");
						$rani = 1;
						if (!empty($ranimps)) foreach ($ranimps as $ranimp){
							$this->dbh->exec("UPDATE estate SET imp='".$rani."' WHERE id=" . $ranimp['id']);
							//echo $ranimp['id'] . '---' . $ranimp['imp'] . '->' . $rani. '<br>';
							$rani++;							
						}
						/*
						echo '<br><br><br><br>';
						echo '<pre>';
						print_r($ranimps);
						echo '</pre>';
						*/
						//exit;
					}
				}

				if ($st) {
					//$_SESSION['estate_ok'] = 1;
					header("location:" . SITE_URL . '/admin/realty');
					exit;
				} else {
					$errs['base'] = 1;
				}
			} 
			
			//print_r($sql);
		}else {
				//$all = $allx;
				//print_r($allx);
				$this->data['type_id']=$allx[0]['type_id'];	$this->data['city_id']=$allx[0]['city_id'];	$this->data['district_id']=$allx[0]['district_id'];	$this->data['num_rooms_id']=$allx[0]['num_rooms_id'];	$this->data['agent_id']=$allx[0]['agent_id'];	$this->data['price']=$allx[0]['price'];	$this->data['square']=$allx[0]['square'];	$this->data['description']=$allx[0]['description'];	$this->data['floor']=$allx[0]['floor'];	$this->data['floor_num']=$allx[0]['floor_num'];	$this->data['house_type']=$allx[0]['house_type'];	$this->data['street']=$allx[0]['street'];	$this->data['views']=$allx[0]['views'];	$this->data['contact_name']=$allx[0]['contact_name'];	$this->data['video1']=$allx[0]['video1'];	$this->data['photo9']=$allx[0]['photo9'];	$this->data['video2']=$allx[0]['video2'];	$this->data['photo10']=$allx[0]['photo10'];	$this->data['photo8']=$allx[0]['photo8'];	$this->data['video3']=$allx[0]['video3'];	$this->data['contact_phone']=$allx[0]['contact_phone'];	$this->data['photo2']=$allx[0]['photo2'];	$this->data['photo1']=$allx[0]['photo1'];	$this->data['photo3']=$allx[0]['photo3'];	$this->data['photo4']=$allx[0]['photo4'];	$this->data['photo6']=$allx[0]['photo6'];	$this->data['photo5']=$allx[0]['photo5'];	$this->data['photo7']=$allx[0]['photo7'];	$this->data['date_add']=$allx[0]['date_add'];	$this->data['date_edit']=$allx[0]['date_edit'];	$this->data['status']=$allx[0]['status'];	$this->data['imp']=$allx[0]['imp'];	$this->data['action']=$allx[0]['action'];	$this->data['dog']=$allx[0]['dog'];	$this->data['dm']=$allx[0]['dm'];	$this->data['kv']=$allx[0]['kv'];
				
				$this->data['impo'] = $allx[0]['imp'];
		}
		
		$this->data['cities'] = $this->dbh->query("SELECT * FROM es_cities WHERE 1");
		
		$this->data['districts'] = 1!=0 ? $this->dbh->query("SELECT * FROM es_districts WHERE id_city=1") : array();
			
		$this->data['types'] = $this->dbh->query("SELECT * FROM es_types WHERE 1");

		$this->data['numRooms'] = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1");
		

		if (!empty($errs)) $this->data['errs'] = $errs;
		
		//$this->data['block_dirs'] = SITE_URL . "/admin/modules/components/realty";
		//header("location:" . SITE_URL . '/admin/realty');
		$this->page['html']  = $this->load_view('editx');
		
		return $this->page;		
	}
}
