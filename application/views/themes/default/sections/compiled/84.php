<?php
$testimonials = $this->Pagemodel->getAllPages(2, 'testimonials');
if (!$testimonials) {
    return false;
}
?>
<div class="container <?php echo 'global_sec_' . $page_section['global_section_id'] . ' ' . $page_section['page_section_class']; ?> class_py-5 class_text-center">
  <div class="calc_wrapper">
    <?php
    $chunk_testimonials = array_chunk($testimonials, 2);
    foreach ($chunk_testimonials as $testimonials) {
        ?>
        
            <div class="row mt-3">
                <?php foreach ($testimonials as $testimonial) { ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-0 pb-3">
                        <div class="card border-secondary p-4">        
                            <div class="calc_text"><?php echo $testimonial['page_content']; ?></div>
                            <h3 class="text-right"><?php echo $testimonial['page_title']; ?></h3>
                        </div>
                    </div>
				<?php } ?>
            </div>
        
    <?php }
    ?>  
	  </div>
</div>