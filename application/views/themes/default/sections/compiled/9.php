<?php
$bank_logos = $this->common->listBanklogos();
if (!$bank_logos) {
    return '';
}
?>
<div class="compare-loans py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <h2 class="text-uppercase center-hr" data-aos="fade-left" data-aos-duration="1000"><?php echo $page_section['page_section_name']; ?></h2>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="compare-wrap">
                    <div class="compare-inner owl-carousel owl-theme">
                        <?php
                        $chunk_logos = array_chunk($bank_logos, 2);
                        foreach ($chunk_logos as $bank_logos) {
                            ?>
                            <div class="compare-box">
                                <div class="row">
                                    <?php foreach ($bank_logos as $bank_logo) { ?>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><a class="logo-bg"><img src="<?php echo $bank_logo['bank_logo']; ?>"></a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>