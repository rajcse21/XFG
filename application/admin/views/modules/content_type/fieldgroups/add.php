<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Add Additional Field Group</h1>
		</div>	
		<div class="col-md-4 text-right">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $content_type['content_type_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Action
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $content_type['content_type_id']; ?>">
					<li><a href="content_type/fields/index/<?php echo $content_type['content_type_id']; ?>">Additional Fields</a></li>
					<li><a href="content_type/fields/add/<?php echo $content_type['content_type_id']; ?>">Add Additional Field</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li><a href="content_type/fieldgroup/index/<?php echo $content_type['content_type_id']; ?>">Additional Field Groups</a></li>
	<li class="current"><?php echo $content_type['content_type_name']; ?></li>
</ol>
<div id="content_main">

	<?php $this->load->view('inc-messages'); ?>
	<?php echo form_open("content_type/fieldgroup/add/{$content_type['content_type_id']}"); ?>
	<div class="form-group">
		<label for="fieldgroup" class="control-label" >Field Group </label>
		<input name="fieldgroup" type="text" class="form-control" id="fieldgroup" value="<?php echo set_value('fieldgroup'); ?>" placeholder="Field Group" />
	</div>

	<div class="form-group">
		<h5>Fields marked with <span class="required">*</span> are required.</h5>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
	<?php echo form_close(); ?>
</div>