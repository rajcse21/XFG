<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/globalblock">Global Blocks</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
</nav>
<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Add Global Block</div>
					<div class="card-body">
						<?php echo form_open("cms/globalblock/add"); ?>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#link" aria-controls="link" role="tab" data-toggle="tab">Link</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#images" aria-controls="images" role="tab" data-toggle="tab">Images</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#layout" aria-controls="layout" role="tab" data-toggle="tab">Layout</a>
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
								<br/>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_name">Name *</label>
											<input name="block_name" type="text" class="form-control <?php echo (form_error('block_name')) ? "is-invalid" : ""; ?>" id="block_name" value="<?php echo set_value('block_name') ?>" placeholder="Enter Name"/>
											<?php echo form_error('block_name'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_alias">Alias *</label>
											<input name="block_alias" type="text" class="form-control <?php echo (form_error('block_alias')) ? "is-invalid" : ""; ?>" id="block_alias" value="<?php echo set_value('block_alias') ?>" placeholder="Enter Alias"/>
											<?php echo form_error('block_alias'); ?>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="block_title">Title</label>
									<input name="block_title" type="text" class="form-control <?php echo (form_error('block_title')) ? "is-invalid" : ""; ?>" id="block_title" value="<?php echo set_value('block_title') ?>" placeholder="Enter Title"/>
									<?php echo form_error('block_title'); ?>
								</div>
								<div class="form-group">
									<label for="block_content">Content</label>
									<textarea name="block_content" class="form-control mceSimple1 <?php echo (form_error('block_content')) ? "is-invalid" : ""; ?>" id="block_content"><?php echo set_value('block_content') ?></textarea>							
									<?php echo form_error('block_content'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="link">
								<br/>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="block_link">URL 1</label>
											<input name="block_link" type="text" class="form-control <?php echo (form_error('block_link')) ? "is-invalid" : ""; ?>" id="block_link" value="<?php echo set_value('block_link') ?>" placeholder="Enter URL 1"/>
											<?php echo form_error('block_link'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_text">Label</label>
											<input name="link_text" type="text" class="form-control <?php echo (form_error('link_text')) ? "is-invalid" : ""; ?>" id="link_text" value="<?php echo set_value('link_text') ?>" placeholder="Enter Label"/>
											<?php echo form_error('link_text'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_class">CSS Class</label>
											<input name="link_class" type="text" class="form-control <?php echo (form_error('link_class')) ? "is-invalid" : ""; ?>" id="link_class" value="<?php echo set_value('link_class') ?>" placeholder="Enter CSS Class"/>
											<?php echo form_error('link_class'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_2">URL 2</label>
											<input name="link_2" type="text" class="form-control <?php echo (form_error('link_2')) ? "is-invalid" : ""; ?>" id="block_link" value="<?php echo set_value('link_2') ?>" placeholder="Enter URL 2"/>
											<?php echo form_error('link_2'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_2_text">Label</label>
											<input name="link_2_text" type="text" class="form-control <?php echo (form_error('link_2_text')) ? "is-invalid" : ""; ?>" id="link_2_text" value="<?php echo set_value('link_2_text') ?>" placeholder="Enter Label"/>
											<?php echo form_error('link_2_text'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_2_class">CSS Class</label>
											<input name="link_2_class" type="text" class="form-control <?php echo (form_error('link_2_class')) ? "is-invalid" : ""; ?>" id="link_2_class" value="<?php echo set_value('link_2_class') ?>" placeholder="Enter CSS Class"/>
											<?php echo form_error('link_2_class'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_3">URL 3</label>
											<input name="link_3" type="text" class="form-control <?php echo (form_error('link_3')) ? "is-invalid" : ""; ?>" id="block_link" value="<?php echo set_value('link_3') ?>" placeholder="Enter URL 3"/>
											<?php echo form_error('link_3'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_3_text">Label</label>
											<input name="link_3_text" type="text" class="form-control <?php echo (form_error('link_3_text')) ? "is-invalid" : ""; ?>" id="link_3_text" value="<?php echo set_value('link_3_text') ?>" placeholder="Enter Label"/>
											<?php echo form_error('link_3_text'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="link_3_class">CSS Class</label>
											<input name="link_3_class" type="text" class="form-control <?php echo (form_error('link_3_class')) ? "is-invalid" : ""; ?>" id="link_3_class" value="<?php echo set_value('link_3_class') ?>" placeholder="Enter CSS Class"/>
											<?php echo form_error('link_3_class'); ?>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="images">
								<br/>
								<div class="form-group">
									<label for="block_image">Desktop Background </label>
									<?php echo $this->filemanager->render('block_image'); ?>
								</div>
								<div class="form-group">
									<label for="block_image_medium">Tablet Background </label>
									<?php echo $this->filemanager->render('block_image_medium'); ?>
								</div>
								<div class="form-group">
									<label for="block_image_small">Mobile Background </label>
									<?php echo $this->filemanager->render('block_image_small'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="layout">
								<br/>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_lg">X Large Column</label>
											<?php echo form_dropdown('block_col_lg', $columns, set_value('block_col_lg', 12), 'id="block_col_lg" class="form-control  column-trigger ' . ((form_error('block_col_lg')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_lg'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_lg_padding">Left Padding</label>
											<?php echo form_dropdown('block_col_lg_padding', $padding_columns, set_value('block_col_lg_padding'), 'id="block_col_lg_padding" class="form-control  column-padding ' . ((form_error('block_col_lg_padding')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_lg_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_md">Large Column</label>
											<?php echo form_dropdown('block_col_md', $columns, set_value('block_col_md', 12), 'id="block_col_md" class="form-control  column-trigger ' . ((form_error('block_col_md')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_md'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_md_padding">Left Padding</label>
											<?php echo form_dropdown('block_col_md_padding', $padding_columns, set_value('block_col_md_padding'), 'id="block_col_md_padding" class="form-control  column-padding ' . ((form_error('block_col_md_padding')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_md_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_sm">Medium Column</label>
											<?php echo form_dropdown('block_col_sm', $columns, set_value('block_col_sm', 12), 'id="block_col_sm" class="form-control  column-trigger ' . ((form_error('block_col_sm')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_sm'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_sm_padding">Left Padding</label>
											<?php echo form_dropdown('block_col_sm_padding', $padding_columns, set_value('block_col_sm_padding'), 'id="block_col_sm_padding" class="form-control  column-padding ' . ((form_error('block_col_sm_padding')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_sm_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_xs">Small Column</label>
											<?php echo form_dropdown('block_col_xs', $columns, set_value('block_col_xs', 12), 'id="block_col_xs" class="form-control  column-trigger ' . ((form_error('block_col_xs')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_xs'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_col_xs_padding">Left Padding</label>
											<?php echo form_dropdown('block_col_xs_padding', $padding_columns, set_value('block_col_xs_padding'), 'id="block_col_xs_padding" class="form-control  column-padding ' . ((form_error('block_col_xs_padding')) ? "is-invalid" : '') . '"') ?>
											<?php echo form_error('block_col_xs_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_css_class">Class</label>
											<input name="block_css_class" type="text" class="form-control <?php echo (form_error('block_css_class')) ? "is-invalid" : ""; ?>" id="block_css_class" value="<?php echo set_value('block_css_class') ?>" placeholder="Enter Class"/>
											<?php echo form_error('block_css_class'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="block_css_style">Style</label>
											<input name="block_css_style" type="text" class="form-control <?php echo (form_error('block_css_style')) ? "is-invalid" : ""; ?>" id="block_css_style" value="<?php echo set_value('block_css_style') ?>" placeholder="Enter Style"/>
											<?php echo form_error('block_css_style'); ?>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="template">
								<br/>
								<div class="form-group">
									<label for="block_template">Section Template</label>
									<textarea class="form-control <?php echo (form_error('block_template')) ? "is-invalid" : ""; ?> codeMirror" name="block_template" id="block_template" rows="7" ><?php echo set_value('block_template'); ?></textarea>
									<?php echo form_error('block_template'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="misc-tab">
								<br/>
								<div class="form-group">
									<label for="block_icon">Icon</label>
									<?php echo $this->filemanager->render('block_icon'); ?>
								</div>
								<div class="form-group">
									<label for="block_desc">Desc</label>
									<textarea name="block_desc" class="form-control mceSimple1 <?php echo (form_error('block_desc')) ? "is-invalid" : ""; ?>" id="block_desc"><?php echo set_value('block_desc') ?></textarea>							
									<?php echo form_error('block_desc'); ?>
								</div>
							</div>
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


