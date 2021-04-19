<base href="<?php echo $this->http->baseURL(); ?>">
<script type="text/javascript">
	var XF_BASE_URL = "<?php echo $this->http->baseURL(); ?>";
	var XF_BASE_URL_SSL = "<?php echo $this->http->baseURLSSL(); ?>";
	var XF_BASE_URL_NOSSL = "<?php echo $this->http->baseURLNoSSL(); ?>";
	var XF_SITE_URL = "<?php echo $this->config->item('site_url'); ?>";
	var XF_THEME = "<?php echo THEME; ?>";
</script>

<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700&display=swap" rel="stylesheet">

<?php
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/bootstrap/bootstrap.min.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/fontello/css/fontello-site-local.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/aniview/animations.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/aniview/aos.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/superfish/css/superfish.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/owlcarousel/owl.carousel.min.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/owlcarousel/owl.theme.default.min.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/slick/slick.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/slick/slick-theme.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/slinky/slinky.min.css'));
/*$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/mmenu-light/css/demo.css'));*/
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/mmenu-light/dist/mmenu-light.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/layout.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/responsive.css'));

$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery-3.4.1.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/bootstrap/bootstrap.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/cycle2/jquery.cycle2.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/cycle2/jquery.cycle2.swipe.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/owlcarousel/owl.carousel.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/superfish/js/superfish.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/slick/slick.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/slinky/slinky.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/mmenu-light/dist/mmenu-light.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/aniview/aos.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery.mask.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery.blockUI.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/global.js'));
