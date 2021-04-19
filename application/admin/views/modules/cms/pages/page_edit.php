<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item"><a href="cms/page/index/<?php echo $page_details['content_type_id']; ?>"><?php echo $page_details['content_type_name']; ?></a></li>
        <li class="breadcrumb-item  active"><?php echo $page_details['page_name']; ?> - Edit</li>
    </ol>
</nav>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <div class="card bg-light">
                    <div class="card-header">Edit <?php echo $page_details['content_type_name']; ?></div>
                    <div class="card-body">	
                        <?php echo form_open("cms/page/edit/{$page_details['page_i18n_id']}/{$page_details['language_code']}"); ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_page_detail" aria-controls="tab_page_detail" role="tab" data-toggle="tab">Page Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_meta_data" aria-controls="tab_meta_data" role="tab" data-toggle="tab">Meta Data</a>
                            </li>
                            <?php if ($includes) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_includes" aria-controls="tab_includes" role="tab" data-toggle="tab">Includes</a>
                                </li>
                            <?php } ?>
                            <?php
                            foreach ($additional_tabs as $additional_tab) {
                                $show_tabs = $this->Fieldmodel->listGroupFields($page_details['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                ?>
                                <?php if (!empty($show_tabs)) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>" aria-controls="tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>" role="tab" data-toggle="tab"><?php echo $additional_tab['content_fieldgroup']; ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab">Content</a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab_page_detail">
                                <br/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="page_name">Page Name <span class="required">*</span></label>
                                            <input type="text" class="form-control <?php echo (form_error('page_name')) ? "is-invalid" : ""; ?>" name="page_name" id="page_name" value="<?php echo set_value('page_name', $page_details['page_name']); ?>" />
                                            <?php echo form_error('page_name'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_title">Page Heading <span class="required">*</span></label>
                                            <input type="text" name="page_title" id="page_title" class="form-control <?php echo (form_error('page_title')) ? "is-invalid" : ""; ?>" value="<?php echo set_value('page_title', $page_details['page_title']); ?>">
                                            <?php echo form_error('page_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="browser_title">Browser Title</label>
                                            <input name="browser_title" type="text" class="form-control <?php echo (form_error('browser_title')) ? "is-invalid" : ""; ?>" id="browser_title" value="<?php echo set_value('browser_title', $page_details['browser_title']); ?>">
                                            <?php echo form_error('browser_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_uri">Page URI</label>
                                            <input name="page_uri" type="text" class="form-control <?php echo (form_error('page_uri')) ? "is-invalid" : ""; ?>" id="page_uri" value="<?php echo set_value('page_uri', $page_details['page_uri']); ?>" aria-describedby="uriHelpBlock" />
                                            <?php echo form_error('page_uri'); ?>
                                            <span id="uriHelpBlock" class="help-block">Will be auto-generated if left blank</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="page_status">Page Status</label><br />
                                            <label class="radio-inline">
                                                <input type="radio" name="page_status" value="Draft" <?php echo set_radio('page_status', 'Draft', ($page_details['page_status'] == 'Draft')); ?>/> Draft
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="page_status" value="Publish" <?php echo set_radio('page_status', 'Publish', ($page_details['page_status'] == 'Publish')); ?>/> Publish
                                            </label>
                                            <?php echo form_error('page_status'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="include_in_site_map">Include In Sitemap</label><br />
                                            <label class="radio-inline">
                                                <input type="radio" name="include_in_site_map" value="1" <?php echo set_radio('include_in_site_map', '1', $page_details['include_in_site_map'] == '1'); ?>/> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="include_in_site_map" value="0" <?php echo set_radio('include_in_site_map', '0', $page_details['include_in_site_map'] == '0'); ?>/> No
                                            </label>
                                            <?php echo form_error('include_in_site_map'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="parent_page">Parent Page</label>
                                            <?php echo form_dropdown('parent_id', $parent, set_value('parent_id', $page_details['parent_id']), ' id="parent_page" class="form-control ' . ((form_error('parent_page')) ? "is-invalid" : "") . '"'); ?>
                                            <?php echo form_error('parent_id'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="page_template_id">Page Template <span class="required">*</span></label>
                                            <?php echo form_dropdown('page_template_id', $page_template, set_value('page_template_id', $page_details['page_template_id']), ' id="page_template_id" class="form-control ' . ((form_error('page_template_id')) ? "is-invalid" : "") . '"'); ?>
                                            <?php echo form_error('page_template_id'); ?>
                                        </div>
                                        <?php foreach ($additional_fields as $field) {
                                            ?>
                                            <div class="form-group">
                                                <label for="field_label"><?php echo $field['field_label'] ?> <span class="required">*</span></label>
                                                <?php
                                                $content = '';
                                                if (isset($content_data[$field['content_field_id']]['field_contents'])) {
                                                    $content = $content_data[$field['content_field_id']]['field_contents'];
                                                }
                                                ?>
                                                <?php echo $this->view->load('cms/inc-fields/' . $field['field_type'], array('field_alias' => $field['field_alias'], 'content' => $content)); ?>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php /* <div class="row">
                                  <div class="col-md-12">
                                  <div class = "form-group">
                                  <label for = "page_content">Content</label>
                                  <textarea class = "form-control <?php echo (form_error('page_content')) ? "is-invalid" : ""; ?> wysiwyg" rows = "5" name = "page_content" id = "page_content"><?php echo set_value('page_content', $page_details['page_content']); ?></textarea>
                                  <?php echo form_error('page_content'); ?>
                                  </div>
                                  </div>
                                  </div> */ ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab_meta_data">
                                <br/>
                                <div class="form-group">
                                    <label for="meta_keywords" class="left inline">Meta Keywords</label>
                                    <textarea name="meta_keywords" class="form-control <?php echo (form_error('meta_keywords')) ? "is-invalid" : ""; ?>" id="meta_keywords"><?php echo set_value('meta_keywords', $page_details['meta_keywords']); ?></textarea>
                                    <?php echo form_error('meta_keywords'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="meta_description" class="left inline">Meta Description</label>
                                    <textarea name="meta_description" class="form-control <?php echo (form_error('meta_description')) ? "is-invalid" : ""; ?>" id="meta_description"><?php echo set_value('meta_description', $page_details['meta_description']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="before_head_close" class="left inline">Additional Header Contents</label>
                                    <textarea name="before_head_close" class="form-control <?php echo (form_error('before_head_close')) ? "is-invalid" : ""; ?>" id="before_head_close"><?php echo set_value('before_head_close', $page_details['before_head_close']); ?></textarea>
                                    <?php echo form_error('before_head_close'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="before_body_close" class="left inline">Additional Footer Contents</label>
                                    <textarea name="before_body_close" class="form-control <?php echo (form_error('before_body_close')) ? "is-invalid" : ""; ?>" id="before_body_close"><?php echo set_value('before_body_close', $page_details['before_body_close']); ?></textarea>
                                    <?php echo form_error('before_body_close'); ?>
                                </div>
                            </div>
                            <!--		<div role="tabpanel" class="tab-pane" id="test_data">
                                                    <div style="border:2px solid #666; border-radius:11px; padding:20px;">
                                                            <iframe id="form-iframe" src="<?php echo $this->config->item('site_url'); ?>" style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" onload="AdjustIframeHeightOnLoad()"></iframe>
                                                    </div>
                                            </div>-->

                            <?php
                            foreach ($additional_tabs as $additional_tab) {
                                $show_tabs = $this->Fieldmodel->listGroupFields($page_details['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                ?>
                                <?php if (!empty($show_tabs)) { ?>
                                    <div role="tabpanel" class="tab-pane" id="tab_<?php echo $additional_tab['content_fieldgroup_id']; ?>">
                                        <br/>
                                        <?php
                                        $additional_fields = array();
                                        $additional_fields = $this->Fieldmodel->listGroupFields($page_details['content_type_id'], $additional_tab['content_fieldgroup_id']);
                                        foreach ($additional_fields as $field) {
                                            ?>
                                            <div class="form-group">
                                                <label for="field_label"><?php echo $field['field_label'] ?> <span class="required">*</span></label>
                                                <?php
                                                $content = '';
                                                if (isset($content_data[$field['content_field_id']]['field_contents'])) {
                                                    $content = $content_data[$field['content_field_id']]['field_contents'];
                                                }
                                                ?>
                                                <?php echo $this->view->load('cms/inc-fields/' . $field['field_type'], array('field_alias' => $field['field_alias'], 'content' => $content)); ?>

                                            </div>
                                        <?php } ?>
                                    </div>

                                <?php } ?>
                            <?php } ?>
                            <div role="tabpanel" class="tab-pane" id="tab_content">
                                <br/>
                                <?php echo $this->view->load('cms/pages/page_section/index'); ?>
                            </div>


                            <div role="tabpanel" class="tab-pane" id="tab_includes" style="height: 280px;">
                                <br/>
                                <div class="row">
                                    <?php
                                    if (empty($includes)) {
                                        echo "<p style='color:red; text-align:center'>No Includes Found</p>";
                                    } else {
                                        ?>
                                        <?php foreach ($includes as $key => $val) { ?> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h3 style="border-bottom: 1px solid #ccc; margin-top: 15px; padding-bottom: 15px; font-size: 18px;"><?php echo $key; ?></h3>
                                                </div>
                                            </div>
                                            <?php foreach ($val as $row) { ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php if (in_array($row['include_id'], $page_includes)) { ?><a href="cms/page/disable_include/<?php echo $page_details['page_i18n_id'] . '/' . $row['include_id']; ?>"><img src="assets/themes/default/images/Aqua-Ball-Green-icon.png" /></a><?php } else { ?><a href="cms/page/enable_include/<?php echo $page_details['page_i18n_id'] . '/' . $row['include_id']; ?>"><img src="assets/themes/default/images/Aqua-Ball-Red-icon.png" /></a><?php } ?> &nbsp;
                                                        <?php echo $row['include_name']; ?>
                                                        <div style="margin-bottom: 8px;"></div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group text-right mx-3">
                                <button type="submit" class="btn btn-secondary btn-lg">Edit <?php echo $page_details['content_type_name']; ?></button>
                            </div>
                            <input name="page_i18n_id" type="hidden" id="page_i18n_id" value="<?php echo $page_details['page_i18n_id']; ?>" />


                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


