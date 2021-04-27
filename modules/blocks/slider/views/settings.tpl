<style type="text/css">
  #module_settings span, #add_slide_header span {border-bottom: 1px dashed; cursor: pointer;}
</style>
<h4 id="module_settings"><span>Настройки слайдера</span></h4>
<div id="module_settings_container" style="display: none;">
  
  <label for="s_width">Ширина</label><br />
  <input id="s_width" type="text" name="width" value="<?php echo $settings['width']; ?>"><br />

  <label for="s_height">Высота</label><br />
  <input id="s_height" type="text" name="height" value="<?php echo $settings['height']; ?>"><br />

  <label for="s_auto">Автостарт</label>
  <?php if((bool)$settings['auto']) { ?>
  <input id="s_auto" type="checkbox" name="auto" value="1" checked ><br />
  <?php } else { ?>
  <input id="s_auto" type="checkbox" name="auto" value="1"><br />
  <?php } ?>

  <label for="s_duration">Продолжительность показа слайда (в миллисекундах: 1000 = 1 сек.)</label><br />
  <input id="s_duration" type="text" name="interval" value="<?php echo $settings['interval']; ?>"><br />

  <label for="s_duration">Скорость прокрутки слайда (в миллисекундах: 1000 = 1 сек.)</label><br />
  <input id="s_duration" type="text" name="duration" value="<?php echo $settings['duration']; ?>"><br />
</div>
<?php if($edit_slide) { ?>
<div class="slide_form">
  <img width="160" src="<?php echo $edit_slide['src']; ?>">
  <textarea name="slide_text"><?php echo $edit_slide['text']; ?></textarea>
  <input type="text" name="slide_sort" value="<?php echo $edit_slide['sort']; ?>">
</div>
<?php } else { ?>
  <?php if($slides) { ?>
  <div class="module_images">
    <table class="main">
      <tr>
        <th>Изображение</th>
        <th>Текст</th>
        <th>Порядок <br> сортировки</th>
        <th>Действия</th>
      </tr>
    <?php foreach($slides as $slide) { ?>
      <tr>
        <td><img width="100" src="<?php echo $slide['src']; ?>"></td>
        <td><?php echo $slide['text']; ?></td>
        <td><?php echo $slide['sort']; ?></td>
        <td>
          <a href="<?php echo SITE_URL . '/admin/modules_manager/settings/' . $active_module_id . '/edit_slide=' . $slide['id']; ?>">Изменить</a> |
          <a href="<?php echo SITE_URL . '/admin/modules_manager/settings/' . $active_module_id . '/del_slide=' . $slide['id']; ?>">Удалить</a>
        </td>
      </tr>
    <?php } ?>
    </table>
  </div>
  <?php } ?>
  <h4 id="add_slide_header"><span>Добавить слайд</span></h4>
  <div id="add_slide_container" class="slide_form" style="display: none;">
		<label for="name">Изображение</label>
    <input type="file" name="slide_img">
		<label for="name">Текст</label>
    <textarea name="slide_text"></textarea>
		<label for="name">Порядок сортировки</label>
    <input type="text" name="slide_sort" value="1">
  </div>
<?php } ?>
<script type="text/javascript">
  $('#module_settings span').click(function() {
    if(!$('#module_settings_container:animated').length) {
      if( $('#module_settings_container').is(':visible')) {
        $('#module_settings_container').slideUp();
      } else {
        $('#module_settings_container').slideDown();
      }
    }
  });
  
  $('#add_slide_header span').click(function() {
    if(!$('#add_slide_container:animated').length) {
      if( $('#add_slide_container').is(':visible')) {
        $('#add_slide_container').slideUp();
      } else {
        $('#add_slide_container').slideDown();
      }
    }
  });
</script>
