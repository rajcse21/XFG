<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/menu">Menus</a></li>
		<li class="breadcrumb-item active">Menu Item</li>
		<li class="ml-auto">
			<a href="cms/menu_item/add/<?php echo $menu_detail['menu_id']; ?>" class="btn btn-dark btn-sm"><i class="fas fa-plus"></i> Add Menu Item</a>
		</li>
	</ol>
</nav>

<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<?php $this->load->view('inc-messages'); ?>
				<?php
				if ($menutree) {
					echo $menutree;
				}
				?>
			</div>
		</div>
	</div>
</div>