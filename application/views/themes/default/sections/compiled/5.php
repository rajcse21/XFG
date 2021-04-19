<?php
$params=['limit'=>5,'sort'=>'random'];
$testimonials = $this->Pagemodel->getAllPages(2, 'testimonials');
if (!$testimonials) {
    return false;
}
?><div class="customers-section py-5" style="background: url(<?php echo $page_section['page_section_background'] ? $page_section['page_section_background'] : 'assets/themes/default/images/homepage/customers-bdg.jpg'; ?>)">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 ml-auto mr-auto text-center">
                <h2 class="center-hr text-uppercase aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000"><?php echo $page_section['page_section_name']; ?></h2>
                <div class="slideshow cycle-slideshow" data-cycle-swipe="true" data-cycle-swipe-fx="fade" data-cycle-slides="> div.slide-test" data-cycle-auto-height="calc" data-cycle-speed="1000" data-cycle-timeout="30000">
                    <?php foreach ($testimonials as $testimonial) { ?>
                        <div class="slide-test">               
                            <p class="font-22 testimonial_content" data-aos="fade-right" data-aos-duration="1000"><?php echo word_limiter($testimonial['page_content'],70,'...<a class="btn btn-link p-0" href="reviews">Read More</a>'); ?></p>
                            <p class="title-name font-22" data-aos="fade-left" data-aos-duration="1000"><?php echo $testimonial['page_title']; ?></p>
                        </div>
                    <?php }
                    ?>
                    <div class="cycle-pager"></div>
                </div>
            </div>
        </div>
    </div>
</div>