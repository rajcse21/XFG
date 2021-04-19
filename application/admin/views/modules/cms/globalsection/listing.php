<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item active">Global Section</li>
		<li class="ml-auto">
			<a href="cms/globalsection/add" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Global Section</a>
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
							<th scope="col" class="col-6">Section</th>
							<th scope="col" class="col-3">&nbsp;</th>
							<th scope="col" class="col-3">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($global_sections as $section) { ?>
							<tr class="d-flex">
								<td class="col-6">
									<?php if ($section['section_icon']) { ?>
										<img src="<?php echo $section['section_icon']; ?>" alt="<?php echo $section['section_name']; ?>" width='100px' class="img-responsive"/>
									<?php } ?>
									<br/>
									<p class="text-left"><?php echo $section['section_name']; ?></p>
								</td>
								<td class="col-3">&nbsp;</td>
								<td class="col-3 text-right">
									<div class="dropdown">
										<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-cog fa-xs"></i> <span class="caret"></span>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $section['global_section_id']; ?>">
											<a class="dropdown-item" href="cms/globalsection/edit/<?php echo $section['global_section_id']; ?>">Edit</a>
											<a class="dropdown-item" href="cms/globalsection/delete/<?php echo $section['global_section_id']; ?>" onclick="return confirm('Are you sure you want to delete this ?');" >Delete</a>
											<a class="dropdown-item" href="cms/globalblock/index/<?php echo $section['global_section_id']; ?>">Blocks</a>
										</div>
									</div>

								</td>

							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</div>



