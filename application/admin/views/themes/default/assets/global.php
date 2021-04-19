<base href="<?php echo $this->http->baseURL(); ?>">
<script type="text/javascript">
	var XF_BASE_URL = "<?php echo $this->http->baseURL(); ?>";
	var XF_ADMIN_BASE_URL = "<?php echo $this->http->baseURL(); ?>";
	var XF_BASE_URL_SSL = "<?php echo $this->http->baseURLSSL(); ?>";
	var XF_BASE_URL_NOSSL = "<?php echo $this->http->baseURLNoSSL(); ?>";
	var XF_SITE_URL = "<?php echo $this->config->item('site_url'); ?>";
	var XF_THEME = "<?php echo THEME; ?>";
</script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Roboto|Slabo+27px" rel="stylesheet">


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
--><?php

//$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/bootstrap.min.css'));
//$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/all.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/codemirror/lib/codemirror.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/styles.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/dropzone/min/dropzone.min.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/css/pagetree.css'));
$CI->CSS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/fancybox/dist/jquery.fancybox.min.css'));

$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery-3.3.1.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery-ui.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/popper.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/bootstrap.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/all.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/tinymce/tinymce.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery.mask.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery.blockUI.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/codemirror/lib/codemirror.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/codemirror/mode/javascript/javascript.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/codemirror/mode/htmlmixed/htmlmixed.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/fancybox/dist/jquery.fancybox.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/dropzone/min/dropzone.min.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/global.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/site-editor.js'));
$CI->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/filemanager.js'));
$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/cms/page-add.js'));
$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/cms/menu.js'));
$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/app/cms/menu-item-add.js'));
$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/vendor/jquery.tablednd.0.7.min.js'));
