<?php

class model_component_realty extends model {
	
	function mailPro($mailTo, $mailFrom, $nameFrom, $subject, $text, $charset) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= "Content-type: text/html; charset=".$charset."\r\n";
		$headers .= "From: =?".$charset."?b?" . base64_encode($nameFrom) . "?=" . " <".$mailFrom.">\r\n" ;
		if(mail($mailTo,$subject,$text,$headers)) {
			return true;
		} else {
			return false;
		}
	}
	
	function getwUrl($text){
		  $signs = array(
		  'а' => 'a',   'б' => 'b',   'в' => 'v',
		  'г' => 'g',   'д' => 'd',   'е' => 'e',
		  'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		  'и' => 'i',   'й' => 'y',   'к' => 'k',
		  'л' => 'l',   'м' => 'm',   'н' => 'n',
		  'о' => 'o',   'п' => 'p',   'р' => 'r',
		  'с' => 's',   'т' => 't',   'у' => 'u',
		  'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		  'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		  'ь' => '' ,   'ы' => 'y',   'ъ' => '',
		  'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		  'А' => 'A',   'Б' => 'B',   'В' => 'V',
		  'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		  'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		  'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		  'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		  'О' => 'O',   'П' => 'P',   'Р' => 'R',
		  'С' => 'S',   'Т' => 'T',   'У' => 'U',
		  'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		  'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		  'Ь' =>  '',   'Ы' => 'Y',   'Ъ' => '',
		  'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya'
		  );
		  $str = strtr($text, $signs);
		  $str = strtolower($str);
		  $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		  $str = trim($str, "-");
		  
		  //if ($str=='') $str='wtf';
		  
		  return($str);
	}	
	
	
	function nah($table){
		$arr = $this->dbh->query("SELECT * FROM ".$table." WHERE 1");
		if (!empty($arr)) foreach ($arr as $k=>$v){
			$this->dbh->exec("UPDATE ".$table." SET enname='" . $this->getwUrl($v['name']) . "' WHERE id=".$v['id']);
		}
	}
	

	// Получение из формы строки get для переадресации. (Комментарии относятся к следующей функции)
	function get_post_to_get_params(){
			$location = '/cities/districts';
			// ГОРОД И РАЙОНЫ
			if (isset($_POST['resp'])) { // Если был отправлен город, то имеет смысл разбирать город и его районы (на самом деле он всегда отправляется, но мало ли...)
				$location="";	
				$resp = $this->dbh->query("SELECT enname FROM es_cities WHERE id=" . $_POST['resp'] . " LIMIT 1"); 
				$resp = isset($resp[0]['enname']) ? $resp[0]['enname'] : 'cities';
				//$location .= $_POST['resp'] ? "/" . (int)$_POST['resp'] : ""; // добавляем к запросу город
				$location .= "/" . $resp; // добавляем к запросу город
				$rayons = $this->dbh->query("SELECT * FROM es_districts WHERE id_city=" . (int)$_POST['resp'] . " LIMIT 100"); //Находим все районы этого города (rayons)
				//print_r($rayons);
				$this_is_first = TRUE; // Это флаг, чтобы определить, является ли район первым (если является, то добавляем "AND (" в начале, иначе - " OR " )
				if (!empty($rayons)){ //Если они есть, то нужно их добавить в запрос (естественно, если хоть один был отправлен)
					foreach ($rayons as $rayon) { // обходим все районы
						if (isset($_POST['rayon' . $rayon['id']])){ // В форме все checkbox-ы названы rayon9, rayon13, ... Это кстати id-шники районов, а не порядковые номера
							if (!$this_is_first) {$location.='+';} else {$location .= "/"; $this_is_first = FALSE;} // Здесь, если является первым районом, то добавляем "AND (" в начале и сбрасываем флаг, иначе - добавляем " OR " )
							$location .= "" . $rayon['enname']; // И сам район добавляем
						}
					}
					if (!$this_is_first) $location .= ""; //Если был хоть один район отправлен, то флаг должен был обнулиться, а значит надо закрыть скобку, иначе - нет районов, нет скобок
				}
				if ($this_is_first) $location .= "/districts";
			}			

			// ТИП ОБЪЕКТА (НОВОСТРОЙКА, КВАРТИРА, ...)
			if (isset($_POST['tip'])){
				$tip = $this->dbh->query("SELECT enname FROM es_types WHERE id=" . $_POST['tip'] . " LIMIT 1"); 
				$tip = isset($tip[0]['enname']) ? $tip[0]['enname'] : 'all';
				$location .= "/" . $tip; //(int)$_POST['tip'];
			} else {
				$location .= "/all";
			}
			
			// КОЛИЧЕСТВО КОМНАТ (аналогично районам)
			$num_rooms = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1 LIMIT 100");
			if (!empty($num_rooms)){ 
				$this_is_first = TRUE; 
				foreach ($num_rooms as $num_room) { 
					if (isset($_POST['komn' . $num_room['id']])){
						if (!$this_is_first) {$location.='+';} else {$location .= "/numrooms="; $this_is_first = FALSE;} 
						$location .= "" . $num_room['id']; 
					}
				}
				if (!$this_is_first) $location .= ""; 
			}
			
			//ЦЕНА ОТ, ДО. ПЛОЩАДЬ ОТ, ДО
			if (isset($_POST['prot'])){
				$prot = (int)$_POST['prot'];
				if ($prot!=0) $location .= "/minprice=" . $prot;
			}			

			if (isset($_POST['prdo'])){
				$prdo = (int)$_POST['prdo'];
				if ($prdo!=0) $location .= "/maxprice=" . $prdo;
			}			

			if (isset($_POST['plot'])){
				$plot = (int)$_POST['plot'];
				if ($plot!=0) $location .= "/minsquare=" . $plot;
			}			

			if (isset($_POST['pldo'])){
				$pldo = (int)$_POST['pldo'];
				if ($pldo!=0) $location .= "/maxsquare=" . $pldo;
			}			

			return $location;		
	}	

	function actions_params_to_sql($actions, $params){
			$sql = "SELECT * FROM estate WHERE status=1"; //общий запрос (на все объявления)
			if (isset($actions[0])) {
			
				if ($actions[0] != 'cities'){
					$town = $this->dbh->query("SELECT * FROM es_cities WHERE enname='" . $actions[0] . "' LIMIT 1");
					if (!isset($town[0]['id'])) return FALSE;
					$sql .= " AND city_id=" . $town[0]['id'];
					$_SESSION['block_realtySearch']['cities'][$town[0]['id']] = 1;
					if (isset($actions[1])) if ($actions[1] != 'districts'){
						$rayons = explode('+', $actions[1]);
						$this_is_first = TRUE; // Это флаг, чтобы определить, является ли район первым (если является, то добавляем "AND (" в начале, иначе - " OR " )
						foreach($rayons as $rayon){
							$ray = $this->dbh->query("SELECT * FROM es_districts WHERE enname='" . $rayon . "' LIMIT 1");
							if (isset($ray[0]['id'])) {
								if (!$this_is_first) {$sql.=' OR ';} else {$sql .= " AND ( "; $this_is_first = FALSE;} // Здесь, если является первым районом, то добавляем "AND (" в начале 							
								$sql .= "district_id=" . $ray[0]['id']; // И сам район добавляем
								$_SESSION['block_realtySearch']['districts'][$ray[0]['id']] = 1;
							}
						}
						if ($this_is_first) return FALSE;
						if (!$this_is_first) $sql .= " )"; //Если был хоть один район отправлен, то флаг должен был обнулиться, а значит надо закрыть скобку, иначе - нет районов, нет скобок
					}
					
					if (isset($actions[2])) if ($actions[2] != 'all'){
						$type = $this->dbh->query("SELECT * FROM es_types WHERE enname='" . $actions[2] . "' LIMIT 1");
						if (!isset($type[0]['id'])) return FALSE;
						$sql .= " AND type_id=" . $type[0]['id'];
						$_SESSION['block_realtySearch']['types'][$type[0]['id']] = 1;
					}
					
				}
			}

			if (isset($params['numrooms'])) {
				$this_is_first = TRUE; 
				$num_rooms = explode('+', $params['numrooms']);
				foreach ($num_rooms as $numroom) { 
					$ray = $this->dbh->query("SELECT * FROM es_num_rooms WHERE id='" . $numroom . "' LIMIT 1");
					if (isset($ray[0]['id'])) {
						if (!$this_is_first) {$sql.=' OR ';} else {$sql .= " AND ( "; $this_is_first = FALSE;} // Здесь, если является первым районом, то добавляем "AND (" в начале и 							
						$sql .= "num_rooms_id=" . $ray[0]['id']; // И сам район добавляем
						$_SESSION['block_realtySearch']['num_rooms'][$ray[0]['id']] = 1;
					}
				}
				if (!$this_is_first) $sql.=' )';  
			}
			
			if (isset($params['minprice'])){
				$prot = (int)$params['minprice'];
				if ($prot!=0) $sql .= " AND price>=" . $prot;
				$_SESSION['block_realtySearch']['minprice'] = $prot;
			}
			
			if (isset($params['maxprice'])){
				$prot = (int)$params['maxprice'];
				if ($prot!=0) $sql .= " AND price<=" . $prot;				
				$_SESSION['block_realtySearch']['maxprice'] = $prot;
			}
			
			if (isset($params['minsquare'])){
				$prot = (int)$params['minsquare'];
				if ($prot!=0) $sql .= " AND square>=" . $prot;				
				$_SESSION['block_realtySearch']['minsquare'] = $prot;
			}
			
			if (isset($params['maxsquare'])){
				$prot = (int)$params['maxsquare'];
				if ($prot!=0) $sql .= " AND square<=" . $prot;								
				$_SESSION['block_realtySearch']['maxsquare'] = $prot;
			}	
				
				
				
			$numpage = isset($params['page'])  ? (int)$params['page'] : 1;
			$start = ($numpage-1) * 20;
			if ($start<0) $start=0;
			$result_count = $this->dbh->query_count($sql);
			
			$orderby = " ORDER BY date_add DESC";
			if (isset($params['sort'])) {
				if ($params['sort']=='price') $orderby = " ORDER BY price ASC, square ASC, date_add DESC";
				elseif ($params['sort']=='square') $orderby = " ORDER BY square ASC, price ASC, date_add DESC";
			}
			$sql.=$orderby;
			
			$sql.=" LIMIT " . $start . ", 20";
			
			
			//echo $sql;
			$tickets = $this->dbh->query($sql);
			
			return array($tickets, $result_count);
	}	
	
	function array_by_id($array){
		if (empty($array)) return $array;
		$tmp = array();
		foreach ($array as $k=>$v) $tmp[$v['id']] = $v;
		return ($tmp);	
	}

	function pages_nav($n, $m, $p, $recomended=3){
		// АЛГОРИТМ ОООЧЕНЬ КРИВОЙ!!!
		//$n=17;
		$result = array();
		$arr = array();
		if ($recomended > floor($m/4)) $recomended = floor($m/4);
		$recomended = 3; //суперкостыль
		
		$dots1 = $recomended+1;
		$dots2 = $m - $recomended;
			
		if ($n<=$m) {
			for ($i=1; $i<=$n; $i++) $result[$i]=$i;
			//echo '0<br>';
			return $result;
		} 
		
		$maxnum = $n-$recomended;
		$minnum = $recomended+1;
		$num3 = $m-2*($recomended+1);
		$pos3 = floor($m/2);
		$i=$pos3;
		$j = $pos3+1;
		$k=0;
		$var1 = $p;
		$var2 = $p+1;
		while ($k<$num3){
			$var = $k%2==0 ? $var1 : $var2;
			if ($var<=$minnum){
				$result = array();
				for ($tmp=1; $tmp<$dots2; $tmp++) $result[$tmp] = $tmp;
				$result[] = '...';
				//for ($tmp=$maxnum; $tmp<$n; $tmp++) $result[] = $tmp+1;
				for ($tmp=1; $tmp<$dots1; $tmp++) $result[] = $n-$dots1+$tmp+1;
				//echo '1<br>';
				break;
			}
			elseif ($var >= $maxnum){
				$result = array();
				for ($tmp=1; $tmp<$dots1; $tmp++) $result[$tmp] = $tmp;
				$result[] = '...';
				for ($tmp=1; $tmp<$dots2; $tmp++) $result[] = $n-$dots2+$tmp+1;
				//echo '2<br>';
				break;			
			}
			else{
				if ($k%2==0) {$arr[$i]=$var1; $i--; $var1--;}
				else {$arr[$j]=$var2; $j++; $var2++;}
				$k++;
				if ($k>=$num3){
					for ($tmp=1; $tmp<$dots1; $tmp++) $result[$tmp] = $tmp;
					$result[] = '...';
					for ($tmp=$i+1; $tmp<=$j-1; $tmp++) $result[] = $arr[$tmp];
					$result[] = '...';
					for ($tmp=1; $tmp<$dots1; $tmp++) $result[] = $n-$dots1+$tmp+1;
					//echo '3<br>';
					
				}
			}
		}

		foreach ($result as $k=>$v) {
			if (isset($result[$k-1])) if(isset($result[$k+1])) if (($v=='...') and ($result[$k-1]==$result[$k+1]-2)) $result[$k] = $result[$k+1]-1;  
		}
		
		//print_r($result);
		return($result);		
	}
	
	/*
	function addimage($image){
		
		    if (isset($_FILES[$image])) if ($_FILES[$image])
			  if (($_FILES[$image]['size']<5000000)and($_FILES[$image]['name']!='')and(($_FILES[$image]['type']=='image/jpg')or($_FILES[$image]['type']=='image/jpeg')or($_FILES[$image]['type']=='image/png')or($_FILES[$image]['type']=='image/gif'))){

				$uploaddir = 'uploads/images/realty/';
				if (!file_exists($uploaddir)) mkdir($uploaddir,0777);
				$uploaddir2 = 'uploads/images/realty/mini/';
				if (!file_exists($uploaddir2)) mkdir($uploaddir2,0777);

				$fname=basename($_FILES[$image]['name']);
				$today=date("Y_m_d_G-i-s");
				$ras='';
				$newname=$fname.'-'.$today.'.jpg';
				$uploadfile = $uploaddir . $newname;
				
				if (copy($_FILES[$image]['tmp_name'], $uploadfile)) {
				  $mes=0;
				} else {
				  $mes=3;
				}
				
				$this->makeimg($uploadfile, $newname, $settings['cat']['w'], 'media/catalog/');
				return ($newname);
		   }		
		   return 
	}
	*/
	
