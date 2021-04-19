<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item active">Global Block</li>
		<li class="ml-auto">
			<a href="cms/globalblock/add" class="btn btn-dark btn-sm"><i class="fas fa-plus"></i> Add Global Block</a>
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
							<th scope="col" class="col-5">Block Name</th>
							<th scope="col" class="col-4">Block Alias</th>
							<th scope="col" class="col-3">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($global_blocks){
						foreach ($global_blocks as $block) {
							$enable_disable_link = 'cms/globalblock/disable/' . $block['global_block_id'];
							$enable_disable_text = '<i class="fas fa-eye fa-lg" data-toggle="tooltip" title="Disable"></i>';
							if ($block['block_is_active'] == 0) {
								$enable_disable_text = '<i class="fas fa-eye-slash fa-lg" data-toggle="tooltip" title="Enable"></i>';
								$enable_disable_link = 'cms/globalblock/enable/' . $block['global_block_id'];
							}
							?>
							<tr class="d-flex">
								<td class="col-5">
									<p class="text-left"><?php echo $block['block_name']; ?></p>
								</td>
								<td class="col-4"><?php echo $block['block_alias']; ?></td>
                                                                <td class="col-1">
                                                                    <a href="<?php echo $enable_disable_link; ?>"><?php echo $enable_disable_text; ?></a>
                                                                </td>
                                                                <td class="col-1">
                                                                    <a href="cms/globalblock/edit/<?php echo $block['global_block_id']; ?>"> <i class="far fa-edit fa-lg" data-toggle="tooltip" title="Edit"></i></a>
                                                                </td>
                                                                <td class="col-1">
                                                                    <a href="cms/globalblock/delete/<?php echo $block['global_block_id']; ?>" onclick="return confirm('Are you sure you want to delete this ?');" ><i class="far fa-trash-alt fa-lg" data-toggle="tooltip" title="Delete"></i></a>
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