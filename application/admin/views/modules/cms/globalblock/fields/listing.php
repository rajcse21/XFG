<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<?php if ($block['global_section_id'] != 0) { ?>
			<li class="breadcrumb-item"><a href="cms/globalsection/index/">Global Section</a></li>
			<li class="breadcrumb-item"><a href="cms/globalblock/index/<?php echo $block['global_section_id']; ?>">Global Blocks</a></li>
		<?php } else { ?>
			<li class="breadcrumb-item"><a href="cms/globalblock">Global Blocks</a></li>
		<?php } ?>
		<li class="breadcrumb-item active">Additional Fields</li>
		<li class="ml-auto">
			<a href="cms/block_field/add/<?php echo $block['global_block_id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Additional Field</a>
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
							<th scope="col" class="col-4">Label</th>
							<th scope="col" class="col-4">Alias</th>
							<th scope="col" class="col-4">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($fields) {
							foreach ($fields as $field) {
								?>
								<tr class="d-flex">
									<td class="col-4"><?php echo $field['field_label']; ?></td>
									<td class="col-4"><?php echo $field['field_alias']; ?></td>
									<td class="col-4 text-right">
										<div class="dropdown">
											<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fa fa-cog fa-xs"></i> <span class="caret"></span>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $field['globalblock_field_id']; ?>">
												<a class="dropdown-item" href="cms/block_field/edit/<?php echo $field['globalblock_field_id']; ?>">Edit</a>
												<a class="dropdown-item" href="cms/block_field/delete/<?php echo $field['globalblock_field_id']; ?>" onclick="return confirm('Are you sure you want to delete this ?');" >Delete</a>
											</div>
										</div>

									</td>

								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
