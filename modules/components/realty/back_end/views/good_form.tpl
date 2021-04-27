<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/catalog/goods/sub=<?php echo $sub;?>">К списку товаров</a>
  </p>
	<?php if($error!=0) { ?>
	<div class="notice error">
		<p><?php echo $msg; ?></p>
	</div>
	<?php } elseif($msg) { ?>
	<div class="notice success">
		<p><?php echo $msg; ?></p>
	</div>
	<?php } ?>
	<form method="post" action="" enctype="multipart/form-data">
			<div id="tab_main" style="display: block;">
				<label for="page_name">Название товара*:</label>
				<input type="text" name="name" value="<?php echo $name; ?>" required>
				<label for="page_name">Фото: (не более 5Мб)</label>
				<input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/gif">
				<label for="page_title">Заголовок (title)*:</label>
				<input type="text" name="title" value="<?php echo $title; ?>" required>
				<label for="page_url">URL:</label>
				<input type="text" name="url" value="<?php echo $url; ?>">
				<label for="page_title">Категория:</label>
				<select name="subcat">
				  <option value="0">Без категории</option>
				  <?php foreach ($cats as $cat_id=>$v){?>
				  <option value="<?php echo $v['id']; ?>"<?php if ($v['id']==$sub) echo ' selected';?>><?php echo $v['name'];?></option>
				  <?php }?>
				</select>
				<label for="page_name">Цена:</label>
				<input type="text"  name="price" value="<?php echo $price; ?>">
				<label for="page_text">Описание товара:</label>
				<textarea class="wysiwyg" name="text" ><?php echo $text; ?></textarea>
				<label>Сортировка:</label>
				<input type="text"  name="sort" value="<?php echo $sort; ?>">
			</div>
			<p class="buttons"><input type="submit" name="submit_category" value="<?php echo $text_submit; ?>"></p>
	</form>
</div>