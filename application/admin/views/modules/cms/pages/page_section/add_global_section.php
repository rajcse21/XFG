<div id="popup_container" style="margin:40px;">
	<div class="row equiheight-wrapper" data-equiheight-count="1">			
		<?php
		$count = 0;
		$lg_count = 0;
		foreach ($global_sections as $global_section) {
			$count++;
			$lg_count++;
			?>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-bottom:10px">
				<div class="global_section">
					<div class="row" style="margin-bottom: 10px">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="equiheight-dis-1">
								<p><strong><?php echo $global_section['section_name']; ?></strong></p>
								<?php if ($global_section['section_icon']) { ?>
									<p><img src="<?php echo $global_section['section_icon']; ?>" class="img-responsive" style='width: 100%;' /></p>
								<?php } else { ?>
									<p>
										<img src="assets/themes/default/images/custom-section.png" class="img-responsive" style='width: 100%;'/>
									</p>

								<?php } ?>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php $this->load->view('inc-messages'); ?>
							<?php echo form_open("cms/page_section/globalSection/{$page_details['page_i18n_id']}", 'class="sectionFrm" id="sectionFrm"'); ?>
							<input type="hidden" name="page_i18n_id" class="page_i18n_id" value="<?php echo $page_details['page_i18n_id']; ?>" />
							<input type="hidden" name="global_section_id" class="global_section_id" value="<?php echo $global_section['global_section_id']; ?>" />
							<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
							<input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<button type="submit" class="btn btn-default btn-sm text-center">Add Section</button>
							<?php echo form_close(); ?>
						</div>

					</div>


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

		<?php }
		?>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" style="margin-bottom:10px">
			<div class="global_section">
				<div class="row" style="margin-bottom: 10px">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="equiheight-dis-1">
							<p><strong>Custom Section</strong></p>						
							<p>
								<img src="assets/themes/default/images/custom-section.png" class="img-responsive" style='width: 100%;'/>
							</p>

						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php $this->load->view('inc-messages'); ?>
						<?php echo form_open("cms/page_section/globalSection/{$page_details['page_i18n_id']}", 'class="sectionFrm" id="sectionFrm"'); ?>
						<input type="hidden" name="page_i18n_id" class="page_i18n_id" value="<?php echo $page_details['page_i18n_id']; ?>" />
						<input type="hidden" name="global_section_id" class="global_section_id" value="0" />
						<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
						<input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<button type="submit" class="btn btn-default btn-sm text-center">Add Section</button>
						<?php echo form_close(); ?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<!--<p style="text-align:center"><?php echo $pagination; ?></p>-->
