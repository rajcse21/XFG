<?php $sections = $this->cmscore->renderAllSections();
?>
<!doctype html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php echo $this->meta->render(); ?>
        <base href="<?php echo $CI->http->baseURL(); ?>" />
        <?php $this->load->view(THEME_PATH . "/assets/global"); ?>
        <?php echo $this->html->renderBeforeHeadClose(); ?>
        <link rel="apple-touch-icon" href="favicon.png">
    </head>

    <body>		
        <?php //echo $this->cmscore->renderGlobalBlock('top-header-block'); ?>
        <?php $this->load->view(THEME_PATH . "/layout/inc-header"); ?>
        <?php echo $sections; ?>  
        <?php $this->load->view(THEME_PATH . "/layout/inc-footer"); ?>
        <?php echo $this->html->renderBeforeBodyClose(); ?> 
    </body>
</html>