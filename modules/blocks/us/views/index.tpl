<?php if (isset($us['login'])) { ?>
	<div class="h3 btn btn-light" style="float:left; margin-right: 10px;">Вы вошли как <?php echo $us['login']; ?></div>
	
	<div class="h3" style="float:left;"><a class="btn btn-primary" href="<?php echo SITE_URL . '/users/logout'?>">Выход</a></div>
	<div style="clear:both"></div>
<?php } else { ?>
	<div class="h3" style="float:left;"><a class="btn btn-primary" href="<?php echo SITE_URL . '/users/login'?>" style="color: white;">Вход</a></div>
	<div class="h3" ><a class="btn btn-primary" href="<?php echo SITE_URL . '/users/register'?>">Регистрация</a></div>
	<div class="h3" style="clear:both"></div>
<?php } ?>
<div style="position: relative; height: 40px; width: 200px; float: left;"><a class="btn btn-secondary" href="<?php echo SITE_URL . '/realty/add'?>"><div class="estateContinue">Подать объявление</div></a></div>
<div style="position: relative; height: 70px; width: 350px; float: left;"><a class="btn btn-danger" href="<?php echo SITE_URL . '/novosti/novosti-39'?>"><div class="estateContinue">Оценка недвижимости, машин, ущерба</div></a></div>