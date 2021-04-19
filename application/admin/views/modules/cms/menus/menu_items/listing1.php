<div id="content_sidebar_right">
	<div class="grabber"></div>
	<h1>Manage Menu Items</h1>
	<ul class="list-inline">
		<li><a href="cms/menu_item/add/<?php echo $menu_detail['menu_id']; ?>">Add Menu Item</a></li>	
	</ul>
</div>

<div id="content_main">
	<?php $this->load->view('inc-messages'); ?>
	<?php	if($menutree){
				echo $menutree;
			}
	?>
</div>