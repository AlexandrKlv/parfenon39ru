<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<?php $error=0; $msg=0;?>
	<?php if($error!=0) { ?>
	<div class="notice error">
		<p><?php echo $msg; ?></p>
	</div>
	<?php }
	 elseif($msg) { ?>
	<div class="notice success">
		<p><?php echo $msg; ?></p>
	</div>
	<?php } ?>

	<form action="" method="post">
	<h4>Город по умолчанию:</h4>
	<input type="text" name="town" value="<?php echo $settings['towns'];?>"/><br>
	<h4>Обязательные поля в шаге 2:</h4>
	<?php foreach($settings['fields'] as $key=>$arr){?>
		<input type="checkbox" name="<?php echo $key;?>_required" <?php if ($arr['required']==0) { ?>checked<?php } ?>/><?php echo $key; ?><br>
	<?php } ?>
	<h4>Способы доставки:</h4>
	<?php foreach($settings['couriers'] as $key=>$arr){?>
		<div style="float:left;"><input type="checkbox" name="<?php echo $key;?>_display" <?php if ($arr['display']==0) { ?>checked<?php } ?>/><?php echo $key; ?> , цена</div><div style="margin-left:170px;"><input style="width:100px;" type="text" name="<?php echo $key;?>_price" value="<?php echo $arr['price'];?>"/></div><div class="clear"></div>
	<?php } ?>
	<h4>Способы оплаты:</h4>
	<?php foreach($settings['payments'] as $key=>$arr){?>
		<input type="checkbox" name="<?php echo $key;?>_display" <?php if ($arr['display']==0) { ?>checked<?php } ?>/><?php echo $key; ?><br>	
	<?php } ?>
	<h4>SMS уведомления:</h4>
	<input type="radio" name="sms" value="0" <?php if ($settings['sms']==0) { ?>checked<?php } ?>> да, 
	<input type="radio" name="sms" value="1" <?php if ($settings['sms']!=0) { ?>checked<?php } ?>> нет<br>
	<h4>SMS шлюз:</h4>
	<?php foreach($settings['sms_gate'] as $key=>$arr){?>
		<input type="checkbox" name="<?php echo $key;?>_display" <?php if ($arr['display']==0) { ?>checked<?php } ?>/><?php echo $key; ?><br>	
	<?php } ?>
	<h4>Валюта:</h4>
	<input type="text" name="valuta" style="width:100px;" value="<?php echo $settings['valuta'];?>"><br>
	<h4>Ширина и высота изображения категории (превью)</h4>
	<input type="text" name="cat_w" style="width:50px;" value="<?php echo $settings['cat']['w'];?>">x<input type="text" name="cat_h" style="width:50px;" value="<?php echo $settings['cat']['h'];?>"> px
	<h4>Ширина и высота изображения товара</h4>
	<input type="text" name="item_mini_w" style="width:50px;" value="<?php echo $settings['item']['mini']['w'];?>">x<input type="text" name="item_mini_h" style="width:50px;" value="<?php echo $settings['item']['mini']['h'];?>"> px - превью (mini)<br>
	<input type="text" name="item_big_w" style="width:50px;" value="<?php echo $settings['item']['big']['w'];?>">x<input type="text" name="item_big_h" style="width:50px;" value="<?php echo $settings['item']['big']['h'];?>"> px - полный размер<br>
	<h4>Показывать цену:</h4>
	<input type="radio" name="show_price" value="0" <?php if ($settings['show_price']==0) { ?>checked<?php } ?>> да, 
	<input type="radio" name="show_price" value="1" <?php if ($settings['show_price']!=0) { ?>checked<?php } ?>> нет<br>
	<h4>Показывать корзину:</h4>
	<input type="radio" name="show_basket" value="0" <?php if ($settings['show_basket']==0) { ?>checked<?php } ?>> да, 
	<input type="radio" name="show_basket" value="1" <?php if ($settings['show_basket']!=0) { ?>checked<?php } ?>> нет<br>
	<h4>Выводить категории:</h4>
	<input type="radio" name="categories" value="1" <?php if ($settings['categories']==1) { ?>checked<?php } ?>>Первого уровня<br> 
	<input type="radio" name="categories" value="2" <?php if ($settings['categories']==2) { ?>checked<?php } ?>>Первого и второго уровней<br>
	<input type="radio" name="categories" value="3" <?php if ($settings['categories']==3) { ?>checked<?php } ?>>3 уровня<br> 
	<input type="radio" name="categories" value="4" <?php if ($settings['categories']==4) { ?>checked<?php } ?>>4 уровня<br>
	<input type="radio" name="categories" value="5" <?php if ($settings['categories']==5) { ?>checked<?php } ?>>5 уровней<br> 
	<h4>email (для уведомлений):</h4>
	<input type="text" name="email" style="" value="<?php echo $settings['email'];?>"/><br/>
	<p class="buttons" style="text-align:left;"><input type="submit" name="submit_settings" value="Применить"></p>
	</form>
</div>