<div class="news_announce">
	
  <?php foreach($news as $item) { ?>
  
    <!-- <div><?php echo $item['preview']; ?></div> -->
	<div class="wrap-news">
		
		<div class="date-news">
			<img src="/uploads/modules/news/mini/<?=$item['image'];?>" alt="" align="left" style="margin-right:10px;">
			<?php  $a1 = $item['date_add']; $a2= date("d.m.y", $a1); echo $a2?>
			<h3><a href="/novosti/novosti-na-sayte/<?php echo $item['url'];?>"><?php echo $item['name']; ?></a></h3>
			<p><?=$item['preview'];?></p>
		</div>
		
	</div>
  
  <?php } ?>
  
</div>
<style>
.news_announce .date-news {width:100%;float:none;}
</style>