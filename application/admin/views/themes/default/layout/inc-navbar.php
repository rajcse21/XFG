<nav class="navbar fixed-top navbar-expanded navbar-dark text-white bg-info">
	<button class="navbar-toggler d-lg-none mr-auto" type="button" data-toggle="collapse" data-target="#mobileNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<a class="navbar-brand" href="<?php echo base_url(); ?>"><svg height="28" class="octicon octicon-gear" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M14 8.76v-1.6l-1.94-.64-.45-1.09.88-1.84-1.13-1.13-1.81.91-1.09-.45L7.77 1h-1.6l-.63 1.94-1.11.45-1.84-.88-1.13 1.13.91 1.81-.45 1.09L0 7.22v1.59l1.94.64.45 1.09-.88 1.84 1.13 1.13 1.81-.91 1.09.45.69 1.92h1.59l.63-1.94 1.11-.45 1.84.88 1.13-1.13-.92-1.81.47-1.09L14 8.74v.02zm-7 2.23c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path></svg><span>Xpert Finance Group Admin</span></a>

	<!--<button class="navbar-toggler d-md-down-none" type="button" data-toggle="collapse" data-target="#mobileNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>-->

	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link" href="">Home</a>
		</li>
		<?php if ($this->userauth->checkAuth()) { ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Account
				</a>
				<?php /*
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <div class="dropdown-divider"></div>
				  <a class="dropdown-item" href="#">Something else here</a>
				  </div> */ ?>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">

					<a class="dropdown-item" href="user/logout">Logout</a>
				</div>
			</li>
		<?php } ?>
	</ul>
	<?php if ($this->userauth->checkAuth()) { ?>
		<span class="navbar-text mr-3">
			<img src="<?php echo $this->avatar->get('js_thind@hotmail.com'); ?>" class="rounded-circle" />
		</span>
	<?php } ?>
	<!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#asideNav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>-->
</nav>

<!--<nav class="navbar navbar-light bg-light">
	<div class="collapse navbar-collapse" id="mobileNav">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Dropdown
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>
	</div>


</nav>-->