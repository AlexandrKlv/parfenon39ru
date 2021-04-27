<div id="content" class="users login" ">

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
      <form method="POST" action="">
        <div class="form-group main-form" style="margin-top: 20px; border-radius: 10px; margin-bottom: 20px;>
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
       
       
       
       
       
       <?php if ($captcha) { ?>
       <div class="captcha-block">
        <img src="<?php echo $src_captcha; ?>">
        <label>Введите символы с картинки:</label>
        <input required class="captcha" type="text" name="captcha" value="">
      </div>
      <?php } ?>
      
<!-- <div style="text-align: center;  width: 100%; height: 50px;" class="form-group">
        <input type="submit" name="users_login" value="Войти">
      </div> -->
      <div style="text-align: center" class="form-group">
        <input type="submit" class="btn btn-success" name="users_login" value="Войти">
      </div>
      </div>
  </form>
</div>
</div>