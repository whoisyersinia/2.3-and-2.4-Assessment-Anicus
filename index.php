<!DOCTYPE html>
<html lang="en">

<?php
include('./includes/basehead.html');
session_start();
?>

<head>
	<title>Anicus</title>
</head>

<body>
	<?php
	include('header.php');
	global $_executed;
	$_executed = False;
	var_dump($_executed);
	if (!$_executed) {
		echo 'je';
		$_executed = True;
		global $_executed;
		var_dump($_executed);
	} else {
		echo 'jeee';
	}
	// if (!$_executed) {
	// 	echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
	// 	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
	// 	id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
	// 	<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
	// 	</svg>";

	// 	echo "Welcome, " . $_SESSION['login']['username'] . ".";

	// 	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
	// 	</div>";
	// 	$_executed = TRUE;
	// }

	?>
	<div class="img-fluid banner-image w-100 vh-100 d-flex justify-content-center align-items-center z-0">
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
				<h2 class="fw-bold">Keep it easy with us...</h2>
				<p>Anicus with </p>
			</div>
		</div>
		<div class="col-md-6">
			<div class="h-100 bg-light border rounded-3">
				<img src="../images/list.png" alt="list" width="1rem" height="1rem">
			</div>
		</div>
	</div>

</body>

<?php
include('footer.php');
?>

</html>