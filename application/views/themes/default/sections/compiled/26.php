<div class="site-banner">
            <div class="slideshow cycle-slideshow" data-cycle-swipe="true" data-cycle-swipe-fx="fade" data-cycle-slides="> div.slide-banner" data-cycle-next=".next" data-cycle-prev=".prev"  data-cycle-auto-height="container" data-cycle-speed="1000" data-cycle-timeout="5000">
          <?php
		if ($blocks) {
			foreach ($blocks as $block) {
				echo $block['compiled'];
			}
		}
		?>
		 <?php if(count($blocks)>1){?> 
		   <div class="cycle-pager"></div>
                <a class="prev"></a> <a class="next"></a>
	     <?php }?>
            </div>
        </div>