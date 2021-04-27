<!-- Подача объявления ПРОВЕРЕННАЯ -->
<div id="content" class="container alls row main-form" style="background:#33824E; margin-top: 20px; border-radius: 10px; margin-bottom: 20px;">
	<div class="sss">
		<h1>Подать объявление</h1>
		<?php if (isset($_SESSION['estate_ok'])) { ?>
		<div>Ваше объявление успешно добавлено и будет активировано на сайте после подтверждения модератором.</div>
		<?php unset($_SESSION['estate_ok']); } else { ?>
		<?php if (isset($really_errs)) if(!empty($really_errs)) { ?>
		<div><b>Ошибка в заполнении полей.</b></div>
		<?php } 
		if (isset($really_errs)) { 
		//print_r($really_errs); 
	} ?>
	



	<form action="" class="h-100 w-100" method="post" enctype="multipart/form-data" onsubmit="return checkSize(5242880)">
		<div>
			<label for="name" class="cols-sm-2 control-label">Имя:</label>
			<div class="cols-sm-10">
         		<div class="input-group">
           		<input type="text" class="form-control" placeholder="Введите ваше имя" name="myname" value="<?php if (isset($_POST['myname'])) echo $_POST['myname']; ?>" required><?php if (isset($really_errs['myname'])) { ?> <b style="color:red">заполнено неверно</b><?php } ?>
         		</div>
      		 </div>
			
		</div>
		<div>
			<label for="name" class="cols-sm-2 control-label">Телефон:</label>
			<div class="input-group">
         
			<input type="text" name="myphone" placeholder="Введите номер вашего телефона" class="form-control" value="<?php if (isset($_POST['myphone'])) echo $_POST['myphone']; ?>" required><?php if (isset($really_errs['myphone'])) { ?> <b style="color:red">заполнено неверно</b><?php } ?>
		</div>
		</div>
		<?php if (isset($uzver)) if ($uzver) { ?>
		<div>
			<h3>Срок окончания договора</h3>
			<input type="text" class="form-control" name="dog" value="<?php if (isset($_POST['dog'])) echo $_POST['dog']; else echo ''; ?>">
		</div>
		<?php } ?>
		<div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Выберите тип объявления
      </button>
      <div class="dropdown-menu w-100 text-center" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" >Продам</a>
        <a class="dropdown-item" <?php if (isset($_POST['tipob'])) if ($_POST['tipob']==2) { ?>selected<?php } ?>>Сдам</a>
      </div>
    </div>
		<!-- <div class="dropdown">
			<h3>Тип объявления</h3>
			<select name="tipob" id="tipob">
				<option value="1" >Продам</option>
				<option value="2" <?php if (isset($_POST['tipob'])) if ($_POST['tipob']==2) { ?>selected<?php } ?>>Сдам</option>			
			</select>
		</div> -->
		<div class="form-check">		
			<h3>Тип объекта (рубрики)</h3>
			<?php $xxx=0; ?>
			<?php if (!empty($types)) foreach ($types as $type) { ?>
			<input type="radio" class="form-check-input" name="tip" value="<?php echo $type['id']; ?>" <?php if (isset($_POST['tip'])) { if ($_POST['tip']==$type['id']) { ?>checked<?php } } elseif ($xxx==0) { $xxx=1; ?>checked<?php } ?>><?php echo $type['name']; ?><Br>
			<?php } ?>
		</div><div class="form-check">		
			<h3>Расположение</h3>
			<select class="form-control" name="resp1" id="resp1">
				<?php if (!empty($cities)) foreach ($cities as $city) { ?>
				<option class="form-check-input" value="<?php echo $city['id']; ?>" <?php if (isset($realtyChecked['cities'][$city['id']])) { ?>selected<?php } ?>><?php echo $city['name']; ?></option>
				<?php } ?>
			</select>
		</div><div class="form-check">		
			<h3>Районы</h3>
			<div id="rayons2">
				<?php if (!empty($districts)) foreach ($districts as $district) { ?>

				<input class="form-check-input" type="radio" name="rayonx" value="<?php echo $district['id']; ?>" <?php if (isset($district_id)) if ($district_id==$district['id']) { ?>checked<?php  } ?>><?php echo $district['name']; ?><Br>

				<?php } ?>
			<!-- </div>
		h3>Районы</h3>
		<div id="rayons2">
			<?php if (!empty($districts)) foreach ($districts as $district) { ?>
			   <input type="checkbox" name="rayonx<?php echo $district['id'];?>" value="<?php echo $district['id'];?>" <?php if (isset($realtyChecked['districts'][$district['id']])) { ?>checked<?php } ?>><?php echo $district['name'];?><Br>
			<?php } ?>
		</div
	</div> -->
	<div class="form-group">		
		<h3>Улица</h3>
		<input type="text" class="form-control" placeholder="Введите название улицы" name="street" value="<?php if (isset($_POST['street'])) echo $_POST['street']; ?>"><?php if (isset($really_errs['street'])) { ?> <b style="color:red">заполнено неверно</b><?php } ?>
	</div>
	<div>		
		<h3>Дом</h3>
		<input type="text" name="dm" class="form-control" placeholder="Введите номер дома" value="<?php if (isset($_POST['dm'])) echo $_POST['dm']; ?>">
	</div>
	<div class="form-group"> 		
		<h3>Квартира (не обязательно)</h3>
		<input type="text" class="form-control" name="kv" placeholder="Введите номер квартиры" value="<?php if (isset($_POST['kv'])) echo $_POST['kv']; ?>">
	</div>
	<div>		
		<h3>Кол-во комнат</h3>
		<select class="custom-select" name="numroomsx" id="numroomsx">
			<?php if (!empty($numRooms)) foreach ($numRooms as $numRoom) if ($numRoom['id']!=5) { ?>
			<!--input type="checkbox" name="komn<?php echo $numRoom['id'];?>" value="<?php echo $numRoom['id'];?>" <?php if (isset($realtyChecked['num_rooms'][$numRoom['id']])) { ?>checked<?php } ?>><?php echo $numRoom['name'];?><Br-->
			<option value="<?php echo $numRoom['id'];?>" <?php if (isset($_POST['numroomsx'])) if ($_POST['numroomsx']==$numRoom['id']) { ?>selected<?php } ?>><?php echo $numRoom['name'];?></option>
			<?php } ?>
		</select>
	</div><div>		
		<h3>Тип дома</h3>
		<select class="custom-select" name="tpd" id="tpd">
			<option value="1" <?php if (isset($_POST['tpd'])) if ($_POST['tpd']==1) { ?>selected<?php } ?>>Панельный</option>
			<option value="2" <?php if (isset($_POST['tpd'])) if ($_POST['tpd']==2) { ?>selected<?php } ?> >Кирпичный</option>			
			<option value="3"  <?php if (isset($_POST['tpd'])) if ($_POST['tpd']==3) { ?>selected<?php } ?>>Монолитный</option>			
		</select>
	</div><div>
		<h3>Этаж</h3>
		<input type="text" class="form-control" name="etazh" value="<?php if (isset($_POST['etazh'])) echo $_POST['etazh']; ?>"><?php if (isset($really_errs['etazh'])) { ?> <span style="color:red;">не заполнено</span><?php } ?><BR><BR>
		<h3>Этажей в доме</h3>
		<input type="text" class="form-control" name="etazhey" value="<?php if (isset($_POST['etazhey'])) echo $_POST['etazhey']; ?>"><?php if (isset($really_errs['etazhey'])) { ?> <span style="color:red;">не заполнено</span><?php } ?><BR><BR>
	</div><div>
		<h3>Цена, руб</h3>
		<input type="text" class="form-control" name="pricex" value="<?php if (isset($_POST['pricex'])) echo $_POST['pricex']; ?>"><?php if (isset($really_errs['pricex'])) { ?> <span style="color:red;">не заполнено</span><?php } ?><BR><BR>
		<h3>Площадь, м<sup>2</sup></h3>
		<input type="text" name="squarex" class="form-control" value="<?php if (isset($_POST['squarex'])) echo $_POST['squarex']; ?>"><?php if (isset($really_errs['squarex'])) { ?> <span style="color:red;">не заполнено</span><?php } ?><BR><BR>
	</div><div>
		<h3>Подробности</h3>
		<textarea name="descx" class="form-control"><?php if (isset($_POST['descx'])) echo $_POST['descx']; ?></textarea><br>
	</div><div>
		<h3>Фото: (не более 5Мб на фото)</h3>
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
			<textarea id="videox1" name="videox1"><?php if (isset($_POST['videox1'])) echo $_POST['videox1']; ?></textarea><br>
			<!--textarea id="videox2" name="videox2"><?php if (isset($_POST['videox2'])) echo $_POST['videox2']; ?></textarea><br>
				<textarea id="videox3" name="videox3"><?php if (isset($_POST['videox3'])) echo $_POST['videox3']; ?></textarea><br-->
			</div>
			<h3>Введите код</h3><?php if (isset($really_errs['capcha'])) { ?> <b style="color:red">заполнено неверно</b><?php } ?>
			<div style="width:130px; float:left;">
				<img src="<?php echo $src_captcha; ?>" width="130px" height="30px" align="right">
			</div>
			<div style="width:130px; float:left;">
				<input style="margin-left:15px; height:27px; min-width:110px !important; max-width:110px !important;" class="inputcapcha" id="inputcapcha" name="captchasuf" type="text">
			</div>
			<div style="clear:both;"></div>
		</div>
		<br>
		<div id="subadd" class="form-group regbtn">		
			<input class="form-control" type="submit" name="submit" value="добавить">	
		</div>		

	</form>
	<?php } ?>
