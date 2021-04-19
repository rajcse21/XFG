<?php
		$mobile_img = '<img src="'. $block_image.'" class="img-fluid d-block d-lg-none large-slide"/>';
		if ($block_image_small) {
		  $mobile_img='<div style="background: url('.$block_image_small.');" class="d-block d-lg-none mobile-banner"></div>';		
		}
		?>
<div class="slide-banner">
                    <img src="<?php echo $block_image; ?>" class="img-fluid d-none d-lg-block large-slide"/>
                   <?php echo $mobile_img;?>
					  <?php if($block_title!='' || $block_content!=''){ ?>
                    <div class="slideshow-text">
                        <div class="container d-flex align-items-center h-100">
                            <div class="row w-100">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                  <?php if($block_title!=''){ ?>  <h1 class="shadow-head"><?php echo $block_title; ?></h1><?php } ?>
                                    <?php echo $block_content; ?>
                                  <?php if($block_link){ ?>  <a class="btn btn-primary text-uppercase btn-brown btn-animation py-2 border-radius" href="<?php echo $block_link; ?>" role="button"><?php echo $page_block_link_text!=''? $page_block_link_text :'Learn More'; ?></a><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div><?php } ?>
                </div>