<body>
	<?php
	require_once('./includes/connectlocal.inc');

	session_start();

	?>
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark z-1 bg-danger">

		<div class="container-fluid ps-3">

			<a href="index.php">
				<img src="./images/logo.svg" alt="logo-banner" class="navbar-brand ms-2 p-0" width="250px">
			</a>

			<button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_button">
				<span class="navbar-toggler-icon text-dark">
				</span>
			</button>
			<div id="navbarNav" class="collapse navbar-collapse">
				<ul class="navbar navbar-nav bg-text-shadow me-auto mb-lg-0">
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="index.php">Home</a>
					</li>
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="anime.php">Anime</a>
					</li>
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="">Lists</a>
					</li>
				</ul>

				<?php
				if (isset($_SESSION['login'])) {
					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-4'>
					<button type='button' class='nav-item btn btn-tertiary navbar-btn btn-sm text-capitalize text-white'id='btn_logout' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem; border-radius: 25px; border-color: #000000;'>Logout</button> </div>";
				} else {
					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-4'>
					<button type='button' class='nav-item btn navbar-btn btn-sm text-primary' id='btn_login' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem; border-radius: 25px; border-color: #2b0806;'>Sign In</button>
					</div>";

					echo "<div class='navbar navbar-nav d-flex align-items-center justify-content-center pe-4'>
					<button type='button' class='nav-item btn btn-primary navbar-btn btn-sm text-capitalize' id='btn_register' style='--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.3rem; --bs-btn-font-size: 0.8rem; border-radius: 25px; ;'>Sign Up</button>
					</div>";
				}
				?>
			</div>
		</div>
	</nav>
</body>

</html>