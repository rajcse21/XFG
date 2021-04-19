<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Add Content Stream</h1>
		</div>	
		<div class="col-md-4 text-right">
			&nbsp;
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li><a href="content_type/stream/index/<?php echo $content_type['content_type_id']; ?>">Content Stream</a></li>
	<li class="active"><?php echo $content_type['content_type_name']; ?></li>
</ol>
<div id="content_main">

	<?php $this->load->view('inc-messages'); ?>
	<?php echo form_open("content_type/stream/add/{$content_type['content_type_id']}"); ?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="stream_name" class="control-label" >Stream <span class="required">*</span></label>
				<input name="stream_name" type="text" class="form-control" id="stream_name" value="<?php echo set_value('stream_name'); ?>" placeholder="Stream" />
			</div>
		</div>	
		<div class="col-md-6">
			<div class="form-group">
				<label for="stream_alias" class="control-label" >Alias <span class="required">*</span></label>
				<input name="stream_alias" type="text" class="form-control" id="stream_alias" value="<?php echo set_value('stream_alias'); ?>" placeholder="Alias" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="show_pagination">Pagination</label><br />
				<label class="radio-inline">
					<input type="radio" name="show_pagination" value="1" <?php echo set_radio('show_pagination', '1'); ?> />Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="show_pagination" value="0" <?php echo set_radio('show_pagination', '0', TRUE); ?> />No
				</label>
			</div>
		</div>	
		<div class="col-md-6">
			<div class="form-group">
				<label for="item_per_stream" class="control-label" >Perpage </label>
				<input name="item_per_stream" type="text" class="form-control" id="item_per_stream" value="<?php echo set_value('item_per_stream'); ?>" placeholder="Perpage" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="item_template">Template</label>
		<textarea class="form-control codeMirror" name="item_template" id="item_template" rows="7" ><?php echo set_value('item_template'); ?></textarea>
	</div>

	<div class="form-group">
		<h5>Fields marked with <span class="required">*</span> are required.</h5>
	</div>
	<div class="form-group">
		<input type="hidden" name="content_type" id="content_type" value="<?php echo $content_type['content_type_id']; ?>" >
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
	<?php echo form_close(); ?>
</div>