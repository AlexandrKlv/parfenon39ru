<div id="categories">

	<?php 
	function kito($ar, $name, $compUrl, $url){
	  if (!empty($ar))

		foreach ($ar as $k=>$v){

			?><a class="nd" href="/<?php echo $compUrl;?><?php echo $url.$v['url'];?>"><div class="<?php echo $name;?>kittycat"><?php echo $v['name'];?></div></a><?php
if ($name=='sub') $name=' sub';
			kito($v['sub'], 'sub'.$name,  $compUrl, $url.$v['url'].'/');
		}
	}
	kito($cats, '',  $compUrl, '/');
	?>

</div>