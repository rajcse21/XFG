<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Edit Additional Field</h1>
		</div>	
		<div class="col-md-4 text-right">
			&nbsp;
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li><a href="content_type/fields/index/<?php echo $content_field['content_type_id']; ?>">Additional Fields</a></li>
	<li class="active"><?php echo $content_field['content_type_name']; ?></li>
</ol>
<div id="content_main">
	<?php $this->load->view('inc-messages'); ?>
	<?php echo form_open("content_type/fields/edit/{$content_field['content_field_id']}"); ?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="node_type" class="control-label" >Field Group<span class="required">*</span></label>
				<?php echo form_dropdown('content_fieldgroup_id', $content_fieldgroups, set_value('content_fieldgroup_id', $content_field['content_fieldgroup_id']), ' id="content_fieldgroup_id" class="form-control"'); ?>
			</div>
		</div>	
		<div class="col-md-6">
			<div class="form-group">
				<label for="node_type" class="control-label" >Type<span class="required">*</span></label>
				<?php echo form_dropdown('field_type', $field_type, set_value('field_type', $content_field['field_type_id']), ' id="field_type" class="form-control field_type"'); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="field_label" class="control-label" >Field Label<span class="required">*</span></label>
				<input name="field_label" type="text" class="form-control" id="field_label" value="<?php echo set_value('field_label', $content_field['field_label']); ?>" placeholder="Field Label" />
			</div>
		</div>	
		<div class="col-md-6">
			<div class="form-group">
				<label for="field_alias" class="control-label" >Field Alias </label>
				<input name="field_alias" type="text" class="form-control" id="field_alias" value="<?php echo set_value('field_alias', $content_field['field_alias']); ?>" placeholder="Field Alias" />
			</div>
		</div>
	</div>

	<div class="form-group vocabulary">
		<label for="vocabulary" class="control-label" >Vocabulary</label>
		<?php echo form_dropdown('vocabulary', $vocabularies, set_value('vocabulary', $content_field['field_value']), ' id="vocabulary" class="form-control"'); ?>
	</div>
	<div class="form-group">
		<h5>Fields marked with <span class="required">*</span> are required.</h5>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
	<?php echo form_close(); ?>
</div>