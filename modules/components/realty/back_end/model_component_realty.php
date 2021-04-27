<?php

class model_component_realty extends model {
 
	function saveimg($file){
		$dir = 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/images/realty';
		$stamp1 = imagecreatefrompng('http://' . $_SERVER['HTTP_HOST'] . '/themes/theme_1.0/img/save1.png');
		$stamp2 = imagecreatefrompng('http://' . $_SERVER['HTTP_HOST'] . '/themes/theme_1.0/img/save2.png');
		


		$tmpx = end(explode('.', $file));
					
		$tmpf = $file;
	  $next_file=$dir.'/'.$file;
 
	$exif_result=@exif_imagetype($next_file)?@exif_imagetype($next_file):0; 
	  $arr = getimagesize($next_file);
	  if (empty($arr)) continue;
	  $width = $arr[0];
	  $height = $arr[1];
	  $stamp = $stamp2;
	  if (($width>=800) or ($height>=800)) $stamp = $stamp1;
	  
	 	  
      if (($exif_result<1)or($exif_result>3)) continue;
	  else if ($exif_result==1) $im = imagecreatefromgif($next_file);
      else if ($exif_result==2) $im = imagecreatefromjpeg($next_file);
      else if ($exif_result==3) $im = imagecreatefrompng($next_file);

      $marge_right = 0;
      $marge_bottom = 0;
      $sx = imagesx($stamp);
      $sy = imagesy($stamp);
      imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
	  
	  $target_file = 'uploads/images/realty/'.$file;	  
      if ($exif_result==1) imagegif($im,$target_file);
      else if ($exif_result==2) imagejpeg($im,$target_file);
      else if ($exif_result==3) imagepng($im,$target_file);
	  imagedestroy($im);
		
		
	}
 
	function pages_nav($n, $m, $p, $recomended=3){
		// АЛГОРИТМ ОООЧЕНЬ КРИВОЙ!!!
		//$n=17;
		$result = array();
		$arr = array();
		if ($recomended > floor($m/4)) $recomended = floor($m/4);
		$recomended = 3; //суперкостыль
		
		$dots1 = $recomended+1;
		$dots2 = $m - $recomended;
			
		if ($n<=$m) {
			for ($i=1; $i<=$n; $i++) $result[$i]=$i;
			//echo '0<br>';
			return $result;
		} 
		
		$maxnum = $n-$recomended;
		$minnum = $recomended+1;
		$num3 = $m-2*($recomended+1);
		$pos3 = floor($m/2);
		$i=$pos3;
		$j = $pos3+1;
		$k=0;
		$var1 = $p;
		$var2 = $p+1;
		while ($k<$num3){
			$var = $k%2==0 ? $var1 : $var2;
			if ($var<=$minnum){
				$result = array();
				for ($tmp=1; $tmp<$dots2; $tmp++) $result[$tmp] = $tmp;
				$result[] = '...';
				//for ($tmp=$maxnum; $tmp<$n; $tmp++) $result[] = $tmp+1;
				for ($tmp=1; $tmp<$dots1; $tmp++) $result[] = $n-$dots1+$tmp+1;
				//echo '1<br>';
				break;
			}
			elseif ($var >= $maxnum){
				$result = array();
				for ($tmp=1; $tmp<$dots1; $tmp++) $result[$tmp] = $tmp;
				$result[] = '...';
				for ($tmp=1; $tmp<$dots2; $tmp++) $result[] = $n-$dots2+$tmp+1;
				//echo '2<br>';
				break;			
			}
			else{
				if ($k%2==0) {$arr[$i]=$var1; $i--; $var1--;}
				else {$arr[$j]=$var2; $j++; $var2++;}
				$k++;
				if ($k>=$num3){
					for ($tmp=1; $tmp<$dots1; $tmp++) $result[$tmp] = $tmp;
					$result[] = '...';
					for ($tmp=$i+1; $tmp<=$j-1; $tmp++) $result[] = $arr[$tmp];
					$result[] = '...';
					for ($tmp=1; $tmp<$dots1; $tmp++) $result[] = $n-$dots1+$tmp+1;
					//echo '3<br>';
					
				}
			}
		}

		foreach ($result as $k=>$v) {
			if (isset($result[$k-1])) if(isset($result[$k+1])) if (($v=='...') and ($result[$k-1]==$result[$k+1]-2)) $result[$k] = $result[$k+1]-1;  
		}
		
		//print_r($result);
		return($result);		
	}
	
 
  public function makeimg($uploadfile, $newname, $width, $uploaddir){
	$size=GetImageSize ($uploadfile);
	$mt = exif_imagetype($uploadfile);
	if ($mt==1) $src=imagecreatefromgif($uploadfile);
	elseif ($mt==3) $src=imagecreatefrompng($uploadfile);
	else $src=ImageCreateFromJPEG ($uploadfile);
	$iw=$size[0];
	$ih=$size[1];
	$koe=$iw/$width;
	$new_h=ceil ($ih/$koe);
	$dst=ImageCreateTrueColor ($width, $new_h);
	ImageCopyResampled ($dst, $src, 0, 0, 0, 0, $width, $new_h, $iw, $ih);

	if (!file_exists($uploaddir)) mkdir($uploaddir,0777);
	$uploadfile = $uploaddir . $newname;
	if ($mt==1) imageGIF($dst, $uploadfile, 100);
	elseif ($mt==3) imagePNG($dst, $uploadfile, 0, PNG_NO_FILTER);
	else ImageJPEG ($dst, $uploadfile, 100);
	
	imagedestroy($src);				  
  }
  
