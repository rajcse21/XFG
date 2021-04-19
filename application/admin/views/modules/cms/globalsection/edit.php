<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/globalsection/index">Global Sections</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</nav>

<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Edit Global Section</div>
					<div class="card-body">

						<?php echo form_open("cms/globalsection/edit/{$section['global_section_id']}"); ?>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#images" aria-controls="images" role="tab" data-toggle="tab">Images</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#template" aria-controls="template" role="tab" data-toggle="tab">Template</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#misc-tab" aria-controls="misc" role="tab" data-toggle="tab">Misc</a>
							</li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="main">
								&nbsp;
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="section_name">Name *</label>
											<input name="section_name" type="text" class="form-control <?php echo (form_error('section_name')) ? "is-invalid" : ""; ?>" id="section_name" value="<?php echo set_value('section_name', $section['section_name']) ?>" placeholder="Enter Name"/>
											<?php echo form_error('section_name'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="section_alias">Alias </label>
											<input name="section_alias" type="text" class="form-control <?php echo (form_error('section_alias')) ? "is-invalid" : ""; ?>" id="section_alias" value="<?php echo set_value('section_alias', $section['section_alias']) ?>" placeholder="Enter Alias"/>
											<?php echo form_error('section_alias'); ?>
										</div>
									</div>

								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="images">
								&nbsp;
								<div class="form-group">
									<label for="section_background">Desktop Background </label>
									<?php echo $this->filemanager->render('section_background', $section['section_background']); ?>
								</div>
								<div class="form-group">
									<label for="section_img_medium">Tablet Background </label>
									<?php echo $this->filemanager->render('section_img_medium', $section['section_img_medium']); ?>
								</div>
								<div class="form-group">
									<label for="section_img_small">Mobile Background </label>
									<?php echo $this->filemanager->render('section_img_small', $section['section_img_small']); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="template">
								&nbsp;
								<div class="form-group">
									<label for="section_template">Section Template</label>
									<textarea class="form-control <?php echo (form_error('section_template')) ? "is-invalid" : ""; ?> codeMirror" name="section_template" id="section_template" rows="7" ><?php echo set_value('section_template', $section['section_template']); ?></textarea>
									<?php echo form_error('section_template'); ?>
								</div>
								<div class="form-group">
									<label for="section_block_template" class="control-label" >Block Template</label>
									<textarea class="form-control <?php echo (form_error('section_block_template')) ? "is-invalid" : ""; ?> codeMirror" rows="5" name="section_block_template" id="section_block_template"><?php echo set_value('section_block_template', $section['section_block_template']); ?></textarea>
									<?php echo form_error('section_block_template'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="misc-tab">
								&nbsp;
								<div class="form-group">
									<label for="section_icon">Icon</label>
									<?php echo $this->filemanager->render('section_icon', $section['section_icon']); ?>
								</div>
								<?php if (false) { ?>
									<div class="form-group">
										<label for="section_category" class="control-label" >Section Category</label>
										<?php echo form_dropdown('section_category', $global_categories, set_value('section_category'), 'class="form-control" id="section_category"'); ?>
									</div>
								<?php } ?>

								<div class="form-group">
									<label for="section_desc">Desc</label>
									<textarea name="section_desc" class="form-control mceSimple1 <?php echo (form_error('section_desc')) ? "is-invalid" : ""; ?>" id="section_desc"><?php echo set_value('section_desc', $section['section_desc']) ?></textarea>							
									<?php echo form_error('section_desc'); ?>
								</div>
							</div>
						</div>
						<input type='hidden' name='global_section_id' value='<?php echo $section['global_section_id']; ?>'/>
						<div class="form-group text-right">
							<button type="submit" class="btn btn-secondary">Update</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

