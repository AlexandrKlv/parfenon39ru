<div class="u-slider">
  <div id="jFlowCredits<?php echo $module_id; ?>"></div>
  <div id="container<?php echo $module_id; ?>" class="slider-container">
  <div id="mySlides<?php echo $module_id; ?>">
  <?php foreach($slides as $slide) { ?>
      <div id="slide<?php echo $slide['id']; ?>">    
          <img src="<?php echo $slide['image']; ?>" alt="" />
          <span><?php echo $slide['text']; ?></span>
    </div>
  <?php } ?>
  </div>

  <div id="myController<?php echo $module_id; ?>" class="slider-controller">
    <?php foreach ($slides as $slide) { ?>
    <span class="jFlowControl"></span>
    <?php } ?>
  </div>

  <span class="jFlowPrev"><div></div></span>
  <span class="jFlowNext"><div></div></span>
  </div>
</div>
