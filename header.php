<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<?php
	require_once('./includes/connectlocal.inc');
	if ($_SESSION['logged_in'] == True) {
		echo "<p class='text-success'>Sucessfully logged in!</p>";
	} else {
		echo "<p class'text-warning'>You're not logged in</p>";
	}

	?>
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark">

		<div class="container-fluid ps-3">

			<a href="">
				<img src="./images/logo.svg" alt="logo-banner" class="navbar-brand ms-2 p-0" width="250px">
			</a>

			<button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_button">
				<span class="navbar-toggler-icon text-dark"></span>
			</button>
			<div id="navbarNav" class="collapse navbar-collapse">
				<ul class="navbar navbar-nav bg-text-shadow me-auto mb-lg-0">
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="">Home</a>
					</li>
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="">Anime</a>
					</li>
					<li class="nav-item px-3">
						<a class="nav-link text-primary fw-normal" href="">Lists</a>
					</li>
				</ul>
				<div class="navbar navbar-nav d-flex align-items-center justify-content-center pe-4">
					<button type="button" class="nav-item btn btn-primary navbar-btn btn-sm text-capitalize" style="--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 0.8rem; border-radius: 25px; border-color: #2b0806;" onclick="window.location.href='register.php'" tabindex=0>Sign Up</button>
				</div>
			</div>
		</div>
	</nav>
</body>

</html>