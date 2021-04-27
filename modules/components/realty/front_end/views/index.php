<div id="content">
	<div class="categories_announce">
		<!--хлебные крошки-->
		<p id="thrumbnails">
			<a href="/">Главная</a> &gt;&gt; Каталог
		</p>
		<!--вывод категорий в корне каталога-->
		<?php WHILE($CAT = $st->fetch()){ 
			$zaglushka='_no_photo.jpg'; 
		    $catimage=$CAT['image']!=''?$CAT['image']:$zaglushka; ?>
			<a title="<?php echo $CAT['name'];?>" class="title" href="/catalog/<?php echo $CAT['url'];?>/">
				<div class="catalog">
				  <div class="cat_img_bord">
					<div class="cat_img" style="background:url('/media/catalog/<?php echo $catimage;?>') no-repeat;  background-size: 200px;">
						<div class="catalog_text">
							<div class="catalog_title">
								<?php echo 'AAA'.$CAT['name'].'*';?>
							</div>
						</div>
					</div>
				  </div>
				</div>
			</a>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>
<?php echo '*'.$catimage;?>