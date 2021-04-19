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
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

		<header class="app-header">
			<?php $this->load->view("themes/" . THEME . "/layout/inc-navbar"); ?>
		</header>

		<div class="app-body">
			<?php $this->load->view("themes/" . THEME . "/layout/inc-sidebar-menu"); ?>
			<main class="main">
				<?php echo $contents; ?>
			</main>
		</div>

		<footer class="app-footer" style="<?php echo (!$this->userauth->checkAuth()) ? 'margin-left:0px;' : ''; ?>">
			<span> &copy; <?php echo date("Y"); ?></span>
		</footer>

		<?php $this->load->view("themes/" . THEME . "/layout/inc-asside-menu"); ?>

		<?php echo $this->html->renderBeforeBodyClose(); ?>
    </body>
</html>