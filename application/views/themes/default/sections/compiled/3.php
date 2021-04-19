<?php
if (!$blocks) {
    return false;
}
?>
<div class="blue-box-hm">
    <div class="container">
        <div class="row no-gutters">
            <?php
            $count = 0;
			
            foreach ($blocks as $block) {
                $count++;
                $mobile_img = '';
			  $a_start='';
			$a_end='';
			  if($block['block_link']!=''){
			 	$a_start='<a href="'.$block['block_link'].'">';
			    $a_end='</a>';
				 }
                $aos = $count%2==0?'up':'down';
                if ($block['block_image_small']) {
                    $mobile_img = '<img src="' . $block['block_image_small'] . '" class="img-fluid d-block d-lg-none"  data-aos="fade-' . $aos . '" data-aos-duration="1000">';
                }
                ?>
                <div class="<?php echo 'col-xl-' . $block['block_col_lg'] . ' col-lg-' . $block['block_col_md'] . ' col-md-' . $block['block_col_sm'] . ' col-sm-' . $block['block_col_xs'] . ' col-xl-offset-' . $block['block_col_lg_padding'] . ' col-lg-offset-' . $block['block_col_md_padding'] . ' col-md-offset-' . $block['block_col_sm_padding'] . ' col-sm-offset-' . $block['block_col_xs_padding'] . ' ' . $block['block_css_class']; ?> text-center" data-blockid="<?php echo $block['page_block_id']; ?>">
                    <div class="card <?php echo $count == 1 ? 'first' : ''; ?>">
                        <div class="card-icon">
                            <?php if ($block['block_image']) { ?>  
                           <?php echo $a_start;?>
							 <img src="<?php echo $block['block_image']; ?>" class="img-fluid" data-aos="fade-<?php echo $aos; ?>" data-aos-duration="1000"/> 							   <?php echo $a_end;?> 
                            <?php } ?>  
                        </div>                        
                        <div class="card-title"><?php echo $a_start.''.$block['block_title'].''.$a_end; ?></div>
                    </div>
                </div>
            <?php }
            ?>
        </div>

    </div>
</div>