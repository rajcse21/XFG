<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item active">Menus</li>
		<li class="ml-auto">
			<a href="cms/menu/add" class="btn btn-dark btn-sm"><i class="fas fa-plus"></i> Add Menu</a>
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
							<th scope="col" class="col-5">Menu Name</th>
							<th scope="col" class="col-5">Menu Alias</th>
							<th scope="col" class="col-2">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($menu)) {
							foreach ($menu as $row) {
								?>
								<tr class="d-flex">
									<td class="col-5"><?php echo $row['menu_name']; ?></td>
									<td class="col-4"><?php echo $row['menu_alias']; ?></td>
                                                                        <td class="col-1"><a href="cms/menu_item/index/<?php echo $row['menu_id']; ?>"><i class="far fa-list-alt fa-lg" data-toggle="tooltip" title="Menu Items"></i></a></td>
                                                                        <td class="col-1"><a href="cms/menu/edit/<?php echo $row['menu_id']; ?>"><i class="far fa-edit fa-lg" data-toggle="tooltip" title="Edit"></i></a></td>
                                                                        <td class="col-1"><a href="cms/menu/delete/<?php echo $row['menu_id']; ?>" onclick="return confirm('Are you sure you want to delete this Menu ?');" ><i class="far fa-trash-alt fa-lg" data-toggle="tooltip" title="Delete"></i></a></td>
									
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</div>


