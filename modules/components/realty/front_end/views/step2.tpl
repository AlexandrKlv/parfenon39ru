<div id="content">
<pre><?php 
//print_r($_SESSION); 
//unset($_SESSION['goods']); unset($_SESSION['basker']);
?>
</pre>
	<div class="moves">
		<div class="move">Шаг 1</div><div class="arrow"><hr/></div>
		<div class="active_move">Шаг 2</div><div class="arrow"><hr/></div>
		<div class="move">Шаг 3</div><div class="arrow"><hr/></div>
		<div class="move">Шаг 4</div>
		<div class="clear"></div>
	</div>
	<form method="post" class="order-form" action="<?php echo SITE_URL;?>/<?php echo $this->url['component'];?>/step3">
		<label>Фамилия Имя Отчество:</label><br>
		<input type="text" name="fio" <?php if ($settings['fields']['Фамилия_Имя_Отчество']['required']==0) {?>required<?php } ?>/><br>
		<label>Телефон:</label><br>
		<input type="text" name="tel" <?php if ($settings['fields']['Телефон']['required']==0) {?>required<?php } ?>/><br>
		<label>Email:</label><br>
		<input type="text" name="mail" <?php if ($settings['fields']['Email']['required']==0) {?>required<?php } ?>/><br>
		<label>Комментарий:</label><br>
		<textarea name="comment"></textarea><br>
		<input type="hidden" name="shakawkaw" value="0"/>
		<input type="submit" value="Далее" class="basketbutton"/>
	<form>
</div>
<script><?php include("scriptjs.php");?></script>