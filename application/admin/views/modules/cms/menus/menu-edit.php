<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="user">Home</a></li>
		<li class="breadcrumb-item"><a href="cms/menu">Menu</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</nav>
<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-12">
			<div class="p-3">
				<div class="card bg-light">
					<div class="card-header">Edit Menu</div>
					<div class="card-body">
						<?php echo form_open('cms/menu/edit/' . $menu['menu_id'], array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="menu_name">Name *</label>
									<input name="menu_name" type="text" class="form-control <?php echo (form_error('menu_name')) ? "is-invalid" : ""; ?>" id="menu_name" value="<?php echo set_value('menu_name', $menu['menu_name']) ?>" placeholder="Enter Menu" />
									<?php echo form_error('menu_name'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="menu_title">Display Name </label>
									<input name="menu_title" type="text" class="form-control <?php echo (form_error('menu_title')) ? "is-invalid" : ""; ?>" id="menu_title" value="<?php echo set_value('menu_title', $menu['menu_title']) ?>" placeholder="Enter Display Name" />
									<?php echo form_error('menu_title'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="menu_alias">Alias *</label>
									<input name="menu_alias" type="text" class="form-control <?php echo (form_error('menu_alias')) ? "is-invalid" : ""; ?>" id="menu_alias" value="<?php echo set_value('menu_alias', $menu['menu_alias']) ?>" placeholder="Enter Alias" />
									<?php echo form_error('menu_alias'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="menu_link">Link </label>
									<input name="menu_link" type="text" class="form-control <?php echo (form_error('menu_link')) ? "is-invalid" : ""; ?>" id="menu_link" value="<?php echo set_value('menu_link', $menu['menu_link']) ?>" placeholder="Enter Link" />
									<?php echo form_error('menu_link'); ?>
								</div>
							</div>
						</div>
						<div class="form-group text-right">
							<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $menu['menu_id']; ?>" >
							<button type="submit" class="btn btn-dark">Update</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>