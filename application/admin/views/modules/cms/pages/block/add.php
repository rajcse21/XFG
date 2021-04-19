<div id="popup_container">	
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Add Block</div>
					<div class="card-body">	
						<?php echo form_open("cms/block/add/{$section['page_section_id']}"); ?>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#link" aria-controls="link" role="tab" data-toggle="tab">Links</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#image" aria-controls="image" role="tab" data-toggle="tab">Images</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#layout" aria-controls="layout" role="tab" data-toggle="tab">Layout</a>
							</li>
							<?php if ($section['global_section_id'] == 0) {
								?>
								<li class="nav-item">
									<a class="nav-link" href="#template" aria-controls="template" role="tab" data-toggle="tab">Template</a>
								</li>
							<?php } ?>							
						</ul>

						<div class = "tab-content">
							<div role = "tabpanel" class = "tab-pane active" id = "main">
								&nbsp;
								<div class="row">
									<div class ="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class = "form-group">
											<label for = "page_block_name">Name *</label>
											<input type = "text" class = "form-control <?php echo (form_error('page_block_name')) ? "is-invalid" : ""; ?>" name = "page_block_name" id = "page_block_name" value = "<?php echo set_value('page_block_name'); ?>" />
											<?php echo form_error('page_block_name'); ?>
										</div>
									</div>
									<div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class = "form-group">
											<label for = "page_block_alias">Alias</label>
											<input type = "text" class = "form-control <?php echo (form_error('page_block_alias')) ? "is-invalid" : ""; ?>" name = "page_block_alias" id = "page_block_alias" value = "<?php echo set_value('page_block_alias'); ?>" />
											<?php echo form_error('page_block_alias'); ?>
										</div>
									</div>
								</div>
								<div class = "form-group">
									<label for = "page_block_title">Title</label>
									<input type = "text" class = "form-control <?php echo (form_error('page_block_title')) ? "is-invalid" : ""; ?>" name = "page_block_title" id = "page_block_title" value = "<?php echo set_value('page_block_title'); ?>" />
									<?php echo form_error('page_block_title'); ?>
								</div>
								<div class = "form-group">
									<label for = "page_block_content">Content</label>
									<textarea class = "form-control <?php echo (form_error('page_block_content')) ? "is-invalid" : ""; ?> wysiwyg" rows = "5" name = "page_block_content" id = "page_block_content"><?php echo set_value('page_block_content'); ?></textarea>
									<?php echo form_error('page_block_content'); ?>
								</div>	
							</div>
							<div role="tabpanel" class="tab-pane" id="link">
								&nbsp;
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link" class="control-label" >URL 1</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link')) ? "is-invalid" : ""; ?>" id="page_block_link" name="page_block_link" value="<?php echo set_value('page_block_link'); ?>" placeholder="URL 1">
											<?php echo form_error('page_block_link'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_text" class="control-label" >Label</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_text')) ? "is-invalid" : ""; ?>" id="page_block_link_text" name="page_block_link_text" value="<?php echo set_value('page_block_link_text'); ?>" placeholder="Label">
											<?php echo form_error('page_block_link_text'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_class" class="control-label" >CSS Class</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_class')) ? "is-invalid" : ""; ?>" id="page_block_link_class" name="page_block_link_class" value="<?php echo set_value('page_block_link_class'); ?>" placeholder="CSS Class">
											<?php echo form_error('page_block_link_class'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link2" class="control-label" >URL 2</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link2')) ? "is-invalid" : ""; ?>" id="page_block_link2" name="page_block_link2" value="<?php echo set_value('page_block_link2'); ?>" placeholder="URL 2">
											<?php echo form_error('page_block_link2'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_text2" class="control-label" >Label</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_text2')) ? "is-invalid" : ""; ?>" id="page_block_link_text2" name="page_block_link_text2" value="<?php echo set_value('page_block_link_text2'); ?>" placeholder="Label">
											<?php echo form_error('page_block_link_text2'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_class2" class="control-label" >CSS Class</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_class2')) ? "is-invalid" : ""; ?>" id="page_block_link_class2" name="page_block_link_class2" value="<?php echo set_value('page_block_link_class2'); ?>" placeholder="CSS Class">
											<?php echo form_error('page_block_link_class2'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link3" class="control-label" >URL 3</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link3')) ? "is-invalid" : ""; ?>" id="page_block_link3" name="page_block_link3" value="<?php echo set_value('page_block_link3'); ?>" placeholder="URL 3">
											<?php echo form_error('page_block_link3'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_text2" class="control-label" >Label</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_text2')) ? "is-invalid" : ""; ?>" id="page_block_link_text2" name="v" value="<?php echo set_value('link_3_text'); ?>" placeholder="Label">
											<?php echo form_error('page_block_link_text2'); ?>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="form-group">
											<label for="page_block_link_class3" class="control-label" >CSS Class</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_link_class3')) ? "is-invalid" : ""; ?>" id="link_3_text" name="page_block_link_class3" value="<?php echo set_value('page_block_link_class3'); ?>" placeholder="Link 3 Class">
											<?php echo form_error('page_block_link_class3'); ?>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="image">
								&nbsp;
								<div class="form-group">
									<label for="page_block_image" class="control-label" >Desktop Image</label>
									<?php echo $this->filemanager->render('page_block_image'); ?>
								</div><hr>
								<div class="form-group">
									<label for="page_block_image_medium" class="control-label" >Tablet Image</label>
									<?php echo $this->filemanager->render('page_block_image_medium'); ?>
								</div><hr>
								<div class="form-group">
									<label for="page_block_image_small" class="control-label" >Mobile Image</label>
									<?php echo $this->filemanager->render('page_block_image_small'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="layout">
								&nbsp;
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_lg" class="control-label" >Large Column</label>
											<?php echo form_dropdown('page_block_col_lg', $columns, set_value('page_block_col_lg', 12), ' id="block_col_lg" class="form-control '.((form_error('page_block_col_lg')) ? "is-invalid" : "").' column-trigger"'); ?>
											<?php echo form_error('page_block_col_lg'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_lg_padding" class="control-label" >Left Padding</label>
											<?php echo form_dropdown('page_block_col_lg_padding', $padding_columns, set_value('page_block_col_lg_padding'), ' id="page_block_col_lg_padding" class="form-control '.((form_error('page_block_col_lg_padding')) ? "is-invalid" : "").' column-padding"'); ?>
											<?php echo form_error('page_block_col_lg_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_md" class="control-label" >Medium Column</label>
											<?php echo form_dropdown('page_block_col_md', $columns, set_value('page_block_col_md', 12), ' id="page_block_col_md" class="form-control '.((form_error('page_block_col_md')) ? "is-invalid" : "").' column-trigger"'); ?>
											<?php echo form_error('page_block_col_md'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_md_padding" class="control-label" >Left Padding</label>
											<?php echo form_dropdown('page_block_col_md_padding', $padding_columns, set_value('page_block_col_md_padding'), ' id="page_block_col_md_padding" class="form-control '.((form_error('page_block_col_md_padding')) ? "is-invalid" : "").' column-padding"'); ?>
											<?php echo form_error('page_block_col_md_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_sm" class="control-label" >Small Column</label>
											<?php echo form_dropdown('page_block_col_sm', $columns, set_value('page_block_col_sm', 12), ' id="page_block_col_sm" class="form-control '.((form_error('page_block_col_sm')) ? "is-invalid" : "").' column-trigger"'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_sm_padding" class="control-label" >Left Padding</label>
											<?php echo form_dropdown('page_block_col_sm_padding', $padding_columns, set_value('page_block_col_sm_padding'), ' id="page_block_col_sm_padding" class="form-control '.((form_error('page_block_col_sm_padding')) ? "is-invalid" : "").' column-padding"'); ?>
											<?php echo form_error('page_block_col_sm_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_xs" class="control-label" >X Small Column</label>
											<?php echo form_dropdown('page_block_col_xs', $columns, set_value('page_block_col_xs', 12), ' id="page_block_col_xs" class="form-control '.((form_error('page_block_col_xs')) ? "is-invalid" : "").' column-trigger"'); ?>
											<?php echo form_error('page_block_col_xs'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_col_xs_padding" class="control-label" >Left Padding</label>
											<?php echo form_dropdown('page_block_col_xs_padding', $padding_columns, set_value('page_block_col_xs_padding'), ' id="page_block_col_xs_padding" class="form-control '.((form_error('page_block_col_xs_padding')) ? "is-invalid" : "").' column-padding"'); ?>
											<?php echo form_error('page_block_col_xs_padding'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_css_class" class="control-label" >Class</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_css_class')) ? "is-invalid" : ""; ?>" id="page_block_css_class" name="page_block_css_class" value="<?php echo set_value('page_block_css_class'); ?>" placeholder="Class">
											<?php echo form_error('page_block_css_class'); ?>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<label for="page_block_css_style" class="control-label" >Style</label>
											<input type="text" class="form-control <?php echo (form_error('page_block_css_style')) ? "is-invalid" : ""; ?>" id="page_block_css_style" name="page_block_css_style" value="<?php echo set_value('page_block_css_style'); ?>" placeholder="Style">
											<?php echo form_error('page_block_css_style'); ?>
										</div>
									</div>
								</div>
							</div>

							<?php if ($section['global_section_id'] == 0) { ?>
								<div role="tabpanel" class="tab-pane" id="template">
									&nbsp;
									<div class="form-group">
										<label for="page_block_template">Template</label>
										<textarea class="form-control <?php echo (form_error('page_block_template')) ? "is-invalid" : ""; ?> codeMirror" rows="5" name="page_block_template" id="page_block_template"><?php echo set_value('page_block_template'); ?></textarea>
										<?php echo form_error('page_block_template'); ?>
									</div>				
								</div>
							<?php } ?>

							<div class="form-group text-center">
								<input type="hidden" name="page_i18n_id" value="<?php echo $section['page_i18n_id']; ?>">
								<input type="hidden" name="section_id" value="<?php echo $section['page_section_id']; ?>">
								<button type="submit" class="btn btn-secondary">Add Block</button>
							</div>								
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>