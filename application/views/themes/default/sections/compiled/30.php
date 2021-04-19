<div class="calc-section <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> py-5" style="background: url(<?php echo $page_section['page_section_background']; ?>)">
    <div class="container">
        <div class="row">
            <?php
            foreach ($blocks as $block) {
                echo $block['compiled'];
            }
            ?>           
        </div>
    </div>
</div>