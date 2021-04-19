<div class="{COL_LARGE} {COL_MED} {COL_SMALL} {COL_X_SMALL} {COL_LARGE_PADDING} {COL_MED_PADDING} {COL_SMALL_PADDING} {COL_X_SMALL_PADDING}  {BLOCK_CLASS}  ml-auto mr-auto" data-blockid="{BLOCK_ID}">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="advisor-img" data-aos="fade-right" data-aos-duration="1000">
                <?php if ($block_image) { ?> 
                    <img src="<?php echo $block_image; ?>" class="img-fluid"/>
                <?php } ?>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" data-aos="fade-left" data-aos-duration="1000">
            <?php if($block_title){?><h3 class="text-uppercase mt-4 mt-sm-0"><?php echo $block_title; ?></h3><?php } ?>
            <?php echo $block_content; ?>
            <?php $block_title; ?>
            <?php if ($block_link) { ?>  <p><a class="btn btn-primary text-uppercase btn-brown btn-animation py-2 border-radius" href="<?php echo $block_link; ?>" role="button"><?php echo $page_block_link_text != '' ? $page_block_link_text : 'Learn More'; ?></a></p><?php } ?>
        </div>
    </div>
</div>