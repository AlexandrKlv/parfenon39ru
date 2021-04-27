	<!-- СТРАНИЦА ПОДАЧИ ОБЪЯВЛЕНИЯ -->


	<h1>Подать объявление</h1>
	<?php if (isset($_SESSION['estate_ok'])) { ?>
	<div>Ваше объявление успешно добавлено и ожидает подтверждения.</div>
		<?php unset($_SESSION['estate_ok']); } else { ?>
			<?php if (isset($errs['base'])) { ?>
				<div>Неизвестная ошибка базы.</div>
			<?php } 
			if (isset($errs)) { //print_r($errs); 
			} ?>
	<form action="" method="post" enctype="multipart/form-data">
		<div>
	
		<h3>Имя*</h3>
		<input type="text" name="myname" value="<?php if (isset($_POST['myname'])) echo $_POST['myname']; ?><?php if (isset($contact_name)) echo $contact_name;?>" required>
		</div><div>
		<h3>Телефон*</h3>
		<input type="text" name="myphone" value="<?php if (isset($_POST['myphone'])) echo $_POST['myphone']; ?><?php if (isset($contact_phone)) echo $contact_phone;?>" required>
</div>
<?php if (isset($uzver)) if ($uzver) { ?>
<div>
	<h3>Срок окончания договора*</h3>
		<input type="text" name="dog" value="<?php if (isset($_POST['dog'])) echo $_POST['dog']; ?><?php if (isset($dog)) echo $dog;?>" required>
</div>
<?php } ?>
<div>
		<h3>Тип объявления</h3>
		<select name="tipob" id="tipob">
				<option value="1" >Продам</option>
				<option value="2" >Сдам</option>			
		</select>
</div><div>		
		<h3>Тип объекта (рубрики)</h3>
		<?php if (!empty($types)) foreach ($types as $type) { ?>
		   <input type="radio" name="tip" value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?><Br>
		<?php } ?>
</div><div>		
		<h3>Расположение</h3>
		<select name="resp1" id="resp1">
			<?php if (!empty($cities)) foreach ($cities as $city) { ?>
				<option value="<?php echo $city['id']; ?>" <?php if (isset($realtyChecked['cities'][$city['id']])) { ?>selected<?php } ?>><?php echo $city['name']; ?></option>
			<?php } ?>
		</select>
</div><div>		
		<h3>Районы</h3>
		<div id="rayons2">
			<?php if (!empty($districts)) foreach ($districts as $district) { ?>
			   <input type="checkbox" name="rayonx<?php echo $district['id'];?>" value="<?php echo $district['id'];?>" <?php if (isset($realtyChecked['districts'][$district['id']])) { ?>checked<?php } ?>><?php echo $district['name'];?><Br>
			<?php } ?>
		</div>
</div><div>		
		<h3>Улица</h3>
		<input type="text" name="street" value="<?php if (isset($street)) echo $street;?>">
</div>
<div>		
		<h3>Дом</h3>
		<input type="text" name="dm" value="<?php if (isset($dm)) echo $dm;?>">
</div>
<div>		
		<h3>Квартира</h3>
		<input type="text" name="kv" value="<?php if (isset($kv)) echo $kv;?>">
</div>
<div>		
		<h3>Кол-во комнат</h3>
		<select name="numroomsx" id="numroomsx">
		<?php if (!empty($numRooms)) foreach ($numRooms as $numRoom) if ($numRoom['id']!=5) { ?>
		   <!--input type="checkbox" name="komn<?php echo $numRoom['id'];?>" value="<?php echo $numRoom['id'];?>" <?php if (isset($realtyChecked['num_rooms'][$numRoom['id']])) { ?>checked<?php } ?>><?php echo $numRoom['name'];?><Br-->
				<option value="<?php echo $numRoom['id'];?>"><?php echo $numRoom['name'];?></option>
		<?php } ?>
		</select>
</div><div>		
		<h3>Тип дома</h3>
		<select name="tpd" id="tpd">
				<option value="1" >Панельный</option>
				<option value="2" >Кирпичный</option>			
				<option value="3" >Монолитный</option>			
		</select>
</div><div>
		<h3>Этаж</h3>
		<input type="text" name="etazh" value="<?php if (isset($_POST['etazh'])) echo $_POST['etazh']; ?><?php if (isset($floor)) echo $floor;?>">
		<h3>Этажей в доме</h3>
		<input type="text" name="etazhey" value="<?php if (isset($_POST['etazhey'])) echo $_POST['etazhey']; ?><?php if (isset($floor_num)) echo $floor_num;?>">
</div><div>
		<h3>Цена, руб</h3>
		<input type="text" name="pricex" value="<?php if (isset($_POST['pricex'])) echo $_POST['pricex']; ?><?php if (isset($price)) echo $price;?>">
		<h3>Площадь, м<sup>2</sup></h3>
		<input type="text" name="squarex" value="<?php if (isset($_POST['squarex'])) echo $_POST['squarex']; ?><?php if (isset($square)) echo $square;?>">
</div><div>
		<h3>Подробности</h3>
		<textarea name="descx"><?php if (isset($_POST['descx'])) echo $_POST['descx']; ?><?php if (isset($description)) echo $description;?></textarea><br>
</div><div>
		<h3>Фото: (не более 5Мб)</h3>
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
</div><div>		
		<h3>Ссылки на видео</h3>
		<div id="videoss">
			<textarea id="videox1" name="videox1"><?php if (isset($_POST['videox1'])) echo $_POST['videox1']; ?><?php if (isset($video1)) echo $video1;?></textarea><br>
			<textarea id="videox2" name="videox2"><?php if (isset($_POST['videox2'])) echo $_POST['videox2']; ?><?php if (isset($video2)) echo $video2;?></textarea><br>
			<textarea id="videox3" name="videox3"><?php if (isset($_POST['videox3'])) echo $_POST['videox3']; ?><?php if (isset($video3)) echo $video3;?></textarea><br>
		</div>
</div><div>		
		<input type="submit" name="submit" value="добавить">	
</div>		

	</form>
	<?php } ?>