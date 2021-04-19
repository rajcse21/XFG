<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Manage Additional Fields</h1>
		</div>	
		<div class="col-md-4 text-right">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $content_type['content_type_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Action
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $content_type['content_type_id']; ?>">
					<li><a href="content_type/fieldgroup/index/<?php echo $content_type['content_type_id']; ?>">Manage Field Groups</a></li>
					<li><a href="content_type/fields/add/<?php echo $content_type['content_type_id']; ?>">Add Additional Field</a></li>	
				</ul>
			</div>
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li class="active">Additional Fields - <?php echo $content_type['content_type_name']; ?></li>
</ol>
<div id="content_main">
	<?php $this->load->view('inc-messages'); ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th width="30%">Field</th>
				<th width="30%">Field Alias</th>
				<th width="25%">Field Group</th>
				<th width="25%">&nbsp;</th>
			</tr>
		</thead>
		<?php if ($content_fields) { ?>
			<tbody>
				<?php foreach ($content_fields as $item) { ?>
					<tr>
						<th scope="row"><?php echo $item['field_label']; ?></th>
						<th scope="row"><?php echo $item['field_alias']; ?></th>
						<th scope="row"><?php echo ($item['content_fieldgroup']) ? $item['content_fieldgroup'] : 'Main'; ?></th>
						<td class="text-right">
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $item['content_field_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="glyphicon glyphicon-cog" aria-hidden="true" ></span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $item['content_field_id']; ?>">
									<li><a href="content_type/fields/edit/<?php echo $item['content_field_id']; ?>">Edit</a></li>
									<li><a href="content_type/fields/delete/<?php echo $item['content_field_id']; ?>" onclick="return confirm('Are you sure you want to delete this field ?');">Delete</a></li>
								</ul>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		<?php } ?>
	</table>
</div>