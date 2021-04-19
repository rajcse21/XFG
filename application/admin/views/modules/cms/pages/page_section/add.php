<div id="popup_container">	
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <div class="card bg-light">
                    <div class="card-header">Add Page Section</div>
                    <div class="card-body">								
                        <?php echo form_open("cms/page-section/add/{$page_details['page_i18n_id']}/{$global_section_id}", 'class="sectionAddFrm" id="sectionAddFrm"'); ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#image" aria-controls="image" role="tab" data-toggle="tab">Images</a>
                            </li>
                            <?php if ($global_section_id == 0) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#template" aria-controls="template" role="tab" data-toggle="tab">Template</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="main">
                                &nbsp;
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="page_section">Section Name <span class="required">*</span></label>
                                            <input type="text" class="form-control <?php echo (form_error('page_section')) ? "is-invalid" : ""; ?>" name="page_section" id="page_section" value="<?php echo set_value('page_section'); ?>" />
                                            <?php echo form_error('page_section'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="page_section_alias" class="control-label" >Section Alias</label>
                                            <input type="text" class="form-control <?php echo (form_error('page_section_alias')) ? "is-invalid" : ""; ?>" id="page_section_alias" name="page_section_alias" value="<?php echo set_value('page_section_alias'); ?>" placeholder="Section Alias">
                                            <?php echo form_error('page_section_alias'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="page_section_class" class="control-label" >Class</label>
                                    <input type="text" class="form-control <?php echo (form_error('page_section_class')) ? "is-invalid" : ""; ?>" id="page_section_class" name="page_section_class" value="<?php echo set_value('page_section_class'); ?>" placeholder="Section Class">
                                    <?php echo form_error('page_section_class'); ?>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="image">
                                &nbsp;
                                <div class="form-group">
                                    <label for="page_section_background">Desktop Background</label>
                                    <?php echo $this->filemanager->render('page_section_background'); ?>
                                </div><hr>
                                <div class="form-group">
                                    <label for="page_section_img_medium" class="control-label" >Tablet Background</label>
                                    <?php echo $this->filemanager->render('page_section_img_medium'); ?>
                                </div><hr>
                                <div class="form-group">
                                    <label for="page_section_img_small" class="control-label" >Mobile Background</label>
                                    <?php echo $this->filemanager->render('page_section_img_small'); ?>
                                </div>
                            </div>
                            <?php if ($global_section_id == 0) { ?>
                                <div role="tabpanel" class="tab-pane" id="template">
                                    &nbsp;
                                    <div class="form-group">
                                        <label for="page_section_template">Section Template</label>
                                        <textarea class="form-control <?php echo (form_error('page_section_template')) ? "is-invalid" : ""; ?> codeMirror" name="page_section_template" id="page_section_template" rows="7" ><?php echo set_value('page_section_template'); ?></textarea>
                                        <?php echo form_error('page_section_template'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="page_section_block_template" class="control-label" >Block Template</label>
                                        <textarea class="form-control <?php echo (form_error('page_section_block_template')) ? "is-invalid" : ""; ?> codeMirror" rows="5" name="page_section_block_template" id="page_section_block_template"><?php echo set_value('page_section_block_template'); ?></textarea>
                                        <?php echo form_error('page_section_block_template'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="page_i18n_id" class="page_i18n_id" value="<?php echo $page_details['page_i18n_id']; ?>" />
                            <input type="hidden" name="global_section_id" class="global_section_id" value="<?php echo $global_section_id; ?>" />

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-secondary">Add Section</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>