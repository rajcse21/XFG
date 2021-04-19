<?php
if (!$blocks) {
    return false;
}
?>
<div class="blue-box-hm">
    <div class="container">
        <div class="row no-gutters">
            <?php
            foreach ($blocks as $block) {
                echo $block['compiled'];
            }
            ?>
        </div>

    </div>
</div>