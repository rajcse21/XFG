<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/globalsection/index">Global Sections</a></li>
		<li class="breadcrumb-item active">Global Block</li>
		<li class="ml-auto">
			<a href="cms/globalblock/add/<?php echo $section['global_section_id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Global Block</a>
		</li>
	</ol>
</nav>

<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<?php $this->load->view('inc-messages'); ?>
				<table class="table table-hover">
					<thead class="thead-light">
						<tr class="d-flex">
							<th scope="col" class="col-4">Block Name</th>
							<th scope="col" class="col-4">Block Alias</th>
							<th scope="col" class="col-4">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($global_blocks){
						foreach ($global_blocks as $block) {
							$enable_disable_link = 'cms/globalblock/disable/' . $block['global_block_id'];
							$enable_disable_text = 'Disable';
							if ($block['block_is_active'] == 0) {
								$enable_disable_text = 'Enable';
								$enable_disable_link = 'cms/globalblock/enable/' . $block['global_block_id'];
							}
							?>
							<tr class="d-flex">
								<td class="col-4">
									<p class="text-left"><?php echo $block['block_name']; ?></p>
								</td>
								<td class="col-4"><?php echo $block['block_alias']; ?></td>
								<td class="col-4 text-right">
									<div class="dropdown">
										<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-cog fa-xs"></i> <span class="caret"></span>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $block['global_block_id']; ?>">
											<a class="dropdown-item" href="<?php echo $enable_disable_link; ?>"><?php echo $enable_disable_text; ?></a>
											<a class="dropdown-item" href="cms/block_field/index/<?php echo $block['global_block_id']; ?>">Additional Fields</a>
											<a class="dropdown-item" href="cms/globalblock/edit/<?php echo $block['global_block_id']; ?>">Edit</a>
											<a class="dropdown-item" href="cms/globalblock/delete/<?php echo $block['global_block_id']; ?>" onclick="return confirm('Are you sure you want to delete this ?');" >Delete</a>
										</div>
									</div>

								</td>

							</tr>
						<?php }
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
