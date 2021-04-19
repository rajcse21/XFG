<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item"><a href="cms/page/index/<?php echo $content_type['content_type_id']; ?>"><?php echo $content_type['content_type_name']; ?></a></li>
        <li  class="breadcrumb-item active">Add</li>
    </ol>
</nav>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <div class="card bg-light">
                    <div class="card-header">Add <?php echo $content_type['content_type_name']; ?></div>
                    <div class="card-body">						
                        <?php echo form_open("cms/page/add/{$content_type['content_type_id']}"); ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_page_detail" aria-controls="tab_page_detail" role="tab" data-toggle="tab">Page Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_meta_data" aria-controls="tab_meta_data" role="tab" data-toggle="tab">Meta Data</a>
                            </li>
                            <?php
                            foreach ($additional_tabs as $additional_tab) {
                                $show_tabs = $this->Fieldmodel->listGroupFields($content_type['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                ?>
                                <?php if (!empty($show_tabs)) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>" aria-controls="tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>" role="tab" data-toggle="tab"><?php echo $additional_tab['content_fieldgroup']; ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>

                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab_page_detail">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="page_name">Page Name <span class="required">*</span></label>
                                            <input type="text" class="form-control <?php echo (form_error('page_name')) ? "is-invalid" : ""; ?>" name="page_name" id="page_name" value="<?php echo set_value('page_name'); ?>" />
                                            <?php echo form_error('page_name'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_title">Page Heading <span class="required">*</span></label>
                                            <input type="text" name="page_title" id="page_title" class="form-control <?php echo (form_error('page_title')) ? "is-invalid" : ""; ?>" value="<?php echo set_value('page_title'); ?>">
                                            <?php echo form_error('page_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="browser_title">Browser Title</label>
                                            <input name="browser_title" type="text" class="form-control <?php echo (form_error('browser_title')) ? "is-invalid" : ""; ?>" id="browser_title" value="<?php echo set_value('browser_title'); ?>">
                                            <?php echo form_error('browser_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_uri">Page URI</label>
                                            <input name="page_uri" type="text" class="form-control <?php echo (form_error('page_uri')) ? "is-invalid" : ""; ?>" id="page_uri" value="<?php echo set_value('page_uri'); ?>" aria-describedby="uriHelpBlock" />
                                            <span id="uriHelpBlock" class="help-block">Will be auto-generated if left blank</span>
                                            <?php echo form_error('page_uri'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="page_status">Page Status</label><br />
                                            <label class="radio-inline">
                                                <input type="radio" name="page_status" value="Draft" <?php echo set_radio('page_status', 'Draft'); ?>/> Draft
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="page_status" value="Publish" <?php echo set_radio('page_status', 'Publish', TRUE); ?>/> Publish
                                            </label>
                                            <?php echo form_error('page_status'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="include_in_site_map">Include In Sitemap</label><br />
                                            <label class="radio-inline">
                                                <input type="radio" name="include_in_site_map" value="1" <?php echo set_radio('include_in_site_map', '1', TRUE); ?>/> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="include_in_site_map" value="0" <?php echo set_radio('include_in_site_map', '0'); ?>/> No

                                            </label>
                                            <?php echo form_error('include_in_site_map'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="parent_page">Parent Page</label>
                                            <?php echo form_dropdown('parent_id', $parent, set_value('parent_id'), ' id="parent_page" class="form-control ' . ((form_error('parent_page')) ? "is-invalid" : "") . '"'); ?>
                                            <?php echo form_error('parent_page'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_template_id">Page Template <span class="required">*</span></label>
                                            <?php echo form_dropdown('page_template_id', $page_templates, set_value('page_template_id'), ' id="page_template_id" class="form-control ' . ((form_error('page_template_id')) ? "is-invalid" : "") . '"'); ?>
                                            <?php echo form_error('page_template_id'); ?>
                                        </div>
                                        <?php foreach ($additional_fields as $field) { ?>

                                            <div class="form-group">
                                                <label for="parent_page"><?php echo $field['field_label'] ?><span class="required">*</span></label>
                                                <?php $this->load->view('themes/' . THEME . '/modules/cms/inc-fields/' . $field['field_type'], array('field_alias' => $field['field_alias'], 'content' => '')); ?>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php /* <div class="row">
                                  <div class = "form-group">
                                  <label for = "page_content">Content</label>
                                  <textarea class = "form-control <?php echo (form_error('page_content')) ? "is-invalid" : ""; ?> wysiwyg" rows = "5" name = "page_content" id = "page_content"><?php echo set_value('page_content'); ?></textarea>
                                  <?php echo form_error('page_content'); ?>
                                  </div>
                                  </div> */ ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab_meta_data">
                                <div class="form-group">
                                    <label for="meta_keywords" class="left inline">Meta Keywords</label>
                                    <textarea name="meta_keywords" class="form-control  <?php echo (form_error('meta_keywords')) ? "is-invalid" : ""; ?>" id="meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea>
                                    <?php echo form_error('meta_keywords'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description" class="left inline">Meta Description</label>
                                    <textarea name="meta_description" class="form-control  <?php echo (form_error('meta_description')) ? "is-invalid" : ""; ?>" id="meta_description"><?php echo set_value('meta_description'); ?></textarea>
                                    <?php echo form_error('meta_description'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="before_head_close" class="left inline">Additional Header Contents</label>
                                    <textarea name="before_head_close" class="form-control  <?php echo (form_error('before_head_close')) ? "is-invalid" : ""; ?>" id="before_head_close"><?php echo set_value('before_head_close'); ?></textarea>
                                    <?php echo form_error('before_head_close'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="before_body_close" class="left inline">Additional Footer Contents</label>
                                    <textarea name="before_body_close" class="form-control  <?php echo (form_error('before_body_close')) ? "is-invalid" : ""; ?>" id="before_body_close"><?php echo set_value('before_body_close'); ?></textarea>
                                    <?php echo form_error('before_body_close'); ?>
                                </div>
                            </div>

                            <?php
                            foreach ($additional_tabs as $additional_tab) {
                                $show_tabs = $this->Fieldmodel->listGroupFields($content_type['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                ?>
                                <?php if (!empty($show_tabs)) { ?>
                                    <div role="tabpanel" class="tab-pane" id="tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>">
                                        <?php foreach ($additional_tabs as $additional_tab) { ?>
                                            <?php
                                            $additional_fields = array();
                                            $additional_fields = $this->Fieldmodel->listGroupFields($content_type['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                            foreach ($additional_fields as $field) {
                                                ?>
                                                <div class="form-group">
                                                    <label for="parent_page"><?php echo $field['field_label'] ?><span class="required">*</span></label>
                                                    <?php $this->load->view('themes/' . THEME . '/modules/cms/inc-fields/' . $field['field_type'], array('field_alias' => $field['field_alias'], 'content' => '')); ?>

                                                </div>
                                            <?php } ?>
                                        <?php }
                                        ?>
                                    </div>

                                <?php } ?>
                            <?php } ?>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-secondary">Add <?php echo $content_type['content_type_name']; ?></button>
                            </div>

                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