  public function getwUrl($text){
	  $signs = array(
	  'а' => 'a',   'б' => 'b',   'в' => 'v',
	  'г' => 'g',   'д' => 'd',   'е' => 'e',
	  'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	  'и' => 'i',   'й' => 'y',   'к' => 'k',
	  'л' => 'l',   'м' => 'm',   'н' => 'n',
	  'о' => 'o',   'п' => 'p',   'р' => 'r',
	  'с' => 's',   'т' => 't',   'у' => 'u',
	  'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	  'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	  'ь' => '' ,   'ы' => 'y',   'ъ' => '',
	  'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	  'А' => 'A',   'Б' => 'B',   'В' => 'V',
	  'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	  'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	  'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	  'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	  'О' => 'O',   'П' => 'P',   'Р' => 'R',
	  'С' => 'S',   'Т' => 'T',   'У' => 'U',
	  'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	  'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	  'Ь' =>  '',   'Ы' => 'Y',   'Ъ' => '',
	  'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya'
	  );
	  $str = strtr($text, $signs);
	  $str = strtolower($str);
	  $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
	  $str = trim($str, "-");
	  
	  if ($str=='') $str='wtf';
	  
	  return($str);
  }
	public function change_the_world($str, $sub){
      $db=new PDO('sqlite:db.sqlite'); 
	  $tmp=0;
	  $meg = $str;
	  while (TRUE){
		$sql1 = "SELECT id FROM cats WHERE sub=".$sub." AND url='".$meg."' LIMIT 1";
		$sql2 = "SELECT id FROM items WHERE cat=".$sub." AND url='".$meg."' LIMIT 1";
		$st = $db->query($sql1); $ar1 = $st->fetchAll();
		$st = $db->query($sql2); $ar2 = $st->fetchAll();
		if ((isset($ar1[0]['id']))or(isset($ar2[0]['id']))) {$tmp++; $meg=$str.$tmp;}
		else break;
	  }
	  $str = $tmp>0 ? $str.$tmp : $str;
	  return($str);
	}
  
	public function get_params($main_id){
	    $db=new PDO('sqlite:db.sqlite'); 
		$sql="SELECT params FROM settings WHERE 1 LIMIT 1";
		$st=$db->query($sql);
		$ar=$st->fetch();
		$str=$ar['params'];
		$settings=unserialize($str);
		return($settings);
	}
  
