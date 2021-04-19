<div class="{COL_LARGE} {COL_MED} {COL_SMALL} {COL_X_SMALL} {COL_LARGE_PADDING} {COL_MED_PADDING} {COL_SMALL_PADDING} {COL_X_SMALL_PADDING}  {BLOCK_CLASS} text-center calc_wrapper" data-blockid="{BLOCK_ID}">
    
        <?php if ($block_image) { ?>  
		  <div class="img-boxs">
            <img src="<?php echo $block_image; ?>" class="img-fluid" data-aos="flip-left" data-aos-duration="1000"/>
			   </div>
        <?php
	} ?>
    <div class="text-section">
        <h3><?php echo $block_title; ?></h3>
        <div class="calc_text"><?php echo $block_content; ?></div>
		  <?php if($block_link){ ?>  <a class="btn btn-link text-uppercase btn-animation py-2" href="<?php echo $block_link; ?>" role="button"><?php echo $page_block_link_text!=''? $page_block_link_text :'Learn More'; ?></a><?php } ?>
    </div>
</div>