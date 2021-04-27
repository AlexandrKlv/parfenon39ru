<?php
	session_start();
	if (!isset($_SESSION['basker'])){$_SESSION['basker']=time(); $_SESSION['goods']=array();}

	$act=isset($_REQUEST['act'])?$_REQUEST['act']:-1;
	if ($act<0) {echo 'exit'; exit;}
	$id=isset($_REQUEST['id'])?$_REQUEST['id']:-1;
	if ($id<0) {echo 'exit'; exit;}
	
	//здесь добавление товара в корзину	
	if ($act==0){
		//if (!isset($_SESSION['goods'][$_REQUEST['id']])) $_SESSION['goods'][$_REQUEST['id']]=1;
		//else $_SESSION['goods'][$_REQUEST['id']]=$_SESSION['goods'][$_REQUEST['id']]!=1?1:2; 	
		if (!isset($_SESSION['goods'][$_REQUEST['id']])) $_SESSION['goods'][$_REQUEST['id']]=1;
		else $_SESSION['goods'][$_REQUEST['id']]++;
		echo ($_SESSION['goods'][$_REQUEST['id']]);
	}
	elseif ($act==1){
		if (isset($_SESSION['goods'][$_REQUEST['id']])) unset($_SESSION['goods'][$_REQUEST['id']]);
		echo (count($_SESSION['goods']));
	}

?>