<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="content_type/content_type">Content Types</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
</nav>
<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Add Content Types</div>
					<div class="card-body">
						<?php echo form_open("content_type/content_type/add"); ?>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label for="node_type">Type *</label>
									<?php echo form_dropdown('node_type', $content_type, set_value('node_type'), 'id="node_type" class="form-control ' . ((form_error('node_type')) ? "is-invalid" : '') . '"') ?>
									<?php echo form_error('node_type'); ?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label for="content_type_name">Name *</label>
									<input name="content_type_name" type="text" class="form-control <?php echo (form_error('content_type_name')) ? "is-invalid" : ""; ?>" id="content_type_name" value="<?php echo set_value('content_type_name') ?>" placeholder="Enter Name" />
									<?php echo form_error('content_type_name'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label for="content_type_alias">Alias</label>
									<input name="content_type_alias" type="text" class="form-control <?php echo (form_error('content_type_alias')) ? "is-invalid" : ""; ?>" id="content_type_alias" value="<?php echo set_value('content_type_alias') ?>" placeholder="Enter Alias" />
									<?php echo form_error('content_type_alias'); ?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label for="singular_name">Singular Name  *</label>
									<input name="singular_name" type="text" class="form-control <?php echo (form_error('singular_name')) ? "is-invalid" : ""; ?>" id="singular_name" value="<?php echo set_value('singular_name') ?>" placeholder="Enter Singular Name" />
									<?php echo form_error('singular_name'); ?>
								</div>
							</div>
						</div>

						<label for="content_tab">Content Tab</label><br/>
						<div class="form-group">									
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="content_tab1" name="content_tab" value="1" checked class="custom-control-input">
								<label class="custom-control-label" for="content_tab1">Enabled</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="content_tab0" name="content_tab" value="0" class="custom-control-input">
								<label class="custom-control-label" for="content_tab0">Disabled</label>
							</div>
							<?php echo form_error('content_tab'); ?>
						</div>

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
