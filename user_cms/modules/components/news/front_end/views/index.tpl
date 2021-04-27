<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
	<?php if (isset($image2)) if ($image2) {  ?>
		<!--img style="float:left; margin-right:15px; margin-bottom:15px; max-width:300px; max-height:200px;" src="<?php echo SITE_URL .   $image2; ?>" /-->
	<?php } ?>
	<?php echo $content; ?>
</div>