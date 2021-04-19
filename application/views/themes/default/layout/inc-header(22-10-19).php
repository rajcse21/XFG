<div class="site-top">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-9 col-sm-12 col-12 d-none d-md-block">
                <div class="d-inline-block"><a target="_blank" href="https://goo.gl/maps/EmWnuoh1JQfgDD4E6"><i class="demo-icon icon-location"></i><?php echo $this->core->CONFIG_ADDRESS; ?></a></div>
                <div class="d-inline-block ml-2"><a href="contact-us"><i class="demo-icon icon-paper-plane-empty"></i> <?php echo config_item('SITE_NAME');?></a></div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-3 col-sm-12 col-12 text-center text-sm-right">
                <i class="demo-icon icon-phone"></i> <a href="tel:<?php echo $this->core->CONFIG_PHONE; ?>"><?php echo $this->core->CONFIG_PHONE; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="site-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-2 col-md-3 col-sm-6 col-6">
                <a href="<?php echo base_url(); ?>" class="site-logo"><img src="assets/themes/default/images/common/logo.png" alt="Xpert Finance Group" title="Xpert Finance Group" class="img-fluid"></a>
            </div>
            <div class="col-xl-9 col-lg-10 col-md-9 col-sm-6 col-6 text-right">
                <div class="d-inline-block">
                    <div class="menu d-none d-lg-block">
                        <?php
                        $params = array(
                            'menu_alias' => 'header-menu',
                            'ul_format' => '<ul class="sf-menu">{MENU}</ul>',
                            'level_1_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>',
                            'level_2_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>'
                        );
                        echo $this->html->menu($params);
                        ?>	                        
                    </div>
                </div>
                <div class="reviews d-inline-block"><a href="reviews">Reviews</a></div>
                <div class="rounded-circle brown-color-bg d-inline-block ml-2"><a href="contact-us"><i class="demo-icon icon-mail-alt"></i></a></div>

                <div class="collapse-button nav-toggle">
                 <a href="#menu">   <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-mobile-menu-container d-block d-lg-none">
    <div class="top-bar-abs">
        <div class="nav-toggle-close"><i class="ion-ios-close-empty"></i></div>

        <nav id="menu">
            <?php
            $params = array(
                'menu_alias' => 'header-menu',
                'ul_format' => '<ul style="transition-duration: 300ms; left: 2%;">{MENU}</ul>',
                'level_1_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>',
                'level_2_format' => '<a href="{HREF}"{ATTRIBUTES}>{LINK_NAME}</a>'
            );
            echo $this->html->menu($params);
            ?>           
        </nav>
    </div>
</div>