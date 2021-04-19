<?php
if (!$blocks) {
    return false;
}
?>
<div class="what-do-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <h2 data-aos="fade-right" data-aos-duration="1000" class="aos-init aos-animate center-hr text-uppercase"><?php echo $page_section['page_section_name']; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 col-12 ml-auto mr-auto">
                <div class="row mt-3">   
                    <?php
                    foreach ($blocks as $block) {
                        echo $block['compiled'];
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>