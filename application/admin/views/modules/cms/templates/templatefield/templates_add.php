<div id="content_main">
	<h1>Add Template Field</h1>
	<ul class="breadcrumbs">
		<li><a href="cms/template">Page Templates</a></li>
		<li><a href="cms/templatefield/index/<?php echo $template['page_template_id']; ?>">Additional Fields</a></li>
		<li class="current"><?php echo $template['template_name']; ?></li>
	</ul>
	<div class="row">
				<div class="small-12 columns">
	<?php $this->load->view('inc-messages'); ?>
	<div class="panel callout radius">
		<form action="cms/templatefield/add/<?php echo $template['page_template_id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
			<div class="row">
				<div class="small-2 columns"><label for="left-label" class="left inline">Field Type <span class="required">*</span></label></div>
				<div class="small-10 columns"><?php echo form_dropdown('field_type', $field_type, set_value('field_type'), ' class="textfield width_60"'); ?></div>
			</div>
			<div class="row">
				<div class="small-2 columns"><label for="left-label" class="left inline">Field Label <span class="required">*</span></label></div>
				<div class="small-10 columns"><input type="text" name="field_label" id="field_label" class="textfield width_60" value="<?php echo set_value('field_label'); ?>" /></div>
			</div>
			<div class="row">
				<div class="small-2 columns"><label for="left-label" class="left inline">Field Alias <span class="required">*</span></label></div>
				<div class="small-10 columns"><input type="text" name="field_alias" id="field_alias" class="textfield width_60" value="<?php echo set_value('field_alias'); ?>" /></div>
			</div>
			<div class="row">
				<div class="small-2 columns">&nbsp;</div>
				<div class="small-10 columns">Fields marked with <span class="required">*</span> are required. <br />
					<input type="submit" name="button" id="button" value="Submit" class="button small radius"></div>
			</div>
		</form>
	</div>
</div>
</div>
</div>