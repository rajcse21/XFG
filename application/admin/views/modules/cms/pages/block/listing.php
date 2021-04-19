
<div class="row page-blocks">
    <?php
    if ($blocks) {
        foreach ($blocks as $block) {
            ?>
            <div class="col-sm-6 page-block ui-state-default" style="background: none; border: 0px;" id="block_<?php echo $block['page_block_id']; ?>">
                <div class="card" style="margin-bottom: 15px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9">								
                                <h6 class="mb-0">
                                    <?php
                                    if ($block['page_block_name']) {
                                        echo $block['page_block_name'];
                                    } else {
                                        echo $block['page_block_title'];
                                    }
                                    ?>
                                </h6>
                            </div>
                            <div class="col-md-3 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $section['page_section_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="fas fa-cog" aria-hidden="true" ></span>
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu section-menu" aria-labelledby="dropdownMenu<?php echo $section['page_section_id']; ?>">
                                        <?php if (($block['page_global_block_id'] != 0 && $block['allow_duplicate'] == 1) || $block['page_global_block_id'] == 0) { ?>
                                            <a href="javascript:void(0)" data-page_block_id="<?php echo $block['page_block_id']; ?>" class="duplicate_block_cls dropdown-item">Duplicate Block</a>
                                        <?php } ?>
                                        <a href="javascript:void(0);" data-link="cms/block/edit/<?php echo $block['page_block_id']; ?>" class="fancybox dropdown-item" data-fancybox-type="iframe" data-fancybox-width="85%" data-fancybox-height="85%" >Edit</a> 
                                        <a href="cms/block/delete/<?php echo $block['page_block_id']; ?>" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
                    <div class="card-body">
                        <?php
                        $this->load->helper('text');
                        echo '<strong>' . $block['page_block_title'] . '</strong><br/>';
                        echo '<p>' . word_limiter(strip_tags($block['page_block_content'], 50)) . '</p>';
                        ?>
                        <p class="text-left">
                            <span class="fas fa-edit" aria-hidden="true" ></span> <a href="javascript:void(0);" data-link="cms/block/edit/<?php echo $block['page_block_id']; ?>" class="fancybox" data-fancybox-type="iframe" data-fancybox-width="85%" data-fancybox-height="85%" >Edit</a> 
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
