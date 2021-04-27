<div id="content">
	<?php if (!empty($estates)) { ?>
		<table>
		<tr>
			<th>#</th>
			<th>Дата</th>
			<th>Агент</th>
			<th>Объявление</th>
			<th>Цена</th>
			<th>Действия</th>
		</tr>
	
		<?php foreach ($estates as $estate) { ?>
			<tr>
				<td><?php echo $estate['id'];?></td>
				<td><?php echo date("j.m", $estate['date_add']);?></td>
				<td><?php echo $estate['agent_id'];?></td>
				<?php
					$tes = '';
					if ($estate['type_id']==1) $tes='Квартира';
					elseif ($estate['type_id']==2) $tes='Дом';
					elseif ($estate['type_id']==3) $tes='Новостройка';
					elseif ($estate['type_id']==4) $tes='Земельный участок / Дача';
					elseif ($estate['type_id']==5) $tes='Коммерческая недвижимость';
				?>
				<td><div class="fixedwidthtdclass"><b style="font-size:18px; font-family:Tahoma;"><?php echo $tes; ?></b><BR><!--image--><?php echo $estate['description'];?><BR><b>тел: <?php echo $estate['contact_phone']; ?></b><?php if ($estate['dog']) { ?><BR><b>договор до: <?php echo $estate['dog']; ?></b><?php } ?></div></td>
				<td><div class="fixedwidthtdclass2"><?php echo $estate['price'];?></div></td>
				<td>
					<a href="<?php echo SITE_URL; ?>/realty/cities/districts/all/all-<?php echo $estate['id'];?>" target="_blank">Смотреть</a>
					<?php if ($estate['status']==0) { ?><a style="color:#901313;" href="<?php echo SITE_URL; ?>/admin/realty/estactiv/id=<?php echo $estate['id'];?>">Активировать</a><?php } ?>
					<!--a href="<?php echo SITE_URL; ?>/admin/realty/delete/id=<?php echo $estate['id'];?>">Удалить</a-->
					<!--a href="<?php echo SITE_URL; ?>/admin/realty/estedit/id=<?php echo $estate['id'];?>">Изменить</a-->
					<a href="<?php echo SITE_URL; ?>/admin/realty/editx/id=<?php echo $estate['id'];?>" target="_blank">Изменить</a>
					<span onclick="destroy(<?php echo $estate['id'];?>);"><a href="javascript:void">Удалить</a></span>
					<?php if ($estate['imp']==0) { ?><a style="color:#590075;" href="<?php echo SITE_URL; ?>/admin/realty/imp/id=<?php echo $estate['id'];?>">сделать VIP</a><?php } else { ?>
					<a style="color:#901313;" href="<?php echo SITE_URL; ?>/admin/realty/noimp/id=<?php echo $estate['id'];?>">отменить VIP (<?php echo ($estate['imp']!=1000 ? $estate['imp'] : 'NEW'); ?>)</a><?php } ?>
				</td>
			</tr>
		<?php } ?>
		</table>
	<?php } ?>
	
	<?php if ($count_pages>1) {  $uri_no_page = str_replace('/page='.$num_page, '', $_SERVER['REQUEST_URI']); ?>
			<div>
				<?php
					if (!empty($pages_nav)) foreach ($pages_nav as $ii){
						if ($ii=='...'){ ?>
							<div style="padding-top:12px; height:18px; float:left; margin:5px; width:25px; padding-left:5px;">
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
								<div style="background:black; border:1px solid black; width:3px; height:3px; border-radius:50%; float:left; margin-right:3px;"></div>
							</div>			
						<?php } elseif ($num_page!=$ii) { ?>
							<a href="http://<?php echo $_SERVER['HTTP_HOST'] . $uri_no_page;?>/page=<?php echo $ii;?>">
							<div style="width:30px; height:23px; border:1px solid #CCCCCC; background:#FFCCCC; margin:5px; border-radius:50%;text-align:center; float:left; padding-top:7px;"><?php echo $ii;?>
							</div>
							</a>							
						<?php } else { ?>
							<div style="width:30px; height:23px; border:1px solid #CCCCCC; background:#CCCCCC; margin:5px; border-radius:50%;text-align:center; float:left; padding-top:7px;"><?php echo $ii;?>
							</div>							
						<?php }
					} ?>
			</div>
		<?php } ?>
	
</div>
<script type="text/javascript"> 
 function destroy(id){
	if (confirm("Bы уверены, что хотите уничтожить объявление?")){
		parent.location='<?php echo SITE_URL; ?>/admin/realty/estdelete/id='+id;
	} else {
	}
 }
</script>