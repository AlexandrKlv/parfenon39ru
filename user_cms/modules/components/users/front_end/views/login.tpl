<div id="content" class="users login">
  <h1><?php echo $page_name; ?></h1>
  <p class="bread_crumbs"><?php echo $breadcrumbs; ?></p>
  <div id="register_form">
    <?php if ($errors) { ?>
    <div class="notice errors">
      <?php foreach ($errors as $error) { ?>
      <?php echo $error; ?><br>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="container">
    <div class="row main-form">
    <form method="POST" action="">
      <div class="form-group">
 <label for="name" class="cols-sm-2 control-label">Имя пользователя:</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
 <input class="form-control" placeholder="Введите Логин" required type="text" name="login" value="<?php echo $login; ?>">
 </div>
 </div>
 <label for="name" class="cols-sm-2 control-label">Пароль:</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
 <input class="form-control" placeholder="Введите пароль" required type="password" name="password" value="">
 </div>
 </div>
 </div>
 
      
      
      
      <?php if ($captcha) { ?>
      <div class="captcha-block">
        <img src="<?php echo $src_captcha; ?>">
        <label>Введите символы с картинки:</label>
        <input required class="captcha" type="text" name="captcha" value="">
      </div>
      <?php } ?>
      
<div style="text-align: center;  width: 100%; height: 50px;" class="form-group">
        <input class="primary" style="  width: 100%; height: 50px;" type="submit" cl name="users_login" value="Войти">
      </div>

    </form>
  </div>
</div>