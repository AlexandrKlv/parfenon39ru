<div id="content">
	<h1>Изменить объявление</h1>
	<?php if (isset($_SESSION['estate_ok'])) { ?>
	<div>Ваше объявление успешно добавлено и ожидает подтверждения.</div>
		<?php unset($_SESSION['estate_ok']); } else { ?>
		<?php if (isset($errs['base'])) { ?>
			<div>Неизвестная ошибка базы.</div>
		<?php } 
		if (isset($errs)) { print_r($errs); }?>
	<form action="" method="post" enctype="multipart/form-data">
		<h4>Имя*</h4>
		<input type="text" name="myname" value="<?php if (isset($_POST['myname'])) echo $_POST['myname']; ?>" required>
		<h4>Телефон*</h4>
		<input type="text" name="myphone" value="<?php if (isset($_POST['myphone'])) echo $_POST['myphone']; ?>" required>

		<h4>Тип объявления</h4>
		<select name="tipob" id="tipob">
				<option value="1" >Продам</option>
				<option value="2" >Сдам</option>			
		</select>
	
		<h4>Тип объекта (рубрики)</h4>
		<?php if (!empty($types)) foreach ($types as $type) { ?>
		   <input type="radio" name="tip" value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?><Br>
		<?php } ?>

		<h4>Расположение</h4>
		<select name="resp1" id="resp1">
			<?php if (!empty($cities)) foreach ($cities as $city) { ?>
				<option value="<?php echo $city['id']; ?>" <?php if (isset($realtyChecked['cities'][$city['id']])) { ?>selected<?php } ?>><?php echo $city['name']; ?></option>
			<?php } ?>
		</select>
		
		<h4>Районы</h4>
		<div id="rayons2">
			<?php if (!empty($districts)) foreach ($districts as $district) { ?>
			   <input type="checkbox" name="rayonx<?php echo $district['id'];?>" value="<?php echo $district['id'];?>" <?php if (isset($realtyChecked['districts'][$district['id']])) { ?>checked<?php } ?>><?php echo $district['name'];?><Br>
			<?php } ?>
		</div>
		
		<h4>Улица</h4>
		<input type="text" name="street">
		
		<h4>Кол-во комнат</h4>
		<select name="numroomsx" id="numroomsx">
		<?php if (!empty($numRooms)) foreach ($numRooms as $numRoom) if ($numRoom['id']!=5) { ?>
		   <!--input type="checkbox" name="komn<?php echo $numRoom['id'];?>" value="<?php echo $numRoom['id'];?>" <?php if (isset($realtyChecked['num_rooms'][$numRoom['id']])) { ?>checked<?php } ?>><?php echo $numRoom['name'];?><Br-->
				<option value="<?php echo $numRoom['id'];?>"><?php echo $numRoom['name'];?></option>
		<?php } ?>
		</select>
		
		<h4>Тип дома</h4>
		<select name="tpd" id="tpd">
				<option value="1" >Панельный</option>
				<option value="2" >Кирпичный</option>			
				<option value="3" >Монолитный</option>			
		</select>

		<h4>Этаж</h4>
		<input type="text" name="etazh" value="<?php if (isset($_POST['etazh'])) echo $_POST['etazh']; ?>">
		<h4>Этажей в доме</h4>
		<input type="text" name="etazhey" value="<?php if (isset($_POST['etazhey'])) echo $_POST['etazhey']; ?>">

		<h4>Цена, руб</h4>
		<input type="text" name="pricex" value="<?php if (isset($_POST['pricex'])) echo $_POST['pricex']; ?>">
		<h4>Площадь, м<sup>2</sup></h4>
		<input type="text" name="squarex" value="<?php if (isset($_POST['squarex'])) echo $_POST['squarex']; ?>">

		<h4>Подробности</h4>
		<textarea name="descx"><?php if (isset($_POST['descx'])) echo $_POST['descx']; ?></textarea><br>

		<h4>Фото: (не более 5Мб)</h4>
		<div id="imgss">
			1. <input id="image1" type="file" name="image1" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			2. <input id="image2" type="file" name="image2" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			3. <input id="image3" type="file" name="image3" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			4. <input id="image4" type="file" name="image4" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			5. <input id="image5" type="file" name="image5" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			6. <input id="image6" type="file" name="image6" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			7. <input id="image7" type="file" name="image7" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			8. <input id="image8" type="file" name="image8" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			9. <input id="image9" type="file" name="image9" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
			10. <input id="image10" type="file" name="image10" accept="image/jpg,image/jpeg,image/png,image/gif"><br>
		</div>
		
		<h4>Ссылки на видео</h4>
		<div id="videoss">
			<textarea id="videox1" name="videox1"><?php if (isset($_POST['videox1'])) echo $_POST['videox1']; ?></textarea><br>
			<textarea id="videox2" name="videox2"><?php if (isset($_POST['videox2'])) echo $_POST['videox2']; ?></textarea><br>
			<textarea id="videox3" name="videox3"><?php if (isset($_POST['videox3'])) echo $_POST['videox3']; ?></textarea><br>
		</div>
		
		
		
		<input type="submit" name="submit" value="изменить">	
		

	</form>
	<?php } ?>
	
</div>