<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
  <!--div>
  <?php //echo $category_text; 
  ?>
  </div-->
  <div class="row">
  <div class="col-12">
  <div id="news-box" >
    <?php if($news_items) { ?>
      <?php foreach($news_items as $item) { ?>
      <div class="jumbotron">
        <h2><a href="<?php echo $item['href']; ?>" style="color: black;"><?php echo $item['name']; ?></a></h2>
        <div><p><?php echo $item['preview']; ?></p></div>
        <div class="date text-left"><?php echo $item['date_add']; ?></div>
        <h3 style="margin-top:13px; float:left;"><a class="btn btn-primary" href="<?php echo $item['href']; ?>" role="button">читать дальше</a></h3><br>
      </div>
      <?php } ?>
          <?php } ?>
  </div>
  </div>
  </div>




  <div style="clear:both"></div>
  <?php if ($count_pages > 1) { ?>
  <div id="paginations" style="display: flex;">
	<?php for($i=1; $i<=$count_pages; $i++){ ?>
		<span class="pagination btn btn-outline-success">
			<?php if ($i==$page) { ?>
				<?php echo $i; ?>
			<?php } else { ?>
				<a href="<?php echo SITE_URL . '/' . $this->url['component'] . '/' . $this->url['actions'][0] . '/page=' . $i;?>" class="pagination-link" style="color: black; width: 20px; height: 20px;"><?php echo $i;?></a>
			<?php } ?>
		</span>
	<?php } ?>
  </div>
  <?php } ?>
</div>