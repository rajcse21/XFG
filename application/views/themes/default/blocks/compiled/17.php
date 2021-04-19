<div class="{COL_LARGE} {COL_MED} {COL_SMALL} {COL_X_SMALL} {COL_LARGE_PADDING} {COL_MED_PADDING} {COL_SMALL_PADDING} {COL_X_SMALL_PADDING}  {BLOCK_CLASS} pb-3" data-blockid="{BLOCK_ID}">
    <div class="card border-secondary p-4">
        <h3><?php echo $block_title; ?></h3>
      <div class="calc_text"> <?php echo $block_content; ?></div>
        <?php if ($block_link) { ?>
            <p class="px-2"> 
                <a href="<?php echo $block_link; ?>" target="_blank" class="btn btn-primary text-uppercase btn-brown btn-animation py-2 border-radius"><?php echo $link_text != '' ? $link_text : 'Calculate'; ?></a></p>
        <?php } ?>
    </div>
</div>