<div class="container <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> class_py-5 class_text-center">
    <div class="calc_wrapper">
        <?php
        $chunk_blocks = array_chunk($blocks, 3);
        foreach ($chunk_blocks as $blocks) {
            ?>
            <div class="row mt-3">
                <?php
                foreach ($blocks as $block) {
                    echo $block['compiled'];
                }
                ?>
            </div>
        <?php }
        ?>          
    </div>
</div>