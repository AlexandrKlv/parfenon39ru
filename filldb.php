<?php
set_time_limit(0);
date_default_timezone_set('Europe/Kaliningrad');

function mescape($string)
{
  return SQLite3::escapeString($string);
}
	$db = new PDO("sqlite:db.sqlite");
	$db->exec("DELETE FROM estate WHERE id<3017");
	exit;
	//$db->exec("DELETE FROM estate WHERE 1");

	for ($i=1; $i<=10; $i++){
		$j = $i>5 ? 11-$i: $i;
		$db->exec("UPDATE estate SET photo".$i."='test".$j.".jpg' WHERE 1");
	}

	/*
	for ($i=0; $i<100; $i++){
		$rand = rand(0,1);
		echo $rand;
		
	}
	*/
	
//$db->exec("UPDATE estate SET num_rooms_id=3 WHERE (num_rooms_id<3 OR num_rooms_id>4) AND (type_id=2 OR type_id=4) ");
exit;	
	
for ($iii=0; $iii<900; $iii++){	
	$city = rand(1, 4);
	
	$tmp = $db->query("SELECT * FROM es_districts WHERE id_city=" . $city); 
	$districts =  $tmp->fetchAll();
	$rand = rand(0, count($districts)-1);

	$district = $districts[$rand]['id'];

	//echo $district;
	
	$type = rand(1, 5);
	$tmp = $db->query("SELECT * FROM es_types WHERE id=" . $type . " LIMIT 1"); 
	$type_name = $tmp->fetchAll();
	$type_name = $type_name[0]['name'];
	
	$numrooms = rand(1, 8);
	
	$agent = rand(1,9);
	
	$price = rand(700000, 4000000);
	$price = $price-$price%10000;
	
	$square = rand(80, 300);
	
	$prod = rand(1, 3);
	if ($prod==1) $prod = 'Продам срочно: ';
	elseif ($prod==2) $prod = 'Продается: ';
	elseif ($prod==3) $prod = '';
	
	
	$description = $prod . '<b>' . $type_name . '</b>.' . ' И краткое описание предлагаемой недвижимости. И краткое описание предлагаемой недвижимости. И краткое описание предлагаемой недвижимости. ';

	$floor_num = rand(1, 10);
	$floor = rand(0, $floor_num);
	
	$views = 0;
	
	$cn = rand(0 , 7);
	if ($cn == 0) $cn = 'Иван';
	elseif ($cn == 1) $cn = 'Павел';
	elseif ($cn == 2) $cn = 'Дарья';
	elseif ($cn == 3) $cn = 'Виктория';
	elseif ($cn == 4) $cn = 'Михаил';
	elseif ($cn == 5) $cn = 'Валерия';
	elseif ($cn == 6) $cn = 'Константин';
	elseif ($cn == 7) $cn = 'Максим';
		
	$ph = rand(1,5);
	$ph='test'.$ph.'.jpg';
	
	$time = rand(1430788026, 1443288026);
	//echo time();
	
	$status = rand(0, 25);
	if ($status==0) $status=0;
	elseif ($status==2) $status=2;
	elseif ($status==3) $status=3;
	elseif ($status==4) $status=4;
	elseif ($status==5) $status=4;
	elseif ($status==6) $status=3;
	else ($status=1);
	
	$house_type = rand(1,5);

	$street = 'Название улицы, номер дома и квартиры и, может быть, город. Свободное описание адреса, составляемое пользователем';
	
	$contact = '+7911';
	for ($i=0; $i<8; $i++) $contact=$contact . rand(0,9);
	
	$sql = "INSERT INTO estate ('type_id', 'city_id', 'district_id', 'num_rooms_id', 'agent_id', 'price', 'square', 'description', 'floor', 'floor_num', 'house_type', 'street', 'views', 'contact_name', 'contact_phone', 'photo1',  'date_add', 'date_edit', 'status') VALUES ('".mescape($type)."', '".mescape($city)."', '".mescape($district)."', '".mescape($numrooms)."', '".mescape($agent)."', '".mescape($price)."', '".mescape($square)."', '".mescape($description)."', '".mescape($floor)."', '".mescape($floor_num)."', '".mescape($house_type)."', '".mescape($street)."', '".mescape($views)."', '".mescape($cn)."', '".mescape($contact)."', '".mescape($ph)."', '".mescape($time)."', '".mescape($time+rand(0, 200000))."', '".mescape($status)."')";
	
	//echo $sql;
	$db->exec($sql);
}
?>