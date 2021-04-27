<div id="content"> 
<h1 id="page_name"><?php echo $page_name; ?></h1>
	<form action="" method="post" id="formSearch">
		<input type="text" name="search" value="<?php if (!empty($searchText)) { echo $searchText; } ?>" id="searchInpCpn">
		<input type="submit" name="submit" value="Искать" id="searchBtnCpn">
	</form>
	<table id="tableBold">
		<?php if (isset($_POST['submit']) && !empty($_POST['search']) || !empty($_POST['siteSearch'])) : ?>
			<?php $i = 0; while ($i < $countArr) : ?>
				<div class="difColor">
					<div class='item_title'>
						<a class='a_title' href="<?php echo $pagesFound['realUrl'][$i]; ?>">
							<?php 
								echo $pagesFound['title'][$i]; 
							?>
						</a>
					</div>
					<div class='item_url'>
						<a class='a_url' href="/"><?php echo $serverName; ?></a>
					<?php $url = ''; $a = 0; foreach ($pagesFound['url'][$i] as $value) : if ($value != $serverName) : ?>
						<div class="arrow">></div>
						<a class='a_url' href="<?php $url .= '/' . $value; echo $url; ?>"><?php echo $value; ?></a>
					<?php endif; $a++; endforeach; ?>
					</div>
					<div class='item_text'>						
						<?php 
							echo $pagesFound['text'][$i];
						?>
					</div>
				</div>
			<?php $i++; endwhile; ?>
		<?php endif; ?>
		<?php if (!empty($emptyText)) { echo $emptyText; } ?>		
	</table>
</div> 