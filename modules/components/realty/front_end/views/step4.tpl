<?php
	//	echo '<pre>';print_r($_POST);echo '</pre>';
/*
	if ((!isset($_POST['town']))or(!isset($_POST['adress']))or(!isset($_POST['courier']))or(!isset($_POST['payment']))) { ?>
		<div>Ошибка передачи данных.</div>
		<?php exit; ?>
	<?php } 
	$_SESSION['basker_town']=$_POST['town'];
	$_SESSION['basker_adress']=$_POST['adress'];
	$_SESSION['basker_courier']=$_POST['courier'];
	$_SESSION['basker_payment']=$_POST['payment'];
*////////////////////////////////////////////////////
?>
<div id="content">
<pre><?php 
//print_r($_SESSION); 
//unset($_SESSION['goods']); unset($_SESSION['basker']);
?>
</pre>
	<div class="moves">
		<div class="move">Шаг 1</div><div class="arrow"><hr/></div>
		<div class="move">Шаг 2</div><div class="arrow"><hr/></div>
		<div class="move">Шаг 3</div><div class="arrow"><hr/></div>
		<div class="active_move">Шаг 4</div>
		<div class="clear"></div>
	</div>
	<div class="thank-you"><p>Спасибо за покупку!</p><p>Наш менеджер свяжется с Вами.</p></div>
</div>
<script><?php include("scriptjs.php");?></script>