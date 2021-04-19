<?php if ($parentId == 0) { ?>
    <ul class="ui-sortable" id="sortable">
    <?php } ?>

    <?php
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            ?>
            <li id="menu_<?php echo $element['menu_item_id']; ?>" class="tree-item">
                <div class="row">
                    <div class="col-sm-9 left"><a href="cms/menu_item/edit/<?php echo $element['menu_item_id']; ?>" ><?php echo $element['menu_item_name']; ?></a></div>
                    <div class="col-sm-1 text-right"><a href="cms/menu_item/edit/<?php echo $element['menu_item_id']; ?>"><i class="far fa-edit fa-lg" data-toggle="tooltip" title="Edit"></i></a></div>
                    <div class="col-sm-1 text-right"><a href="cms/menu_item/delete/<?php echo $element['menu_item_id']; ?>" onclick="return confirm('Are you sure you want to delete this Menu ?');" ><i class="far fa-trash-alt fa-lg" data-toggle="tooltip" title="Delete"></i></a>
                    </div>					
                </div>
                <?php
                $children = $this->Menulinkmodel->_menuItemTree($elements, $element['menu_item_id']);
                if (trim($children)) {
                    ?>
                    <ul><li><?php echo $children; ?></li></ul>
                <?php } ?>
            </li>
            <?php
        }
    }

    if ($parentId == 0) {
        ?>
    </ul>
    <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
    <input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<?php } ?>