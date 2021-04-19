<div id="da-slider" class="site-banner">
			<div class="slideshow cycle-slideshow" data-cycle-swipe="true" data-cycle-swipe-fx="fade" data-cycle-slides="> div.slide-banner" data-cycle-next=".next" data-cycle-prev=".prev"  data-cycle-auto-height="container" data-cycle-speed="1000" data-cycle-timeout="5000">
				<div class="slide-banner">
					<img src="<?php echo $page_section['page_section_img_small']?$page_section['page_section_img_small']:$page_section['page_section_background']; ?>" class="img-fluid d-none d-lg-block large-slide" data-paroller-factor="0.7"/>
					<div style="background: url(<?php echo $page_section['page_section_background']; ?>);" class="d-block d-lg-none mobile-banner" data-paroller-factor="0.7"></div>
					<div class="slideshow-text">
						<div class="container d-flex align-items-center h-100">
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
									<div class="sl-text-center">
									<h1 class="shadow-head"><?php echo $page_section['page_section_name']; ?></h1>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>