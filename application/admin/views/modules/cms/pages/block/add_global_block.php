<div id="popup_container" style="margin:40px;">
	<div class="row equiheight-wrapper" data-equiheight-count="2">			
		<?php
		$count = 0;
		$lg_count = 0;
		if ($global_blocks) {
			foreach ($global_blocks as $global_block) {
				$count++;
				$lg_count++;
				?>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-bottom:10px">
					<div class="global_section">
						<div class="row" style="margin-bottom: 10px">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<p class="equiheight-1">	<strong><?php echo $global_block['block_name']; ?></strong></p>
								<?php if ($global_block['block_icon']) { ?>
									<p class="equiheight-2"><img src="<?php echo $global_block['block_icon']; ?>" class="img-responsive" style='width: 100%;' /></p>
								<?php } else { ?>
									<span class="glyphicon glyphicon-modal-window" style="font-size:20px;"></span>

								<?php } ?>
								<?php $this->load->view('inc-messages'); ?>
								<?php echo form_open("cms/block/globalBlock/{$section['page_section_id']}"); ?>
								<input type="hidden" name="section_id" value="<?php echo $section['page_section_id']; ?>" />
								<input type="hidden" name="global_block_id" class="global_block_id" value="<?php echo $global_block['global_block_id']; ?>" />
								<div class="section_btn">
									<button type="submit" class="btn btn-default text-center">Add Block</button>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>

					</div>
				</div>

				<?php if ($count == 4) { ?><div style="clear:both;" class="hidden-sm hidden-xs"></div><?php
					$count = 0;
				}
				?>
				<?php if ($lg_count == 3) { ?><div style="clear:both;" class="visible-sm visible-xs"></div><?php
					$lg_count = 0;
				}
				?>

				<?php
			}
		}
		?>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-bottom:10px">
			<div class="global_section">
				<div class="row" style="margin-bottom: 10px">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<p class="equiheight-1"><strong>Custom Block</strong></p>
						<p class="equiheight-2">Custom Block with its own custom template.</p>
						<?php $this->load->view('inc-messages'); ?>
						<?php echo form_open("cms/block/globalBlock/{$section['page_section_id']}"); ?>
						<input type="hidden" name="section_id" value="<?php echo $section['page_section_id']; ?>" />
						<input type="hidden" name="global_block_id" class="global_block_id" value="0" />
						<div class="section_btn">
							<button type="submit" class="btn btn-default text-center">Add Block</button>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!--<p style="text-align:center"><?php echo $pagination; ?></p>-->
