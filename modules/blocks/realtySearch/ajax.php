<?php
	if (!isset($_GET['city'])) {echo ''; exit;}
	if ($_GET['city']<=0) {echo ''; exit;}
	$city_id =  $_GET['city'];
	$db = new PDO("sqlite:../../../db.sqlite");
	$sql = "SELECT * FROM es_districts WHERE id_city=".$city_id;
	$st = $db->query($sql);
	$districts = $st->fetchAll();
	$str='';

	if (!empty($districts)) foreach ($districts as $district) {				   
		$str.='<input type="checkbox" name="rayon' . $district["id"].'" value="' . $district["id"] . '">' . $district['name'] . '<Br>';
	} 
	
	echo $str;
	exit;
?>