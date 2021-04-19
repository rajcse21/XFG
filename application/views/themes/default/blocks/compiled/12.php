<div class="{COL_LARGE} {COL_MED} {COL_SMALL} {COL_X_SMALL} {COL_LARGE_PADDING} {COL_MED_PADDING} {COL_SMALL_PADDING} {COL_X_SMALL_PADDING}  {BLOCK_CLASS}  text-center" data-blockid="{BLOCK_ID}" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="text-uppercase mt-2 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000"><?php echo $block_title; ?></h2>
    <?php echo $block_content; ?>
    <?php if ($block_link) { ?> <p class="mb-0"><a class="btn btn-primary text-uppercase btn-brown btn-animation py-2 border-radius" href="<?php echo $block_link; ?>" role="button"><?php echo $page_block_link_text != '' ? $page_block_link_text : 'Learn More'; ?></a></p><?php } ?>
</div>