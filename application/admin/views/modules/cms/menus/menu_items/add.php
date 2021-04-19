<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item"><a href="cms/menu">Menu</a></li>
        <li class="breadcrumb-item"><a href="cms/menu_item/index/<?php echo $menu_detail['menu_id']; ?>">Menu Items</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
</nav>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <div class="card bg-light">
                    <div class="card-header">Add Menu Item</div>
                    <div class="card-body">
                        <?php echo form_open('cms/menu_item/add/' . $menu_detail['menu_id'], array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_id">Parent </label>
                                    <?php $invalid_class = form_error('parent_id') ? "is-invalid" : ""; ?>
                                    <?php echo form_dropdown('parent_id', $parent_menu, set_value('parent_id'), 'class="form-control parent_id ' . $invalid_class . '" id="parent_id"'); ?>
                                    <?php echo form_error('parent_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_item_type">Item Type *</label>
                                    <?php $invalid_class = form_error('menu_item_type') ? "is-invalid" : ""; ?>
                                    <?php echo form_dropdown('menu_item_type', $menu_item_types, set_value('menu_item_type'), 'class="form-control menu_item_type' . $invalid_class . '" id="menu_item_type"'); ?>
                                    <?php echo form_error('menu_item_type'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_item_name">Item Name *</label>
                                    <input name="menu_item_name" type="text" class="form-control <?php echo (form_error('menu_item_name')) ? "is-invalid" : ""; ?>" id="menu_item_name" value="<?php echo set_value('menu_item_name') ?>" placeholder="Enter Item Name"/>
                                    <?php echo form_error('menu_item_name'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_item_identifier">Item Identifier </label>
                                    <input name="menu_item_identifier" type="text" class="form-control <?php echo (form_error('menu_item_identifier')) ? "is-invalid" : ""; ?>" id="menu_item_identifier" value="<?php echo set_value('menu_item_identifier') ?>" placeholder="Enter Item Identifier" />
                                    <?php echo form_error('menu_item_identifier'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="menu_item_class">CSS Class </label>
                                    <input name="menu_item_class" type="text" class="form-control <?php echo (form_error('menu_item_class')) ? "is-invalid" : ""; ?>" id="menu_item_class" value="<?php echo set_value('menu_item_class') ?>" placeholder="Enter CSS Class" />
                                    <?php echo form_error('menu_item_class'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_window">Open In New Window </label><br/>
                                    <input type="radio" name="new_window" value="1" <?php echo set_radio('new_window', '1'); ?> />Yes <input type="radio" name="new_window" value="0" <?php echo set_radio('new_window', '0', true); ?> />No
                                    <?php echo form_error('new_window'); ?>
                                </div>
                            </div>
                        </div>
                        <?php /* ?><div class="form-group">
                                  <label for="menu_item_icon" class="control-label" >Item Icon</label>
                                  <?php echo $this->filemanager->render('menu_item_icon'); ?>
                                  </div><hr><?php */ ?>


                        <div class="form-group div-hide page" style="display:none;">
                            <label for="content_id">Page</label>
                            <?php $invalid_class = form_error('content_id') ? "is-invalid" : ""; ?>
                            <?php echo form_dropdown('content_id', $pages, set_value('content_id'), 'class="form-control content_id' . $invalid_class . '" id="content_id"'); ?>
                            <?php echo form_error('content_id'); ?>
                        </div>

                        <div class="form-group div-hide url" style="display:none;">
                            <label for="url">URL </label>
                            <input name="url" type="text" class="form-control <?php echo (form_error('url')) ? "is-invalid" : ""; ?>" id="url" value="<?php echo set_value('url') ?>" placeholder="Enter URL" />
                            <?php echo form_error('url'); ?>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-dark">Add</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
