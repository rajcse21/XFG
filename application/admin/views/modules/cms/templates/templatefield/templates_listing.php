<div id="content_sidebar_right">
	<div class="grabber"></div>
	<ul class="side-nav">
		<li><a href="cms/templatefield/add/<?php echo $template['page_template_id']; ?>">Add Field</a></li>		
	</ul>
</div>
<div id="content_main">
	<h1>Manage Template Fields</h1>
	<?php $this->load->view('inc-messages'); ?>
	<ul class="breadcrumbs">
		<li><a href="cms/template">Page Templates</a></li>
		<li class="current">Additional Fields - <?php echo $template['template_name']; ?></li>
	</ul>
	<?php if (count($templates_fields) == 0) {
		$this->load->view('inc-norecords');
	} else { ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Fields</th>
					<th class="text-right">Action</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($templates_fields as $item) { ?>
					<tr>
						<td><?php echo $item['template_field_label']; ?></td>
						<td class="text-right"><a href="cms/templatefield/edit/<?php echo $item['template_field_id']; ?>">Edit</a> | <a href="cms/templatefield/delete/<?php echo $item['template_field_id']; ?>" onclick="return confirm('Are you sure you want to delete this Template Field?');">Delete</a></td>
					</tr>
		<?php } ?>
					</tbody>
			</table>
<?php } ?>
	<p style="text-align:center"><?php echo $pagination; ?></p>
	</div>