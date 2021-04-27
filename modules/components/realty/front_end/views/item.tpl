<div id="content"><?php $kostyl = 1; ?>
	<!--div class="categories_announce"-->
	<!--хлебные крошки-->
	<style type="text/css">
	.fancybox-nav span {
		position: absolute;
		top: 50%;
		width: 36px;
		height: 34px;
		margin-top: -18px;
		cursor: pointer;
		z-index: 8040;
		visibility: visible !important;
	}
</style>

<?php if ($item) { ?><h1>Объявление (<?php echo $item['id']; ?>)</h1><?php } ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<p id="thrumbnails">
			<a href="/">Главная</a> &gt;&gt; Недвижимость
		</p>
	</li>
</ol>


<div class="row">

	<div class="col-lg-6 col-md-8 col-12">

		<?php if ($item) { 	
		$img = (trim($item['photo1'])!=='') ? $item['photo1'] : '_no_image'; 
		$bg_img = 'bg_com.png';
		if ($item['type_id']==1) $bg_img = 'bg_flat.png';
		elseif ($item['type_id']==2) $bg_img = 'bg_dom.png';
		elseif ($item['type_id']==3) $bg_img = 'bg_nov.png';
		elseif ($item['type_id']==4) $bg_img = 'bg_gar.png';
		?>
		<div class="estate" style="background: white url(/themes/theme_1.0/img/<?php echo $bg_img; ?>) right bottom no-repeat;  padding-top:15px;">
			<div class="estateImgContBig"> <!--style="width:64%;"-->
				<?php if ($img!='_no_image') { ?>
				<a class="fancybox" rel="gallery" href="/uploads/images/realty/<?php echo $img;?>" title=""><div class="estateImg"><img style="width:100%; max-height: 400px;" src="/uploads/images/realty/<?php echo $img; ?>" /></div></a>


				<div id="gallery-box">
					<?php for ($im=1; $im<=10; $im++) if ($item['photo'.$im]) { ?>
					<div style="float:left;">
						<a class="fancybox" rel="gallery" href="/uploads/images/realty/<?php echo $item['photo'.$im];?>" title="">
							<img style="max-width:50px; max-height:50px;   box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5); margin:5px;" src="/uploads/images/realty/mini/<?php echo $item['photo'.$im];?>">
						</a>
					</div>
					<?php } ?>
					<div style="clear:both;"></div>

				</div>
				<?php } else { ?>

				<div class="estateImg"><img src="/themes/theme_1.0/img/no_imgs.jpg" /></div>

				<?php } ?>
				<?php for ($im=1; $im<=3; $im++) if ($item['video'.$im]) { ?>
				<?php 
				$tmpv = explode('src="', $item['video'.$im]); 
				if (isset($tmpv[1])) {
				//echo $tmpv[1];
				$tmpv = $tmpv[1];
				$tmpv = explode('"', $tmpv);
				//print_r($tmpv);
				$tmpx = $tmpv[0];
				//echo $tmpv[0];
			}
			//echo $item['video' . $im]; 
			?>
			<?php if (TRUE) if(isset($tmpx)) { ?><iframe width="310" height="174" src="<?php echo $tmpv[0]; ?>" frameborder="0" allowfullscreen></iframe><?php } ?>
<!--iframe width="310" height="174" src="https://www.youtube.com/watch?v=9M4WDNMDrFs" frameborder="0" allowfullscreen=""></iframe>
	<iframe width="310" height="174" src="https://www.youtube.com/embed/FKb0Ijp1no0?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen=""></iframe-->
		<?php } ?>
		<?php } ?>



	</div></div></div>
	<div class="col-lg-6 col-md-4 col-12">
		<h3 class="my-3"><?php if ($item['num_rooms_id']) if ($item['type_name']=='Квартира'){  $item['type_name']=mb_strtolower($item['type_name'], "UTF-8");?>
			<?php if ($item['num_rooms_id']==1) echo 'Однокомнатная'; elseif ($item['num_rooms_id']==2) echo 'Двухкомнатная';  elseif ($item['num_rooms_id']==3) echo 'Трехкомнатная'; elseif ($item['num_rooms_id']==4) echo 'Многокомнатная';  else {$item['type_name'] = $item['numRooms_name']; $kostyl = 0;}?>
			<?php } ?><?php echo $item['type_name']; ?></h3>

			<h3 class="my-3">Цена: <?php echo $item['price']; ?>, руб.</h3>
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><b>Площадь:</b> <?php echo $item['square']; ?> м<sup>2</sup></li>
				<li class="list-group-item"><b>Район:</b> <?php echo isset($districty) ? $districty : 'не указан'; ?></li>
				<li class="list-group-item"><b>Улица:</b> <?php if ($item['street']) { ?><?php echo $item['street']; ?><?php } ?>
					<?php if (isset($real)) { ?></li>
					<li class="list-group-item"><b>Дом:</b><?php if ($item['dm']) { ?><?php echo $item['dm']; ?><?php } ?></li>
					<li class="list-group-item"><b>Квартира:</b> <?php if ($item['kv']) { ?><?php echo $item['kv']; ?><?php } ?>
						<?php } ?></li>
						<li class="list-group-item"><b>Этаж:</b> <?php if (in_array($item['type_id'], array(1,3,5))) { ?><?php if ($item['floor']!=0) {?><?php if ($item['floor']==0) {?>цокольный<?php } else { echo $item['floor']; ?>/<?php echo $item['floor_num']; } ?><?php } ?><?php } ?></li>
						<li class="list-group-item"><b>Дата:</b>  <?php echo date("j.m.Y", $item['date_add']); ?></li>


						<li class="list-group-item"><b>Количество  <?php if ($kostyl==1) { ?>
							<?php  if (($item['num_rooms_id']) and ($item['type_id']<4)){ ?>
							<?php if ($item['num_rooms_id'] < 6) { ?><?php if ($item['type_id'] != 5){ ?>комнат<?php } else { ?>офисов<?php } ?></b>: <?php echo $item['num_rooms_id']; ?><?php } else if ($item['num_rooms_id']>5) { ?><?php echo $item['numRooms_name']; ?></b></li>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<?php if ($agent) { ?>
							<?php if ($agent['status']!=0) { ?>
							<!--div class="estateType" style="font-size:14px;"><b>Имя</b>: <?php echo $agent['name']; ?></div-->
							<?php } else { ?>
							<!--div class="estateType" style="font-size:14px;"><b>Агент не подтвержден</b></div-->
							<?php } ?>
							<?php } else {?>
							<!--div class="estateType" style="font-size:14px;"><b>Агент не найден</b></div-->
							<?php } ?>

							<?php if (isset($real)) { ?>
							<li class="list-group-item"><b>Имя:</b> <?php echo $item['contact_name']; ?></li>
							<li class="list-group-item"><b>Тел:</b> <h2><?php echo $item['contact_phone']; ?></h2></li>
							<li class="list-group-item"><b>Договор до:</b> <?php echo $item['dog']; ?></li><?php } else { ?> <li class="list-group-item"><b>Тел: 8 911 865 14 76</b></li> <?php } ?>

							<li class="list-group-item"><b>Просмотров:</b> <?php echo $item['views']; ?></li>
						</ul>
					</div>




					<div style="clear:both;"></div>
				<div class="row contaier">
					<div class="col-12" style="border-bottom:2px solid #efefef">
						<h3><b>Описание:</b></h3>
					</div>
					<?php if ($item['description']) { ?><div class="estateType" style="font-size:14px; margin-top:10px;"></div>
					
					<div class="estateType" style="font-size:24px; margin: 30px 30px 50px 30px;">
						<?php echo $item['description']; 
						?>
					</div>
					<div style="clear:both;"></div>
				</div>




				</div>
				<div class="col-12" id="YMapsID" style="height:350px; width: 100%;"></div>
					<?php 

					?>
					<script src="http://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>
					<script type="text/javascript">
						var map, geoResult;
						YMaps.jQuery(function () {
							map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
							map.setCenter(new YMaps.GeoPoint(), 13);
							map.addControl(new YMaps.Zoom());
							var toolBar = new YMaps.ToolBar();
							var smallzoom = new YMaps.SmallZoom();
							var typecontrol = new YMaps.TypeControl();

							map.enableScrollZoom();
							//map.removeOverlay(geoResult);
							var geocoder = new YMaps.Geocoder('Россия, Калининградская область, Калининград, <?php echo $item['street'];?> <?php if (isset($item['dm'])) if ((int)$item['dm']) echo $item['dm']; ?>', {results: 1, boundedBy: map.getBounds()});

							YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
								if (this.length()) {
									geoResult = this.get(0);
									geoResult.setBalloonContent("<p style='margin:0;padding:0;'>Отображение ориентировочное</p>");
									map.addOverlay(geoResult);
									map.setBounds(geoResult.getBounds());
								} else {
			//alert("Ничего не найдено")
		}
	});
							YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
		//alert("Произошла ошибка: " + error);
	})
							
						});	
					</script>	
				<div style="clear:both;"></div>

				<?php } ?>

			</div>

			<script>

			</script>