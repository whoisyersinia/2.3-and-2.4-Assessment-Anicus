<!DOCTYPE html>
<html lang="en">

<?php
include('basehead.php')
?>

<head>
	<title>Anicus</title>
</head>

<body>
	<?php
	include('header.php')
	?>
	<div class="img-fluid banner-image w-100 vh-100 d-flex justify-content-center align-items-center">
		<div class="container-fluid">
			<main class="bg-text">
				<div class="px-4 text-left content">
					<div class="hstack gap-3">
						<p class="lead text-primary mb-4 text-shadow-1">For You</p>
						<div class="vr mb-4"></div>
						<p class="lead mb-4 text-primary text-shadow-1 fw-bold">By You</p>
					</div>
				</div>
				<div class="px-4 text-left content text-primary">
					<h1 class="fw-bold main-text start_fade-left">Organise<span class="period">.</span></h1>
					<h1 class="fw-bold main-text start_fade-left">Share<span class="period">.</span></h1>
					<h1 class="fw-bold main-text start_fade-left">List<span class="period">.</span></h1>
				</div>
				<div class="px-4 my-5 content">
					<button type="button" class="btn btn-primary btn-rounded btn-lg px-4" style="--bs-btn-padding-y: 0.75rem; --bs-btn-padding-x: 2rem; --bs-btn-font-size: 0.9rem; border-radius: 25px; border-color: #2b0806;" id="sign_up"> Start Listing Now</button>
				</div>

			</main>
		</div>
	</div>

	<div class="row overflow-hidden container-fluid my-5">
		<div class="promo_text text-primary">
			<h3 class="fw-bold">Create your own list</h3>
			<p>Tired of keeping track of all the Anime you've watched?</p>
		</div>
	</div>

	<div class="row align-items-md-stretch py-5 mx-auto bg-dark overflow-hidden container-fluid">
		<div class="col-md-6">
			<div class="h-100 p-5 text-bg-dark rounded-3">
				<h2 class="fw-bold">placeholder text</h2>
				<p></p>

			</div>
		</div>
		<div class="col-md-6">
			<div class="h-100 bg-light border rounded-3">
				<img src="../images/list.png" alt="list" width="1rem" height="1rem">
			</div>
		</div>
	</div>


	<?php
	require_once('./connectlocal.inc');
	$q = "SELECT * FROM `user`";

	$r = mysqli_query($conn, $q);

	while ($row = mysqli_fetch_assoc($r)) {
		echo "<h1>$row[username]<h1>";
	}
	?>
</body>

</html>