/*	
	function post_to_sql(){
			
			$sql = "SELECT * FROM estate WHERE status=1"; //общий запрос (на все объявления)
			
			// ГОРОД И РАЙОНЫ
			if (isset($_POST['resp'])) { // Если был отправлен город, то имеет смысл разбирать город и его районы (на самом деле он всегда отправляется, но мало ли...)
				$sql .= $_POST['resp'] ? " AND city_id=" . (int)$_POST['resp'] : ""; // добавляем к запросу город
				$rayons = $this->dbh->query("SELECT * FROM es_districts WHERE id_city=" . (int)$_POST['resp'] . " LIMIT 100"); //Находим все районы этого города (rayons)
				//print_r($rayons);
				if (!empty($rayons)){ //Если они есть, то нужно их добавить в запрос (естественно, если хоть один был отправлен)
					$this_is_first = TRUE; // Это флаг, чтобы определить, является ли район первым (если является, то добавляем "AND (" в начале, иначе - " OR " )
					foreach ($rayons as $rayon) { // обходим все районы
						if (isset($_POST['rayon' . $rayon['id']])){ // В форме все checkbox-ы названы rayon9, rayon13, ... Это кстати id-шники районов, а не порядковые номера
							if (!$this_is_first) {$sql.=' OR ';} else {$sql .= " AND ( "; $this_is_first = FALSE;} // Здесь, если является первым районом, то добавляем "AND (" в начале и сбрасываем флаг, иначе - добавляем " OR " )
							$sql .= "district_id=" . $rayon['id']; // И сам район добавляем
						}
					}
					if (!$this_is_first) $sql .= " )"; //Если был хоть один район отправлен, то флаг должен был обнулиться, а значит надо закрыть скобку, иначе - нет районов, нет скобок
				}
			}
			
			// ТИП ОБЪЕКТА (НОВОСТРОЙКА, КВАРТИРА, ...)
			if (isset($_POST['tip'])){
				$sql .= " AND type_id=" . (int)$_POST['tip'];
			}
			
			// КОЛИЧЕСТВО КОМНАТ (аналогично районам)
			$num_rooms = $this->dbh->query("SELECT * FROM es_num_rooms WHERE 1 LIMIT 100");
			if (!empty($num_rooms)){ 
				$this_is_first = TRUE; 
				foreach ($num_rooms as $num_room) { 
					if (isset($_POST['komn' . $num_room['id']])){
						if (!$this_is_first) {$sql.=' OR ';} else {$sql .= " AND ( "; $this_is_first = FALSE;} 
						$sql .= "num_rooms_id=" . $num_room['id']; 
					}
				}
				if (!$this_is_first) $sql .= " )"; 
			}
			
			//ЦЕНА ОТ, ДО. ПЛОЩАДЬ ОТ, ДО
			if (isset($_POST['prot'])){
				$prot = (int)$_POST['prot'];
				if ($prot!=0) $sql .= " AND price>=" . $prot;
			}			

			if (isset($_POST['prdo'])){
				$prdo = (int)$_POST['prdo'];
				if ($prdo!=0) $sql .= " AND price<=" . $prdo;
			}			

			if (isset($_POST['plot'])){
				$plot = (int)$_POST['plot'];
				if ($plot!=0) $sql .= " AND square>=" . $plot;
			}			

			if (isset($_POST['pldo'])){
				$pldo = (int)$_POST['pldo'];
				if ($pldo!=0) $sql .= " AND square<=" . $pldo;
			}			

			return $sql;
	}
*/	
	
	
/*	
	public function get_params($main_id){
	    $db=new PDO('sqlite:db.sqlite'); 
		$sql="SELECT params FROM settings WHERE 1 LIMIT 1";
		$st=$db->query($sql);
		$ar=$st->fetch();
		$str=$ar['params'];
		$settings=unserialize($str);
		return($settings);
	}
	
	public function add_purchase(){
		if (!isset($_SESSION['purchases'])) exit;
		$pur=$_SESSION['purchases'];
		$time = time();
		$db = new PDO("sqlite:db.sqlite");
		$insert_query="INSERT INTO 'purchases' ('items', 'fio', 'phone', 'email', 'comment', 'town', 'adress', 'travel', 'pay', 'date_add') VALUES ('".serialize($pur['items'])."', '".$pur['fio']."', '".$pur['phone']."', '".$pur['email']."', '".$pur['comment']."', '".$pur['town']."', '".$pur['adress']."', '".$pur['travel']."', '".$pur['pay']."', '".$time."')";
		$ins=$db->exec($insert_query);
		return $ins;
	}
	
	public function pur_mail($pur){
		$string=$pur['fio'].' заказал:<br>';
		$db=new PDO('sqlite:db.sqlite'); 
		$sql = "SELECT params FROM settings WHERE 1"; $st = $db->query($sql); $arr = $st->fetchAll(); 
		$uns = unserialize($arr[0]['params']); $sitemail = $uns['email'];
		foreach ($pur['items'] as $key=>$num){
			$sql = "SELECT name FROM items WHERE id=".$key." LIMIT 1"; $st = $db->query($sql); $arr = $st->fetchAll();
			$itemname = empty($arr) ? 'не существует' : $arr[0]['name'];
			$string.=$itemname.' ('.$num.' шт.)<br>';
		}
		$sarr = explode('/', SITE_URL);
		//$result=$this->mailPro($sitemail, $pur['email'], $pur['fio'], "заказ товара", $string, "UTF-8");
		$result=$this->mailPro($sitemail, $sarr[2], $pur['fio'], "заказ товара", $string, "UTF-8");
	}
*/	
	
}