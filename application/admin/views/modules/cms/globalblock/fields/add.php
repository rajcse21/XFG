<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<?php if ($block['global_section_id'] != 0) { ?>
			<li class="breadcrumb-item"><a href="cms/globalsection/index/">GLobal Section</a></li>
			<li class="breadcrumb-item"><a href="cms/globalblock/index/<?php echo $block['global_section_id']; ?>">Global Blocks</a></li>
		<?php } else { ?>
			<li class="breadcrumb-item"><a href="cms/globalblock">Global Blocks</a></li>
		<?php } ?>
		<li class="breadcrumb-item"><a href="cms/block_field/index/<?php echo $block['global_block_id']; ?>">Additional Fields</a></li>
		<li class="breadcrumb-item active">Add Additional Fields</li>

	</ol>
</nav>
<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Add Additional Fields</div>
					<div class="card-body">
						<?php echo form_open("cms/block_field/add/{$block['global_block_id']}"); ?>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<label for="field_label" class="control-label" >Name<span class="required">*</span></label>
									<input type="text" class="form-control <?php echo (form_error('field_label')) ? "is-invalid" : ""; ?>" id="field_label" name="field_label" value="<?php echo set_value('field_label'); ?>" placeholder="Name">
								<?php echo form_error('field_label'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field_alias" class="control-label" >Alias<span class="required">*</span></label>
									<input type="text" class="form-control <?php echo (form_error('field_alias')) ? "is-invalid" : ""; ?>" id="field_alias" name="field_alias" value="<?php echo set_value('field_alias'); ?>" placeholder="Alias">
									<?php echo form_error('field_alias'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="field_type" class="control-label" >Field Type<span class="required">*</span></label>
									<?php echo form_dropdown('field_type', $field_type, set_value('field_type'), ' id="field_type" class="form-control field_type'. ((form_error('field_type')) ? "is-invalid" : '') . '"'); ?>
								<?php echo form_error('field_type'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group field_options">
									<label for="field_options" class="control-label" >Field Options</label>
									<input type="text" class="form-control <?php echo (form_error('field_options')) ? "is-invalid" : ""; ?>" id="field_options" name="field_options" value="<?php echo set_value('field_options'); ?>" placeholder="Example :-  Label1:Value1;Label2:Value2">
								<?php echo form_error('field_options'); ?>
								</div>
							</div>
						</div>
						<input type="hidden" name="global_block_id" value="<?php echo $block['global_block_id']; ?>">
						<div class="form-group text-right">
							<button type="submit" class="btn btn-secondary">Add</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

