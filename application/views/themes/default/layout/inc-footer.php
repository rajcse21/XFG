<div class="footer-content py-5">    <div class="container">        <div class="row">            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">                <?php echo $this->cmscore->renderGlobalBlock('contact-info');?>                                <p>E: <a href="mailto:<?php echo $this->core->CONFIG_EMAIL;?>"><?php echo $this->core->CONFIG_EMAIL;?></a><br>                    Call Us: <a href="tel:<?php echo $this->core->CONFIG_PHONE;?>"><?php echo $this->core->CONFIG_PHONE;?></a></p>                <div class="social-box">                   <?php if ($this->core->CONFIG_FACEBOOK) { ?> <div class="icons"><a href="<?php echo $this->core->CONFIG_FACEBOOK;?>" target="_blank"><i class="demo-icon icon-facebook"></i></a></div><?php } ?>                    <?php if ($this->core->CONFIG_TWITTER) { ?><div class="icons"><a href="<?php echo $this->core->CONFIG_TWITTER;?>" target="_blank"><i class="demo-icon icon-twitter"></i></a></div><?php } ?>                   <?php if ($this->core->CONFIG_EMAIL) { ?> <div class="icons"><a href="mailto:<?php echo $this->core->CONFIG_EMAIL;?>" target="_blank"><i class="demo-icon icon-mail-alt"></i></a></div><?php } ?>                    <?php if ($this->core->CONFIG_LINKED_IN) { ?><div class="icons"><a href="<?php echo $this->core->CONFIG_LINKED_IN;?>" target="_blank"><i class="demo-icon icon-linkedin"></i></a></div><?php } ?>                </div>            </div>            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">                <h3 class="text-uppercase ml-lg-5 mt-4 mt-md-0">USEFUL LINKS</h3>                <?php                $params = array(                    'menu_alias' => 'footer-menu',                    'ul_format' => '<ul class="ml-lg-5">{MENU}</ul>',                    'level_1_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>',                    'level_2_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>'                );                echo $this->html->menu($params);                ?>                            </div>            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3 mt-lg-0">                <h3 class="text-uppercase ml-lg-5 mt-4 mt-md-0">OUR SPECIALS</h3>                <?php                $params = array(                    'menu_alias' => 'footer-our-specials',                    'ul_format' => '<ul class="ml-lg-5">{MENU}</ul>',                    'level_1_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>',                    'level_2_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>'                );                echo $this->html->menu($params);                ?>            </div>            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-3 mt-lg-0">                <h3 class="text-uppercase">Location</h3>                <?php echo $this->core->CONFIG_LOCATION_MAP;?>            </div>        </div>    </div></div><div class="container">    <div class="row py-3">        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">Copyright © <?php echo date('Y');?>.  <?php echo config_item('SITE_NAME');?>. All right reserved.</div>    </div></div>