<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item active">Content Types</li>
		<li class="ml-auto">
			<a href="content_type/content_type/add" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Content Type </a>
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
							<th scope="col" class="col-4">Content Type</th>
							<th scope="col" class="col-4">&nbsp;</th>
							<th scope="col" class="col-4">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($content_types as $item) { ?>
							<tr class="d-flex">
								<td class="col-4"><?php echo $item['content_type_name']; ?></td>
								<td class="col-4">&nbsp;</td>
								<td class="col-4 text-right">
									<div class="dropdown">
								<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-cog fa-xs"></i> <span class="caret"></span>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $item['content_type_id']; ?>">
									<a class="dropdown-item" href="content_type/content_type/edit/<?php echo $item['content_type_id']; ?>">Edit</a>
									<?php /*<a class="dropdown-item" href="content_type/fields/index/<?php echo $item['content_type_id']; ?>">Additional Fields</a>
									<a class="dropdown-item" href="content_type/stream/index/<?php echo $item['content_type_id']; ?>">Content Streams</a>*/?>
									<a class="dropdown-item" href="content_type/content_type/delete/<?php echo $item['content_type_id']; ?>" onclick="return confirm('Are you sure you want to Delete this Link ?');">Delete</a>
								</div>
							</div>
								</td>

							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

