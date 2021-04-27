<div class="feedback"><?php //echo $plugin['id']; ?>
  <form action="#plugin-feedback-<?php echo $plugin_id; ?>" method="POST"><div class="feedback">
    <a name="plugin-feedback-<?php echo $plugin_id; ?>"></a>
  <?php if ($success) { ?>
  <div class="notice success" text-align="center"><?php echo $success; ?><!-- <META HTTP-EQUIV="REFRESH" CONTENT="3;URL=http://www.zaozerie39.ru/"> --> </div>
  <?php } else { ?>
    <?php foreach ($fields as $i => $field) { ?>
      <div >
        <?php if ($field['type'] == 'text') { ?>
          <!-- <label for="<?php echo $field['name']; ?>"><?php //echo $field['label']; ?></label>

           -->
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <input style="width:96%" id="<?php echo $field['name']; ?>" type="text" name="<?php echo $field['name']; ?>"value="<?php 
          if(isset($_SESSION['feedback_success_'.$plugin['id']]) or isset($_POST['feedback_'.$plugin['id'].'_submit'])) { echo $field['value'];}?>" <?php if ($field['required']) { ?>required<?php } ?> placeholder="<?php echo $field['label'];?>">
        
        <?php } elseif ($field['type'] == 'textarea') { ?>
          <!-- <label for="<?php echo $field['name']; ?>"><?php //echo $field['label']; ?></label> -->
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <textarea style="width:96%" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>"
            placeholder="<?php echo $field['label']; ?>"><?php if(isset($_SESSION['feedback_success_'.$plugin['id']]) or isset($_POST['feedback_'.$plugin['id'].'_submit'])) { echo $field['value'];}?></textarea>
          
        <?php } elseif ($field['type'] == 'select') { ?>
          <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <select id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>">
            <?php foreach ($field['option_list'] as $option) { ?>
              <?php if ($option == $field['value']) { ?>
              <option value="<?php echo $option; ?>" selected><?php echo $option; ?></option>
              <?php } else { ?>
              <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
              <?php } ?>
            <?php } ?>
          </select>
          
        <?php } elseif ($field['type'] == 'checkbox') { ?>
          <label for="<?php echo $field['name']; ?>" class="checkbox-label"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <?php if ($field['value']) { ?>
          <input id="<?php echo $field['name']; ?>" type="checkbox" name="<?php echo $field['name']; ?>" value="1" checked >
          <?php } else { ?>
          <input id="<?php echo $field['name']; ?>" type="checkbox" name="<?php echo $field['name']; ?>" value="1">
          <?php } ?>
          
        <?php } elseif ($field['type'] == 'captcha') { ?>
        <!-- <label for="<?php echo $field['name']; ?>"><?php //echo $field['label']; ?></label> нижний лэйбл норм-->
        <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
        <!-- <div id="gcapt" class="g-recaptcha" data-sitekey="6LepbwATAAAAAD5LvkhHWn57S26NhJxectKd1uoq"></div> гуглокапча фигово себя показала-->
            <label>Введите символы с картинки:
            </label>
            <input type="text" name="captcha" value="" style="width:120px;">
            <img src="<?php echo $src_captcha; ?>" width="130px" height="30px" align="right">
        <?php } elseif ($field['type'] == 'submit') { ?>
          <input style="width:300px" type="submit" name="<?php echo $field['name']; ?>" value="<?php echo $field['label']; ?>">
        <?php } ?>
        
      </div>
    <?php } ?>
  <?php } ?></div>
  </form>
</div>