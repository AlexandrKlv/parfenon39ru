<div id="content" class="users register">
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

 
 <form  method="post" action="#">
 
 



 


    <div class="container">
 <div class="row main-form" style="margin-top: 20px; border-radius: 10px; margin-bottom: 20px;>
    <form method="POST" action="" class="h-100 w-100">

<div class="form-group">
 <label for="name" class="cols-sm-2 control-label">Логин</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
 <input class="form-control" placeholder="Введите Логин" required type="text" name="login" value="<?php echo $login; ?>">
 </div>
 </div>
 </div>

 <div class="form-group">
 <label for="email" class="cols-sm-2 control-label">Ваш Email</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
 <input required class="form-control"  placeholder="Введите ваш Email" type="email" name="email" value="<?php echo $email; ?>">
 </div>
 </div>
 </div>
 <div class="form-group">
 <label for="username" class="cols-sm-2 control-label">Имя</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
 <input required class="form-control" placeholder="Введите ваше имя" type="text" name="username" value=""> 
 </div>
 </div>
 </div>

 <div class="form-group">
 <label for="password" class="cols-sm-2 control-label">Пароль</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
 <input required class="form-control"  placeholder="Введите ваш пароль" type="password" name="password" value="">
 </div>
 </div>
 </div>

 <div class="form-group">
 <label for="confirm" class="cols-sm-2 control-label">Повтор пароля</label>
 <div class="cols-sm-10">
 <div class="input-group">
 <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
 <input required class="form-control" placeholder="Повторите ваш пароль" type="password" name="password_2" value="">
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
      
      <div style="text-align: center; width: 100%; " class="form-group">
        <input class="btn btn-primary" type="submit" name="users_register" value="Зарегистрироваться" >
      </div>
    </form>
  </div>
</div>