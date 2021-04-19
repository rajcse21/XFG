<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->meta->render(); ?>
        <base href="<?php echo $CI->http->baseURL(); ?>" />
        <?php $this->load->view(THEME_PATH . "/assets/global"); ?>
        <?php echo $this->html->renderBeforeHeadClose(); ?>
    </head>
    <body class="app flex-row align-items-center">
        <div class="container">
           <?php echo $contents; ?>
        </div>       
    </body>
</html>