</div>	
</div>

<script type="text/javascript">

	$("#resp1").change(function(){
						//alert(imgnum);
						//alert($( "#resp option:selected" ).text());
						//alert($( "#resp option:selected" ).val());
						$.ajax({
							url: '<?php echo $block_dirs;?>/ajax.php?city='+$( "#resp1 option:selected" ).val(),
							success: function(data){
								$("#rayons2").toggle(400, function(){
									$("#rayons2").html(data);
									$("#rayons2").toggle(400);
								});
							}
						});
					});

	imgnum = 1;

	$("#image" + imgnum).change(function(){
		if (imgnum<10){

							/*
							document.getElementById("imgss").innerHTML = '<div>'+document.getElementById("image"+imgnum).value+'</div>' + document.getElementById("imgss").innerHTML;
							imgn = imgnum + 1;
							document.getElementById("image"+imgnum).outerHTML = '<input id="image'+imgn+'" type="file" name="image'+imgn+'" accept="image/jpg,image/jpeg,image/png,image/gif">';
							//document.getElementById("image"+imgnum).name = "image" + imgn;
							imgnum++;
							
							//alert(imgnum);
							
							//alert(2);
							//alert(document.getElementById("image"+imgnum).value);
							//imgnum++;
							//document.getElementById("imgss").innerHTML = '<img style="max-width:100px; max-height:100px;"src="'+document.getElementById("image"+imgnum).value+'" alt=""><br>';
							//alert('<input id="image'+imgnum+'" type="file" name="image'+imgnum+'" accept="image/jpg,image/jpeg,image/png,image/gif"><br>');
							//alert(imgnum);
							//document.getElementById("imgss").innerHTML+='<input id="image'+imgnum+'" type="file" name="image'+imgnum+'" accept="image/jpg,image/jpeg,image/png,image/gif"><br>';
							
							*/
						}
					});

				</script>
				
				<script type="text/javascript">
					function checkSize(max_img_size)
					{
						myyiflag = 0;
						for (myyi=1; myyi<11; myyi++) {
							tmpinput = document.getElementById("image"+myyi);
    // check for browser support (may need to be modified)
    if(tmpinput.files && tmpinput.files.length == 1)
    {           
    	if (tmpinput.files[0].size > max_img_size) 
    	{
            //alert("The file must be less than " + (max_img_size/1024/1024) + "MB");
            //return false;
            myyiflag = myyi;
        }
    }

}
if (myyiflag!=0){
	alert("Размер файла №"+myyiflag+" должен быть меньше, чем " + (max_img_size/1024/1024) + "MB");
	return false;
}
return true;
}
</script>		

