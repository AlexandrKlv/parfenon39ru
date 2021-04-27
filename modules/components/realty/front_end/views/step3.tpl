<?php
	//	echo '<pre>';print_r($_POST);echo '</pre>';
	/*
	if ((!isset($_POST['fio']))or(!isset($_POST['tel']))or(!isset($_POST['mail']))or(!isset($_POST['comment']))) { ?>
		<div>Ошибка передачи данных.</div>
		<?php exit; ?>
	<?php } 
	$_SESSION['basker_fio']=$_POST['fio'];
	$_SESSION['basker_tel']=$_POST['tel'];
	$_SESSION['basker_mail']=$_POST['mail'];
	$_SESSION['basker_comment']=$_POST['comment'];
	*/////////////////////////////////////////////////////////////////////////
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
		<div class="active_move">Шаг 3</div><div class="arrow"><hr/></div>
		<div class="move">Шаг 4</div>
		<div class="clear"></div>
	</div>
	<form method="post" class="order-form" action="<?php echo SITE_URL;?>/<?php echo $this->url['component'];?>/step4">
		<label>Город:</label><br>
		<input type="text" name="town" value="<?php echo $settings['towns'];?>" required/><br>
		<label>Адрес:</label><br>
		<input type="text" name="adress" required/><br>
		<label>Способ доставки:</label><br>
		<select name="courier">
			<?php foreach ($settings['couriers'] as $key=>$arr) if ($arr['display']==0){?>
				<option><?php echo $key;?> (<?php echo $arr['price'];?> <?php echo $settings['valuta'];?>)</option>
			<?php } ?>
		</select><br>
		<label>Способ оплаты:</label><br>
		<select name="payment">
			<?php foreach ($settings['payments'] as $key=>$arr) if ($arr['display']==0){?>
				<option><?php echo $key;?></option>
			<?php } ?>
		</select><br>
		<input type="hidden" name="shakawkaw" value="0"/>
		<input type="submit" value="Далее" class="basketbutton"/>
	<form>
</div>
<script><?php include("scriptjs.php");?></script>