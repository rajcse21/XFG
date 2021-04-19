<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item active"><?php echo $content_type['content_type_name']; ?></li>
		<li class="ml-auto">
			<a href="cms/page/add/<?php echo $content_type['content_type_id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add <?php echo $content_type['singular_name']; ?> </a>
		</li>
	</ol>
</nav>

<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">			
			<div class="p-3">				
				<table id="table_fields" class="table table-hover">
					<thead class="thead-light">
						<tr class="d-flex">
							<th scope="col" class="col-4">Page Name</th>
							<th  scope="col" class="col-4">URI</th>
							<th  scope="col" class="col-4">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pages as $page) { ?>
							<tr id="<?php echo $page['page_id']; ?>" class="d-flex">						
								<td  class="col-4" style="font-weight:bold;"><?php echo $page['page_name']; ?></td>
								<td  class="col-4"><?php echo $page['page_uri']; ?></td>
								<td class="col-3 text-right">
									<a class="btn btn-secondary btn-sm" href="cms/page/edit/<?php echo $page['page_i18n_id']; ?>">Edit</a> <a class="btn btn-secondary btn-sm" href="cms/page/delete/<?php echo $page['page_i18n_id']; ?>" data-toggle="confirmation" onClick='return confirm("Are you sure you want to delete this?");'>Delete</a>									
								</td>
							</tr>
						<?php } ?>
					<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
					<input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</tbody>
				</table>
				<div id="dialog-modal" title="Working" style="display:none;">
					<p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
				</div>
			</div>
		</div>
	</div>
</div>