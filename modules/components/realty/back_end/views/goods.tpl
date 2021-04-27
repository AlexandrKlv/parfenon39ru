<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<?php if($error!=0) { ?>
	<div class="notice error">
		<p><?php echo $msg; ?></p>
	</div>
	<?php }  elseif($msg) { ?>
	<div class="notice success">
		<p><?php echo $msg; ?></p>
	</div>
	<?php } ?>
	<p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/catalog/additm/sub=<?php echo $sub;?>">Добавить товар</a>
  </p>
  <?php if($news) { ?>
  <table class="main">
    <tr>
      <th>Наименование</th>
      <th>Категория</th>
      <th>Действия</th>
    </tr>
    <?php foreach($news as $item) { ?>
    <tr>
      <td><?php echo $item['name']; ?></td>
      <td><?php echo $item['category']; ?></td>
      <td class="actions">
        <a href="<?php echo SITE_URL; ?>/admin/catalog/edititm/sub=<?php echo $item['cat']; ?>/page=<?php echo $page;?>/act=edititm/id=<?php echo $item['id']; ?>">Изменить</a>
        <span onclick="destroy(<?php echo $sub;?>,<?php echo $page;?>,<?php echo $item['id'];?>);"><a href="javascript:void">Удалить</a></span><br>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
  <?php
    if ($count_pages>1){
	  for ($i=1;$i<=$count_pages; $i++){ ?>
	    <a href="<?php echo SITE_URL?>/admin/catalog/goods/sub=<?php echo $sub; ?>/page=<?php echo $i;?>"><?php echo $i;?></a>
  <?php  
      }
	}
  ?>
</div>
<script type="text/javascript"> 
 function destroy(sub, page, itemid){
	if (confirm("Bы уверены, что хотите уничтожить этот товар?")){
		parent.location='<?php echo SITE_URL; ?>/admin/catalog/delitm/sub='+sub+'/page='+page+'/act=delitm/id='+itemid;
	} else {
	}
 }
</script>