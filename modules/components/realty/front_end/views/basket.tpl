<div id="content">
<pre><?php 
//print_r($_SESSION); 
//unset($_SESSION['goods']); unset($_SESSION['basker']);
?>
</pre>
	<?php 
		$flag=TRUE;
		if (!isset($_SESSION['goods'])) $flag=FALSE;
		else {
			$goods=$_SESSION['goods']; 
			$flag=false; 
			foreach($goods as $key=>$good) { if ($good>0) $flag=TRUE; }
		}
		if ($flag) { 
			$db=new PDO("sqlite:db.sqlite");
			?>
			<div class="moves">
				<div class="active_move">Шаг 1</div><div class="arrow"><hr/></div>
				<div class="move">Шаг 2</div><div class="arrow"><hr/></div>
				<div class="move">Шаг 3</div><div class="arrow"><hr/></div>
				<div class="move">Шаг 4</div>
				<div class="clear"></div>
			</div>
			Товары в корзине:<br/>
			<table style="border-collapse:collapse;" id="basket_table">
			<tr>
				<th class="thd">#</th>
				<th class="thd">Фото</th>
				<th class="thd">Наименование</th>
				<th class="thd">Цена</th>
				<th class="thd">Количество</th>
				<th class="thd">Сумма</th>
				<th class="thd"><!--div class="x">x</div--></th>
			</tr>
			<?php
			$big_sum=0;
			$i=1;
			foreach ($goods as $key=>$good) if ($good>0){
				$st=$db->query("SELECT * FROM items WHERE id=".$key." LIMIT 1");
				$ITEM=$st->fetch();
				$sum=$ITEM['price']*$good;
				$big_sum+=$sum;
			?>
				<tr id="tr<?php echo $ITEM['id'];?>">
					<td class="thd"><?php echo $i;?></td>
					<td class="thd"><img width="100" src="/media/catalog/mini/<?php echo $ITEM['image'];?>" alt="<?php echo $ITEM['name'];?>"/></td>
					<td class="thd"><?php echo $ITEM['name'];?></td>
					<td class="thd"><?php echo $ITEM['price'];?></td>
					<td class="thd"><?php echo $good;?></td>
					<td class="thd"><?php echo $sum;?></td>					
					<td class="thd"><div class="x" onclick="tothebasket(1, <?php echo $ITEM['id'];?>)" title="удалить">x</div></td>
				</tr>
			<?php $i++; } ?>
			<tr><td colspan="7" style="text-align:right;" class="in-total">Итого: <?php echo $big_sum;?> <?php echo $settings['valuta'];?></td></tr>
			<tr><td colspan="7" style="text-align:right;" class="next-step"><a href="<?php echo SITE_URL;?>/<?php echo $this->url['component'];?>/step2"><input type="button" class="basketbutton" value="Далее"></a></td></tr>
			</table>
			
		<?php }else{ ?>
			<div>В вашей корзине нет товаров.</div>
		<?php } ?>
</div>
<script><?php include("scriptjs.php");?></script>