  public function get_pc(){
    return 30;
  }
  
  public function recdelete($id){
      $db=new PDO('sqlite:db.sqlite');
	  $sely = "DELETE FROM `items` WHERE cat =".$id."";
	  $quy=$db->exec($sely);
      $delete_query='DELETE FROM `cats` WHERE id='.$id."";;
	  $del=$db->exec($delete_query);
file_put_contents('deltest.txt', $id.' '.(int)$del);
	  $sel = "SELECT * FROM `cats` WHERE sub=".$id." LIMIT 10000";;
	  $qu=$db->query($sel);
	  $ccc=$qu->fetchAll();
	  if (!empty($ccc))
	    foreach($ccc as $k=>$scat){
		  $this->recdelete($scat['id']);
	    }

	  if ($del<=0) return 7;
	  return 6;
  }
  
  public function get_message($mes){
      $db=new PDO('sqlite:db.sqlite');
	  $strmes='';
	  if ($mes!=0) $strmes.= '';//start для оформления сообщения 		
      if ($mes==1) $strmes.= 'Запись успешно добавлена!<br/>';		
      elseif ($mes==2) $strmes.= 'Не удалось добавить запись!<br/>';		
      elseif ($mes==3) $strmes.= 'Изображение не добавлено!<br/>';		
      elseif ($mes==4) $strmes.= 'Категория успешно изменена!<br/>';		
      elseif ($mes==5) $strmes.= 'Не удалось изменить категорию!<br/>';		
      elseif ($mes==6) $strmes.= 'Каталог успешно удален!<br/>';		
      elseif ($mes==7) $strmes.= 'Не удалось удалить каталог!<br/>';		
      elseif ($mes==8) $strmes.= 'Товар успешно изменен!<br/>';		
      elseif ($mes==9) $strmes.= 'Не удалось изменить товар!<br/>';		
      elseif ($mes==10) $strmes.= 'Товар успешно удален!<br/>';		
      elseif ($mes==11) $strmes.= 'Не удалось удалить товар!<br/>';
	  elseif ($mes==31) $strmes.= 'Размер изображение превышает 5Мб!<br/>';	  
	  elseif ($mes==32) $strmes.= 'Изображение имеет неверный формат!<br/>';	  
	  if ($mes!=0) $strmes.= '';//end		
	  return $strmes;
  }
  
  public function get_error($mes){
	  if (($mes==2)or($mes==3)or($mes==5)or($mes==7)or($mes==9)or($mes==11)or($mes==31)or($mes==32)) return $mes;
	  return 0;
  }
  
  public function get_category($sub){
        $db=new PDO('sqlite:db.sqlite');
		$sel='SELECT * FROM "cats" WHERE id='.$sub.' LIMIT 1';
		$st=$db->query($sel);
		$category_array=$st->fetch();
		if (!empty($category_array)) $category=$category_array['name'];
		else $category='Каталог';
        return $category; 		
  }

  public function get_item_category($id){
        $db=new PDO('sqlite:db.sqlite');
		$sel='SELECT * FROM "items" WHERE id='.$id.' LIMIT 1';
		$st=$db->query($sel);
		$item=$st->fetch();
		$sub=$item['cat'];
		$sel='SELECT * FROM "cats" WHERE id='.$sub.' LIMIT 1';
		$st=$db->query($sel);
		$category_array=$st->fetch();		
		if (!empty($category_array)) $category=$category_array['name'];
		else $category='Каталог';
        return $category; 		
  }
  public function get_counts_goods($sub){
      $db=new PDO('sqlite:db.sqlite');
	  $sql = "SELECT COUNT(cat) AS numcat FROM items WHERE cat=".$sub;
	  $st = $db->query($sql);
	  $arr = $st->fetch();
	  if (!empty($arr)) return $arr['numcat'];
	  return 0;
  }
  