<style>
.form-group{
	margin-bottom: 15px;
}
label{
	margin-bottom: 15px;
}
input,
input::-webkit-input-placeholder {
	font-size: 11px;
	padding-top: 3px;
}
.form-control {
	height: auto!important;
	padding: 8px 12px !important;
}
.input-group {
	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.21)!important;
}
#button {
	border: 1px solid #ccc;
	margin-top: 28px;
	padding: 6px 12px;
	color: #666;
	text-shadow: 0 1px #fff;
	cursor: pointer;
	border-radius: 3px 3px;
	box-shadow: 0 1px #fff inset, 0 1px #ddd;
	background: #f5f5f5;
	background: -moz-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f5f5f5), color-stop(100%, #eeeeee));
	background: -webkit-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
	background: -o-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
	background: -ms-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
	background: linear-gradient(top, #f5f5f5 0%, #eeeeee 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5', endColorstr='#eeeeee', GradientType=0);
}
.main-form{
	margin-top: 30px;
	margin: 0 auto;
	max-width: 400px;
	padding: 10px 40px;
	background: #ecbb8c;
	color: #FFF;
	text-shadow: none;
	box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.31);
}
span.input-group-addon i {
	color: #009edf;
	font-size: 17px;
}
.login-button{
	margin-top: 5px;
}
.regbtn {
	background-color: #f8f9fa;
} 

.regbtn:hover {
	background-color: #4bef70;
}
</style>		