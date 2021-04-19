<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php echo $this->meta->renderTitle(); ?>
        <base href="<?php echo $CI->http->baseURL(); ?>" />
		<?php $this->load->view(THEME_PATH . "/assets/global"); ?>
		<?php echo $this->html->renderBeforeHeadClose(); ?>
		<?php
			//	echo $CI->assets->renderHead();
		//$this->load->view("themes/" . THEME . "/layout/inc-before-head-close");
		?>
	</head>

	<body class="pattern_bg">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<?php echo $contents; ?>
				</div>
			</div>
		</div>
			<?php echo $this->html->renderBeforeBodyClose(); ?>
	</body>
</html>
