<div class="container <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> class_pt-4 class_pt-md-5">
    <div class="row mb-4 mb-md-5">
        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12 mr-auto ml-auto">
            <div class="contact-address">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-center border-bottom border-right p-4 address-col">
                        <p><img src="assets/themes/default/images/common/contact-phone.png" class="img-fluid" alt="Talk To Us" title="Talk To Us"></p>
                        <h3>TALK TO US</h3>
                        <p><a class="text-black" href="tel:+<?php echo $this->core->CONFIG_PHONE; ?>"><?php echo $this->core->CONFIG_PHONE; ?></a></p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-center border-bottom p-4 address-col">
                        <p><img src="assets/themes/default/images/common/contact-email.png" class="img-fluid" alt="Contact Us" title="Contact Us"></p>
                        <h3>CONTACT US</h3>
                        <p><a href="mailto:<?php echo $this->core->CONFIG_EMAIL; ?>"><?php echo $this->core->CONFIG_EMAIL; ?></a></p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-center border-right p-4 address-col">
                        <?php if ($this->core->CONFIG_FACEBOOK) { ?> 
                            <p>
                                <a href="<?php echo $this->core->CONFIG_FACEBOOK; ?>" target="_blank">
                                    <img src="assets/themes/default/images/common/icon-facebook.png" class="img-fluid" alt="Facebook" title="Facebook">
                                </a>
                            </p>
                            <h3>Facebook</h3>
                            <p>Follow Us On <a href="<?php echo $this->core->CONFIG_FACEBOOK; ?>" target="_blank">Facebook</a></p>
                        <?php } ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-center p-4 address-col">
                        <?php if ($this->core->CONFIG_TWITTER) { ?>
                            <p>
                                <a href="<?php echo $this->core->CONFIG_TWITTER; ?>" target="_blank">
                                    <img src="assets/themes/default/images/common/twitter-icon.png" class="img-fluid" alt="Twitter" title="Twitter">
                                </a>
                            </p>
                            <h3>Twitter</h3>
                            <p>Follow Us On <a href="<?php echo $this->core->CONFIG_TWITTER; ?>" target="_blank">Twitter</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>