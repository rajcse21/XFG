<?php
$mobile_img = '';
if ($block_image_small) {
    $mobile_img = '<img src="' . $block_image_small . '" class="img-fluid d-block d-sm-none"  data-aos="fade-up" data-aos-duration="1000">';
}
?>
<div class="{COL_LARGE} {COL_MED} {COL_SMALL} {COL_X_SMALL} {COL_LARGE_PADDING} {COL_MED_PADDING} {COL_SMALL_PADDING} {COL_X_SMALL_PADDING}  {BLOCK_CLASS} text-center" data-blockid="{BLOCK_ID}">
    <div class="card first">
        <div class="card-icon">
            <?php if ($block_image) { ?>  
                <img src="<?php echo $block_image; ?>" class="img-fluid" data-aos="fade-up" data-aos-duration="1000"/>
            <?php } ?>  </div>

        <?php echo $mobile_img; ?>
        <div class="card-title"><?php echo $block_title; ?></div>
    </div>
</div>