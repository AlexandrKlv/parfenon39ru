	<div id="content">

<!-- СТРАНИЦА ПРОСМОТРА ВСЕХ ОБЪЯВЛЕНИЙ КВАРТИР -->

		<h3>Недвижимость в Калининграде и Калининградской области</h3>
		
		<ol class="breadcrumb">
        <li class="breadcrumb-item">
          <p id="thrumbnails">
			<a href="/">Главная</a> &gt;&gt; Недвижимость
		</p>
        </li>
      </ol>
		
		<ol class="breadcrumb">
       <?php if (!empty($tickets)) { ?>
		<?php $uri_no_page = str_replace('/page='.$num_page, '', $_SERVER['REQUEST_URI']); ?>
		<?php $uri_no_page_and_sort = str_replace('/sort='.$sort, '', $uri_no_page); ?>
		<div class="row" style="overflow:hidden; float:right; font-family:Tahoma;">
			<div  style="float:left; text-align:left; margin-left:0px; margin-right: 20px;"><b style="font-size:16px;">Выбор по: </b></div>
			<div style="clear:both;"></div>
			<div style="font-size:16px;">
				<div class="btn btn-success" style="float:left; margin-right:10px; <?php if ($sort=='price') { ?>font-weight:bold;<?php } ?>"><a href="http://<?php echo $_SERVER['HTTP_HOST'] . '/' . $uri_no_page_and_sort;?>/sort=price" style="color:white;">По цене</a></div>
				<div class="btn btn-success" style="float:left; margin-right:10px; <?php if ($sort=='square') { ?>font-weight:bold;<?php } ?>"><a href="http://<?php echo $_SERVER['HTTP_HOST'] . '/' . $uri_no_page_and_sort;?>/sort=square" style="color:white;">По площади</a></div>
				<div class="btn btn-success" style="float:left; margin-right:10px; <?php if (($sort!='square') and ($sort!='price')) { ?>font-weight:bold;<?php } ?>"><a href="http://<?php echo $_SERVER['HTTP_HOST'] . '/' . $uri_no_page_and_sort;?>/sort=date" style="color:white;">По дате размещения</a></div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div style="clear:both;"></div>
      </ol>
		


		


		
		<div class="estates col-lg-12 col-md-12 col-sm-12 col-12" style="height: auto">

		


			<?php	foreach($tickets as $ticket){ 
					$img = (trim($ticket['photo1'])!=='') ? $ticket['photo1'] : '_no_image';
					$bg_img = 'bg_com.png';
					if ($ticket['type_id']==1) $bg_img = 'bg_flat.png';
					elseif ($ticket['type_id']==2) $bg_img = 'bg_dom.png';
					elseif ($ticket['type_id']==3) $bg_img = 'bg_nov.png';
					elseif ($ticket['type_id']==4) $bg_img = 'bg_gar.png';
			?>
			<div class="estate row" style="background: white url(/themes/theme_1.0/img/<?php echo $bg_img; ?>) right bottom no-repeat;">
				<div class="estateImgCont col-12 col-lg-6 col-md-6">
										<?php if ($img!='_no_image') { ?><div class="estateImg"><img class="card-img-top" width="100%" style="width:100%;" src="/uploads/images/realty/mini/<?php echo $img; ?>" /></div><?php } else { ?>
										<div class="estateImg"><img  style="width: 100%;" src="/themes/theme_1.0/img/no_imgs.jpg" /></div><?php } ?>
				
				</div>
				<div class="estateInfz1 jumv col-12 col-md-6 col-lg-6">
				<div>
          <h3 class="my-3"><b><?php if ($ticket['num_rooms_id']) if ($ticket['type_name']=='Квартира'){  $ticket['type_name']=mb_strtolower($ticket['type_name'], "UTF-8");?>
					<?php if ($ticket['num_rooms_id']==1) echo 'Однокомнатная'; elseif ($ticket['num_rooms_id']==2) echo 'Двухкомнатная';  elseif ($ticket['num_rooms_id']==3) echo 'Трехкомнатная'; elseif ($ticket['num_rooms_id']==4) echo 'Многокомнатная';  else $ticket['type_name'] = $ticket['numRooms_name']; ?>
					<?php } ?><?php echo $ticket['type_name']; ?></b></h3>
          
          <h3 class="my-3">Цена: <?php echo $ticket['price']; ?>, руб.</h3>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Площадь:</b> <?php echo $ticket['square']; ?> м<sup>2</sup></li>
            <li class="list-group-item"><b>Город:</b> <?php echo ($cities[$ticket['city_id']]['name']); ?></li>
            <li class="list-group-item"><b>Улица:</b> <?php echo $ticket['street']; ?></li>
            <li class="list-group-item"><b>Район:</b> <?php echo $ticket['districts_name']; ?></li>
            <li class="list-group-item"><b><?php if (in_array($ticket['type_id'], array(1,3,5))) { ?><div class="estateFloor h6"><b>Этаж</b>: <?php if ($ticket['floor']==0) {?><?php } else { echo $ticket['floor']; ?>/<?php echo $ticket['floor_num']; } ?></div><?php } ?>
					<?php  if (($ticket['num_rooms_id']) and ($ticket['type_id']<4)){ ?>
						<?php if ($ticket['num_rooms_id'] < 6) { ?></li>
            <li class="list-group-item"><b>Дата:</b> <?php echo date("j.m.Y", $ticket['date_add']); ?></li>
            <li class="list-group-item"><b>Количество <?php if ($ticket['type_id'] != 5){ ?>комнат <?php } else { ?>офисов <?php } ?><?php echo $ticket['num_rooms_id']; ?><?php } else if ($ticket['num_rooms_id']>5) { ?><?php echo $ticket['numRooms_name']; ?></b></li>
            <?php } ?>
					<?php } ?></b></b>
          </ul>
						
					<a href="<?php echo SITE_URL . '/realty/cities/districts/all/' . 'all-' . $ticket['id'];?>" style="color:white !important; text-decoration:none !important;"><div class="h5 btn btn-primary" type="button"  style="position:inherit !important; margin-top:10px;">Смотреть</div></a>					

				</div>
			</div></div>
			<div style="clear:both;"></div><br><br>
			<?php } ?> 
		</div>
		
					<!--div>Описание: <?php echo $ticket['description']; ?></div-->
		
		<!--table style="border-collapse:collapse;">
		<?php	foreach($tickets as $ticket){ 
				$img = (trim($ticket['photo1'])!=='') ? $ticket['photo1'] : '_no_image';
		?>
				<tr>
					<td style="border:1px solid #CCCCCC; padding:3px;">
						<div><img src="/uploads/images/realty/mini/<?php echo $img; ?>" /></div>
					</td>
					<td style="border:1px solid #CCCCCC; padding:3px;">
						<div><b>Адрес</b>: <?php echo $ticket['street']; ?></div>
						<div><b>Район</b>: <?php echo $ticket['districts_name']; ?></div>
						<div><b>Объект</b>: <?php echo $ticket['id']; ?></div>
						<div><b>Дата</b>: <?php echo date("j.m.Y", $ticket['date_add']); ?></div>
					</td>
					<td style="border:1px solid #CCCCCC; padding:3px;">
						<div><b><?php echo $ticket['type_name']; ?></b></div>
						<div><b>Площадь</b>: <?php echo $ticket['square']; ?> м<sup>2</sup></div>
						<?php if (in_array($ticket['type_id'], array(1,3,5))) { ?><div><b>Этаж</b>: <?php if ($ticket['floor']==0) {?>цокольный<?php } else { echo $ticket['floor']; ?>/<?php echo $ticket['floor_num']; } ?></div><?php } ?>
						<?php if ($ticket['num_rooms_id']) { ?>
							<?php if ($ticket['num_rooms_id'] < 6) { ?>
								<div><b>Количество <?php if ($ticket['type_id'] != 5){ ?>комнат<?php } else { ?>офисов<?php } ?></b>: <?php echo $ticket['num_rooms_id']; ?></div>
							<?php } else if ($ticket['num_rooms_id']>5) { ?>
								<div><?php echo $ticket['numRooms_name']; ?></div>
							<?php } ?>
						<?php } ?>
						<div><b>Цена</b>: <?php echo $ticket['price']; ?>, руб.</div>
						<div><a href="">Смотреть</a></div>
					</td>
				</tr>
		<?php } ?> 
		</table-->
		
			<?php if ($count_pages>1) { 
				//$uri_no_page = str_replace('/page='.$num_page, '', $_SERVER['REQUEST_URI']); 
			?>
			<div>
				<?php
					if (!empty($pages_nav)) foreach ($pages_nav as $ii){
						if ($ii=='...'){ ?>
							<div style="float:left; padding-top:20px;">
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
							</div>			
						<?php } elseif ($num_page!=$ii) { ?>
							<a href="http://<?php echo $_SERVER['HTTP_HOST'] . '/' . $uri_no_page;?>/page=<?php echo $ii;?>">
							<div class="btn btn-light" style="text-align:center; float:left;"><?php echo $ii;?>
							</div>
							</a>							
						<?php } else { ?>
							<div class="btn btn-success" style="text-align:center; float:left;"><?php echo $ii;?>
							</div>							
						<?php }
					}
				?>
			<!--
				<?php for ($ii=1; $ii<=$count_pages; $ii++) { ?>
					<?php if ($num_page!=$ii) { ?>
						<a href="http://<?php echo $_SERVER['HTTP_HOST'] . '/' . $uri_no_page;?>/page=<?php echo $ii;?>">
						<div style="width:30px; height:23px; border:1px solid #CCCCCC; background:#FFCCCC; margin:5px; border-radius:50%;text-align:center; float:left; padding-top:7px;"><?php echo $ii;?>
						</div>
						</a>
					<?php } else {?>
						<div style="width:30px; height:23px; border:1px solid #CCCCCC; background:#CCCCCC; margin:5px; border-radius:50%;text-align:center; float:left; padding-top:7px;"><?php echo $ii;?>
						</div>
					<?php } ?>
				<?php } ?>
				<div style="padding-top:12px; height:18px; float:left; margin:5px; width:25px; padding-left:5px;">
					<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
					<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
					<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
				</div>
			</div>
			<?php } ?>
		<?php } else { ?>
				<div>По Вашему запросу ничего не найдено.</div>
		<?php } ?>
	/div-->
</div>