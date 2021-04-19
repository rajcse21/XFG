<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Manage Additional Field Groups</h1>
		</div>	
		<div class="col-md-4 text-right">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $content_type['content_type_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Action
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $content_type['content_type_id']; ?>">
					<li><a href="content_type/fieldgroup/add/<?php echo $content_type['content_type_id']; ?>">Add Field Group</a></li>
					<li><a href="content_type/fields/add/<?php echo $content_type['content_type_id']; ?>">Add Additional Field</a></li>		
				</ul>
			</div>
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li class="current">Additional Field Groups - <?php echo $content_type['content_type_name']; ?></li>
</ol>

<div id="content_main">
	<?php $this->load->view('inc-messages'); ?>
	<table id="table_fields" class="table table-hover">
		<thead>
			<tr>
				<th width="85%">Field Group</th>
				<th width="15%">&nbsp;</th>
			</tr>
		</thead>
		<?php if ($fieldgroups) { ?>
			<tbody>
				<?php foreach ($fieldgroups as $item) { ?>
					<tr id="<?php echo $item['content_fieldgroup_id']; ?>">
						<td style="font-weight:bold;"><?php echo $item['content_fieldgroup']; ?></th>
						<td class="text-right">
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $item['content_fieldgroup_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="glyphicon glyphicon-cog" aria-hidden="true" ></span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $item['content_fieldgroup_id']; ?>">
									<li><a href="content_type/fieldgroup/edit/<?php echo $item['content_fieldgroup_id']; ?>">Edit</a></li>
									<li><a href="content_type/fieldgroup/delete/<?php echo $item['content_fieldgroup_id']; ?>" onclick="return confirm('Are you sure you want to Delete this Link ?');">Delete</a></li>
								</ul>
							</div>
						</td>
					</tr>
				<?php } ?>
			<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
			<input type="hidden" name="csrf_hash" id="csrf_hash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</tbody>
		<?php } ?>
	</table>
</div>
<div id="dialog-modal" title="Working">
    <p style="text-align: center; padding-top: 40px;">Updating the sort order...</p>
</div>



