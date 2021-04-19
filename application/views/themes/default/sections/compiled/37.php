<div class="container <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> class_pt-5">
			<div class="row">
			  <?php foreach ($blocks as $block) {
                echo $block['compiled'];
            }
            ?> 
			</div>
		</div>