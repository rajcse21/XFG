<?php if ($sections) { ?>
	<div class="page_sections" id="accordion11">
		<?php
		foreach ($sections as $section) {
			$tx_card_color = '';
			$tx_header_color = '';
			if ($section['page_section_is_active'] == 0) {
				$tx_card_color = 'border-danger';
				$tx_header_color = 'color:#dc3545';
			}
			$section_name = $section['page_section_name'];
			if ($section['global_section_id'] != 0) {
				$section_name = $section['page_section_name'] . ' (G:' . $section['section_name'] . ')';
			}
			?>
			<div id="section-<?php echo $section['page_section_id']; ?>" class="card section <?php echo $tx_card_color; ?>" style="margin-bottom: 10px;">
				<div class="card-header" style="<?php echo $tx_header_color; ?>" id="section-head-<?php echo $section['page_section_id']; ?>">
					<div class="row">
						<div class="col-md-10">
							<h5 class="mb-0">
								<a class="btn btn-link" data-toggle="collapse" data-target="#section-body-<?php echo $section['page_section_id']; ?>" aria-expanded="true" aria-controls="section-body-<?php echo $section['page_section_id']; ?>">							
									<i class="section_panel_icons fa fa-minus fa-xs mr-2"></i><?php echo $section_name; ?>
								</a>
							</h5>
						</div>
						<div class="col-md-2 text-right">
							<div class="dropdown">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $section['page_section_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="fas fa-edit" aria-hidden="true" ></span>
									<span class="caret"></span>
								</button>
								<div class="dropdown-menu section-menu" aria-labelledby="dropdownMenu<?php echo $section['page_section_id']; ?>">
									<a class="dropdown-item fancybox" href="javascript:void(0);" data-link="cms/page_section/edit/<?php echo $section['page_section_id']; ?>">Edit</a>
									<a class="dropdown-item ajax_content" href="cms/page_section/isActive/<?php echo $section['page_section_id']; ?>"><?php echo ($section['page_section_is_active']) ? 'Disable' : 'Enable'; ?></a>							
									<a class="dropdown-item ajax_content" href="cms/page_section/delete/<?php echo $section['page_section_id']; ?>">Delete</a>
									<?php if ($section['global_section_id'] == 0) { ?>
										<a class="dropdown-item fancybox" href="javascript:void(0);" data-link="cms/block/add/<?php echo $section['page_section_id']; ?>">Add Block</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="section-body-<?php echo $section['page_section_id']; ?>" data-id="<?php echo $section['page_section_id']; ?>" class="collapse show" aria-labelledby="section-body-<?php echo $section['page_section_id']; ?>" data-parent="#accordion">
					<div class="card-body">
						<div class="section_panel">							
							<?php
							$inner = array();
							$inner['section'] = $section;
							$blocks = array();
							if (isset($section['blocks'])) {
								$blocks = $section['blocks'];
							}
							$inner['blocks'] = $blocks;

							echo $this->view->load('cms/pages/block/listing', $inner);
							?>						
						</div>
					</div>
				</div>
			</div>

		<?php }
		?>
	</div>
	<?php
}
?>