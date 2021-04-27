<div id="content">
	<?php if (!empty($agents)) { ?>
		<table>
		<tr>
			<th>#</th>
			<th>Логин</th>
			<th>E-mail</th>
			<th>Действия</th>
		</tr>
	
		<?php foreach ($agents as $agent) { ?>
		<?php $colory = ($agent['id']!=1) ? 'black' : '#330066'; ?>
			<tr>
				<td><span style="color:<?php echo $colory;?>;"><?php echo $agent['id'];?></span></td>
				<td><span style="color:<?php echo $colory;?>;"><?php echo $agent['login'];?></span></td>
				<td><span style="color:<?php echo $colory;?>;"><?php echo $agent['email'];?></span></td>
				<td><?php if ($agent['id']!=1) { ?>
					<?php if ($agent['status']==0) { ?><a style="color:#901313;" href="<?php echo SITE_URL; ?>/admin/realty/activ/id=<?php echo $agent['id'];?>">Активировать</a> | <?php } ?>
					<!--a href="<?php echo SITE_URL; ?>/admin/realty/delete/id=<?php echo $agent['id'];?>">Удалить</a-->
					<span onclick="destroy(<?php echo $agent['id'];?>);"><a href="javascript:void">Удалить</a></span>
				<?php } ?></td>
			</tr>
		<?php } ?>
		</table>
	<?php } ?>
</div>
<script type="text/javascript"> 
 function destroy(id){
	if (confirm("Bы уверены, что хотите уничтожить агента?")){
		parent.location='<?php echo SITE_URL; ?>/admin/realty/delete/id='+id;
	} else {
	}
 }
</script>