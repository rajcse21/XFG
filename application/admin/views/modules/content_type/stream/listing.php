<div class="head_bar">
	<div class="row">
		<div class="col-md-8">
			<h1>Manage Content Stream</h1>
		</div>	
		<div class="col-md-4 text-right">
			<a class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Add Content Stream" href="content_type/stream/add/<?php echo $content_type['content_type_id']; ?>">
				Add Content Stream <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
			</a>
		</div>
	</div>
</div>
<ol class="breadcrumb">
	<li><a href="content_type/content_type">Content Types</a></li>
	<li class="active">Content Streams - <?php echo $content_type['content_type_name']; ?></li>		
</ol>
<div id="content_main">
	<?php $this->load->view('inc-messages'); ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th width="30%">Stream Name</th>
				<th width="30%">Content Type</th>
				<th width="25%">Per Page</th>
				<th width="15%">&nbsp;</th>
			</tr>
		</thead>
		<?php if ($streams) { ?>
			<tbody>
				<?php foreach ($streams as $item) { ?>
					<tr>
						<th scope="row"><?php echo $item['stream_name']; ?></th>
						<th><?php echo $item['content_type_name']; ?></th>
						<th><?php echo $item['item_per_stream']; ?></th>
						<td class="text-right">
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $item['content_stream_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="glyphicon glyphicon-cog" aria-hidden="true" ></span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $item['content_stream_id']; ?>">
									<li><a href="content_type/stream/edit/<?php echo $item['content_stream_id']; ?>">Edit</a></li>
									<li><a href="content_type/stream/delete/<?php echo $item['content_stream_id']; ?>" onclick="return confirm('Are you sure you want to delete this Stream?');">Delete</a></li>
								</ul>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		<?php } ?>
	</table>
</div>