  public function count_rec_goods($sub){
      $db=new PDO('sqlite:db.sqlite');
	  $cr=0;
	  $sel='SELECT id FROM "items" WHERE cat='.$sub." LIMIT 10000";;
	  $st=$db->query($sel);
	  $cr+=count($st->fetchAll());
	  
	  $sel='SELECT id FROM "cats" WHERE sub='.$sub." LIMIT 10000";;
	  $st=$db->query($sel);
	  while ($subcat=$st->fetch()){
	    $cr+=$this->count_rec_goods($subcat['id']);
	  }
	  return $cr;
  }
  
  public function get_pgs($sub){
        $db=new PDO('sqlite:db.sqlite');
		$pc=$this->get_pc();
	    $sql = "SELECT COUNT(sub) AS numcat FROM cats WHERE sub=".$sub;
	    $st = $db->query($sql);
	    $arr = $st->fetch();
		if (!empty($arr)) return ceil($arr['numcat']/$pc);
		return 0;
  }
  
  public function get_page_cats($sub,$page){
        $db=new PDO('sqlite:db.sqlite');
		$pc=$this->get_pc();
		$lim=$pc*($page-1);
  		$sel='SELECT * FROM "cats" WHERE sub='.$sub.' ORDER BY sort LIMIT '.$lim.','.$pc;
		$st=$db->query($sel);
		$news_all=$st->fetchAll();
		$news=array();
		foreach ($news_all as $k=>$v){
		  $news[]=$news_all[$k];
		}
		foreach ($news as $k=>$v){
		  $kid=$news[$k]['id'];
		  $news[$k]['count_goods']=$this->count_rec_goods($kid);
		}
		return ($news);
  }

  public function get_pgs_goods($sub){
        $db=new PDO('sqlite:db.sqlite');
		$pc=$this->get_pc();
  		if ($sub==0){
		  $sel="SELECT COUNT(id) as pgs FROM items";
		  $st=$db->query($sel);
		  $news_all=$st->fetch();
		  $pgs=!empty($news_all)?ceil($news_all['pgs']/$pc):0;
		}
		else{
		  $news_all = $this->get_all_goods($sub);
		  $pgs=!empty($news_all)?ceil(count($news_all)/$pc):0;
		}
		return $pgs;
  }

  public function get_all_goods($sub){
    $db=new PDO('sqlite:db.sqlite');
	$arr=array();

	$sql='SELECT * FROM "items" WHERE cat='.$sub." LIMIT 10000";;
	$s1=$db->query($sql);
	while ($new_g=$s1->fetch()){
	  $arr[]=$new_g;
	}
	$sql='SELECT * FROM "cats" WHERE sub='.$sub." LIMIT 10000";;
	$s2=$db->query($sql);
	while ($new_c=$s2->fetch()){
	  $arr=array_merge($arr,$this->get_all_goods($new_c['id']));
	}
	return $arr;	
  }
  
  public function get_page_goods($sub,$page){
        $db=new PDO('sqlite:db.sqlite');		
		$pc=$this->get_pc();
  		if ($sub==0){
		  $sel='SELECT * FROM "items"';
		  $st=$db->query($sel);
		  $news_all=$st->fetchAll();
		}
		else{
		  $news_all = $this->get_all_goods($sub);
		}  
		$ost=count($news_all)%$pc;
		$pgs=(count($news_all)-$ost)/$pc;
		if ($ost!=0) $pgs+=1;		
		$start=$pc*($page-1);
		$finish=$start+$pc;		
		$news=array();
		for ($i=$start; ($i<$finish)and($i<count($news_all)); $i++){
		  $news[]=$news_all[$i];
		}		
		foreach ($news as $k=>$v){
		  $kid=$news[$k]['id'];
		  $news[$k]['category']=$this->get_item_category($kid);
		}
		return ($news);
  }

  function get_cats(){
        $db=new PDO('sqlite:db.sqlite');		
		$sql='SELECT * FROM "cats" ORDER BY "name"';
	    $st=$db->query($sql);
        return $st->fetchAll();
  }
}