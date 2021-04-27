<div id="content">
	<div class="categories_announce">		
		<!--хлебные крошки-->
		<p id="thrumbnails">
			<a href="/">Главная</a> >> 
			<a href="/<?php echo $this->url['component'];?>/">Каталог</a>
			<?php 
			$bread_url='/'.$this->url['component'].'/';
			for($x=2;$x<=sizeof($cat);$x++) {
				$bread_url.=$cat[$x]['url'].'/';?>
				&gt;&gt; <a href="<?php echo $bread_url;?>"><?php echo $cat[$x]['name'];?></a>
			<?php } 
			$bread_url.=$cat[sizeof($cat)+1]['url'].'/'; 
			?>
			&gt;&gt; <?php echo $cat[sizeof($cat)+1]['name'];?>
		</p>
		<!--вывод подкатегорий-->
		<?php WHILE($SUBCAT = $st->fetch()){
			$subcatimage=$SUBCAT['image']!=''?$SUBCAT['image']:'_no_photo.jpg';?>
			<a title="<?php echo $SUBCAT['name'];?>" class="title" href="<?php echo $bread_url?><?php echo $SUBCAT['url'];?>/">
				<div class="catalog">
				  <div class="cat_img_bord" >
					<img src="/media/catalog/<?php echo $subcatimage;?>" class="cat_nitro" style="display:none;">
					<div class="cat_img" style="background:url('/media/catalog/<?php echo $subcatimage;?>') no-repeat;  height:<?php echo $settings['cat']['h']; ?>px; width:<?php echo $settings['cat']['w']; ?>px;">
						<!--div class="catalog_text" style="margin-top:<?php $tmp=$settings['cat']['h']>50?$settings['cat']['h']-50:0; echo $tmp;?>px;">
							<div class="catalog_title">
								<?php echo $SUBCAT['name'];?>
							</div>
						</div-->
					</div>
				  </div><div class="catalogtitle2"><?php echo $SUBCAT['name'];?></div>
				</div>
			</a>
		<?php } ?>
		<div class="clear"></div>
		<!--вывод товаров категории-->
		<?php WHILE($ITEM = $st2->fetch()){ 
			$ITEM['image']=(empty($ITEM['image'])) ? '_no_photo.jpg' : $ITEM['image'];?>
			<a href="<?php echo $bread_url;?><?php echo $ITEM['url'];?>/">
				<div class="catalog_pos">
					<table style="width:100%;" class="simple_table"><tr><td valign="top">
					<div class="cat_img_bord" style="float:left; margin:0 15px 0 0;">
						
						<img src="/media/catalog/mini/<?php echo $ITEM['image'];?>" class="item_nitro" style="display:none;">
						<div class="item_img" style="background:url('/media/catalog/mini/<?php echo $ITEM['image'];?>') no-repeat;  height:<?php echo $settings['item']['mini']['h']; ?>px; width:<?php echo $settings['item']['mini']['w']; ?>px;">
							<!--div class="catalog_text" style="margin-top:<?php $tmp=$settings['item']['mini']['h']>50?$settings['item']['mini']['h']-50:0; echo $tmp;?>px;">
								<div class="catalog_title">
									<?php echo $ITEM['name'];?>
								</div>
							</div-->
						</div>
					</div>
					
					
						<div class="desc"><div class="itemname"><?php echo $ITEM['name'];?></div><?php $text=mb_strLen($ITEM['text'],"UTF-8")>260 ? mb_substr($ITEM['text'],0,255,'UTF-8').'...' : $ITEM['text']; echo $text;?></div>
						<?php if ($ITEM['price']>0){?><div class="desc2"><span>Цена:</span> <?php echo $ITEM['price'];?> руб.</div><?php } ?>
					</td></tr>
					<tr><td valign="bottom" align="right"><div class="podrobnee">Подробнее</div></td></tr>
					</table>
				</div>
			</a>
			<div class="clear"></div>
		<?php } ?>
		<div id="cat_desc"><?php echo $CAT['text'];?></div>		
	</div>
</div>
<script type="text/javascript">
	h1 = <?php echo $settings['cat']['h']; ?>;
	w1 = <?php echo $settings['cat']['w']; ?>;
	hz1 = <?php echo $settings['item']['mini']['h']; ?>;
	wz1 = <?php echo $settings['item']['mini']['w']; ?>;
	window.onload=function(){
maxh=0;
		arr = document.getElementsByClassName("cat_img");
		arr1 = document.getElementsByClassName("cat_nitro");
		arr2 = document.getElementsByClassName("catalogtitle2");
		arr3 = document.getElementsByClassName("catalog");
		for (i=0; i<arr.length; i++){
			h2 = arr1[i].naturalHeight;
			w2 = arr1[i].naturalWidth;
			if (h1*w2 < w1*h2) { h2 = h2*w1/w2; w2 = w1;}
			else { w2 = w2*h1/h2; h2 = h1;}		
			arr[i].style.backgroundSize=w2+"px "+h2+"px";
//arr2[i].style.width=arr3[i].offsetWidth+'px'; alert(arr3[i].offsetWidth);if (arr3[i].offsetHeight>maxh) maxh=arr3[i].offsetHeight;
arr2[i].style.width=w1+'px';/* w2 ?  w2+'px' : arr[i].style.width;*/ if (arr3[i].offsetHeight>maxh) maxh=arr3[i].offsetHeight;
		}
for (i=0; i<arr.length; i++){arr3[i].style.height=maxh+"px";}
		arrz = document.getElementsByClassName("item_img");
		arrz1 = document.getElementsByClassName("item_nitro");
		for (i=0; i<arrz.length; i++){
			hz2 = arrz1[i].naturalHeight;
			wz2 = arrz1[i].naturalWidth;
			if (hz1*wz2 < wz1*hz2) { hz2 = hz2*wz1/wz2; wz2 = wz1;}
			else { wz2 = wz2*hz1/hz2; hz2 = hz1;}		
			arrz[i].style.backgroundSize=wz2+"px "+hz2+"px";
		}
	}
</script>
