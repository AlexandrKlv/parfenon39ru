<!-- КВАРТИРЫ НА ГЛАВНОЙ СТРАНИЦЕ -->
<div class="row" style="padding: 0px 15px 0px 15px;">
<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-12">
	<div class="row">
	<div class="catalog col-lg-8 col-md-12 col-12 row text-center" style="align-content: start;">

		<?php if (!empty($res2)) { ?>
		<h3>Самые выгодные варианты:</h3>
			<?php	foreach($res2 as $ticket){ 
					$img = (trim($ticket['photo1'])!=='') ? $ticket['photo1'] : '_no_image';
					$bg_img = 'bg_com.png';
					if ($ticket['type_id']==1) $bg_img = 'bg_flat.png';
					elseif ($ticket['type_id']==2) $bg_img = 'bg_dom.png';
					elseif ($ticket['type_id']==3) $bg_img = 'bg_nov.png';
					elseif ($ticket['type_id']==4) $bg_img = 'bg_gar.png';
			?>

		<div class="col-12 portfolio-item border-bottom">
            <div class="h-100 row">
              <div class="col-12 col-md-6 col-lg-6 estate">
              	<?php if ($img!='_no_image') { ?>
				<a href="#"><img class="card-img-top" src="/uploads/images/realty/mini/<?php echo $img; ?>" alt=""></a>
				<?php } else { ?>
				<div class="estateImg"><img class="card-img-top" style="width: 100%;" src="/themes/theme_1.0/img/no_imgs.jpg" /></div></a><?php } ?>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card-body no-pd">
                  <h5 class="card-title">
                  	<br>
                    <a href="<?php echo SITE_URL . '/realty/cities/districts/all/' . 'all-' . $ticket['id'];?>"><?php echo $ticket['street']; ?></a> 
                  </h5>
                  <ul class="list-group list-group-flush">
            	  <li class="list-group-item">
                  <p class="card-text"><?php if ($ticket['num_rooms_id']) if ($ticket['type_name']=='Квартира'){  $ticket['type_name']=mb_strtolower($ticket['type_name'], "UTF-8");?>
					<?php if ($ticket['num_rooms_id']==1) echo 'Однокомнатная'; elseif ($ticket['num_rooms_id']==2) echo 'Двухкомнатная';  elseif ($ticket['num_rooms_id']==3) echo 'Трехкомнатная'; elseif ($ticket['num_rooms_id']==4) echo 'Многокомнатная';  else $ticket['type_name'] = $ticket['numRooms_name']; ?>
					<?php } ?><?php echo $ticket['type_name']; ?>

					 <?php echo $ticket['square']; ?> м<sup>2</sup></p></li>

					 <li class="list-group-item"><?php if (in_array($ticket['type_id'], array(1,3,5))) { ?><div class="estateFloor h6"><b>Этаж</b>: <?php if ($ticket['floor']==0) {?>цокольный<?php } else { echo $ticket['floor']; ?>/<?php echo $ticket['floor_num']; } ?></div><?php } ?>
					<?php  if (($ticket['num_rooms_id']) and ($ticket['type_id']<4)){ ?>
						<?php if ($ticket['num_rooms_id'] < 6) { ?></li>
						<li class="list-group-item">
							<div class="estateNum h6"><b>Количество <?php if ($ticket['type_id'] != 5){ ?>комнат<?php } else { ?>офисов<?php } ?></b>: <?php echo $ticket['num_rooms_id']; ?></div>
						<?php } else if ($ticket['num_rooms_id']>5) { ?>
							<!--div class="estateNum"><?php echo $ticket['numRooms_name']; ?></div-->
						<?php } ?>
					<?php } ?></li>



					 <li class="list-group-item"><b><?php echo $ticket['price']; ?> руб.</b></li>

					 <li class="list-group-item"><?php echo ($cities[$ticket['city_id']]['name']); ?>,</li>
					 <li class="list-group-item"><?php echo $ticket['districts_name']; ?> район
					 <li class="list-group-item">Дата: <?php echo date("j.m.Y", $ticket['date_add']); ?></p>
					
					<a href="<?php echo SITE_URL . '/realty/cities/districts/all/' . 'all-' . $ticket['id'];?>" style="margin: 5px; text-decoration: none;" type="button" class="btn btn-success btn-block">Смотреть</a></li></ul>
                </div>
              </div>
            </div>
          </div>

		



				
			<!--div style="clear:both;"></div-->
			<?php } ?> 
		<?php } ?> 
		
		<?php if (!empty($res1)) { ?>
		<h3>Последние 10 объявлений:</h3>
			<?php	foreach($res1 as $ticket){ 
					$img = (trim($ticket['photo1'])!=='') ? $ticket['photo1'] : '_no_image';
					$bg_img = 'bg_com.png';
					if ($ticket['type_id']==1) $bg_img = 'bg_flat.png';
					elseif ($ticket['type_id']==2) $bg_img = 'bg_dom.png';
					elseif ($ticket['type_id']==3) $bg_img = 'bg_nov.png';
					elseif ($ticket['type_id']==4) $bg_img = 'bg_gar.png';
			?>

		<div class="col-12 portfolio-item border-bottom">
            <div class="h-100 row">
              <div class="col-12 col-md-6 col-lg-6 estate">
              	<?php if ($img!='_no_image') { ?>
				<a href="#"><img class="card-img-top" src="/uploads/images/realty/mini/<?php echo $img; ?>" alt=""></a>
				<?php } else { ?>
				<div class="estateImg"><img class="card-img-top" style="width: 100%;" src="/themes/theme_1.0/img/no_imgs.jpg" /></div></a><?php } ?>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card-body no-pd">
                  <h5 class="card-title">
                  	<a href="<?php echo SITE_URL . '/realty/cities/districts/all/' . 'all-' . $ticket['id'];?>"><?php echo $ticket['street']; ?></a> 
                  	<br>
                    <ul class="list-group list-group-flush">
            	  <li class="list-group-item">
                  <p class="card-text"><?php if ($ticket['num_rooms_id']) if ($ticket['type_name']=='Квартира'){  $ticket['type_name']=mb_strtolower($ticket['type_name'], "UTF-8");?>
					<?php if ($ticket['num_rooms_id']==1) echo 'Однокомнатная'; elseif ($ticket['num_rooms_id']==2) echo 'Двухкомнатная';  elseif ($ticket['num_rooms_id']==3) echo 'Трехкомнатная'; elseif ($ticket['num_rooms_id']==4) echo 'Многокомнатная';  else $ticket['type_name'] = $ticket['numRooms_name']; ?>
					<?php } ?><?php echo $ticket['type_name']; ?>

					 <?php echo $ticket['square']; ?> м<sup>2</sup></p></li>

					 <li class="list-group-item"><?php if (in_array($ticket['type_id'], array(1,3,5))) { ?><div class="estateFloor h6"><b>Этаж</b>: <?php if ($ticket['floor']==0) {?>цокольный<?php } else { echo $ticket['floor']; ?>/<?php echo $ticket['floor_num']; } ?></div><?php } ?>
					<?php  if (($ticket['num_rooms_id']) and ($ticket['type_id']<4)){ ?>
						<?php if ($ticket['num_rooms_id'] < 6) { ?></li>
						<li class="list-group-item">
							<div class="estateNum h6"><b>Количество <?php if ($ticket['type_id'] != 5){ ?>комнат<?php } else { ?>офисов<?php } ?></b>: <?php echo $ticket['num_rooms_id']; ?></div>
						<?php } else if ($ticket['num_rooms_id']>5) { ?>
							<!--div class="estateNum"><?php echo $ticket['numRooms_name']; ?></div-->
						<?php } ?>
					<?php } ?></li>



					 <li class="list-group-item"><b><?php echo $ticket['price']; ?> руб.</b></li>

					 <li class="list-group-item"><?php echo ($cities[$ticket['city_id']]['name']); ?>,</li>
					 <li class="list-group-item"><?php echo $ticket['districts_name']; ?> район
					 <li class="list-group-item">Дата: <?php echo date("j.m.Y", $ticket['date_add']); ?></p>
					
					<a href="<?php echo SITE_URL . '/realty/cities/districts/all/' . 'all-' . $ticket['id'];?>" style="margin: 5px; text-decoration: none;" type="button" class="btn btn-success btn-block">Смотреть</a></li></ul>	
                </div>
              </div>
            </div>
          </div>

		



				
			<!--div style="clear:both;"></div-->
			<?php } ?> 
		<?php } ?> 


		<a href="<?php echo SITE_URL . '/realty/cities/districts/all/page=2'; ?>" style="margin-top: 20px; text-decoration: none;" type="button" class="btn btn-success btn-lg btn-block">Смотреть все объявления</a>
	
	
	</div>
	<div id="mainnews" class="news col-lg-4 col-md-12 col-12 column">
		<?php 
			if (isset($newz)) if (!empty($newz)) {
				
				
				
				?>
				<h2 style="text-align:center; margin-top:15px;">Статьи</h2>
				<?php 
					foreach($newz as $new){?>
						<div class="newx">
							
							<?php
							$item['text'] = $new['text'];
					$image2 = '';
					$im = explode('<img', $item['text']);
					if (isset($im[1])) {
						$im = $im[1];
						$im = explode('>', $im);
						$im = $im[0];
						$im = explode('src="', $im);
						if (isset($im[1])){
							$im = $im[1];
							$im = explode('"', $im);
							$im = $im[0];
							//print_r($im);
							$image2 = $im;
							//$image2 = str_replace('https://', '', $image2);
							//$image2 = str_replace('http://', '', $image2);
							//$image2 = str_replace(SITE_URL , '' , $image2);
							//$image2 = trim($image2, '/');
						}
					}			
							
							
							if (FALSE) if($new['image']) { ?><!--div class="newximage"><img  style="width:150px !important;" src="/uploads/images/contents/<?php echo $new['image']; ?>"></div--><?php } ?>
							<a class="h6" href="/novosti/novosti-na-sayte/<?php echo $new['url'];?>" style="text-decoration:none !important;"><h4></h4></a>
							
							

							
							<div style="clear:both"></div>
						</div>
			
		<div class="pdcard">
            <div class="card h-100">
              <h4 class="card-header"><?php echo $new['name'];?></h4>
              <div class="card-body"><?php if (FALSE) if ($new['image']) { ?><img src="<?php echo SITE_URL; ?>/uploads/modules/news/<?php echo $new['image'];?>" style="float:left; width:120px; max-height:250px; border:margin-right:4px; margin-bottom:4px;" /><?php } ?>


							<?php if ($image2) { ?><img src="<?php echo $image2; ?>" style="float:left; width:120px; max-height:280px; border:margin-right:4px; margin-bottom:4px;" /><?php } ?>
                <p class="card-text"><?php echo trim(trim(trim(mb_substr(strip_tags($new['preview']), 0, 200, "UTF-8"), '"'), '&nbsp;'));?></p>
              </div>
              <div class="card-footer">
                <a class="btn btn-primary" href="/novosti/novosti-na-sayte/<?php echo $new['url'];?>" style="text-decoration:none !important;"><h5 style="/*font-size:16px;*/ text-align:right;">Читать дальше</h5></a>
              </div>
            </div>
          </div>

				<?php }
				?>
			<?php 
			}
		?>
	</div>
</div>
	</div>
	
	
</div>