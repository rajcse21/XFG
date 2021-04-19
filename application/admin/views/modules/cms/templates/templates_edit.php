<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/template">Templates</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</nav>

<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Edit Template</div>
					<div class="card-body">
						<?php echo form_open('cms/template/edit/' . $template['page_template_id'], array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#content-tab" aria-controls="content" role="tab" data-toggle="tab">Content</a>
							</li>

						</ul>

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="main">
								<br/>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="template_name" class="control-label" >Template Name <span class="required">*</span></label>
											<input type="text" class="form-control <?php echo (form_error('template_name')) ? "is-invalid" : ""; ?>" id="template_name" name="template_name" value="<?php echo set_value('template_name', $template['template_name']); ?>" placeholder="Template Name">
											<?php echo form_error('template_name'); ?>
										</div>
									</div>	
									<div class="col-md-6">
										<div class="form-group">
											<label for="template_alias" class="control-label" >Template Alias <span class="required">*</span></label>
											<input type="text" class="form-control <?php echo (form_error('template_alias')) ? "is-invalid" : ""; ?>" id="template_alias" name="template_alias" value="<?php echo set_value('template_alias', $template['template_alias']); ?>" placeholder="Template Alias">
											<?php echo form_error('template_alias'); ?>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<label for="template_path" class="control-label" >Template Path</label>
									<input type="text" class="form-control <?php echo (form_error('template_path')) ? "is-invalid" : ""; ?>" id="template_path" name="template_path" value="<?php echo set_value('template_path', $template['template_path']); ?>" placeholder="Template Path">
									<?php echo form_error('template_path'); ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="content-tab">
								<br/>
								<div class="form-group">
									<label for="template_contents" class="control-label">Template Content<span class="required">*</span></label>
									<textarea class="form-control <?php echo (form_error('template_contents')) ? "is-invalid" : ""; ?> codeMirror" rows="5" name="template_contents" id="template_contents"><?php echo set_value('template_contents', $template['template_contents']); ?></textarea>
									<?php echo form_error('template_contents'); ?>
								</div>
							</div>

						</div>
						<input type="hidden" name="page_template_id" value="<?php echo $template['page_template_id']; ?>"/>
						<div class="form-group text-right">
							<button type="submit" class="btn btn-dark">Edit</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>