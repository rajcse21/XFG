<div class="advisor-specialist <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> old_py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <h2 class="center-hr text-uppercase aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000"><?php echo $page_section['page_section_name']; ?></h2>
            </div>
            <?php
            foreach ($blocks as $block) {
                echo $block['compiled'];
            }
            ?>
        </div>
    </div>
</div>