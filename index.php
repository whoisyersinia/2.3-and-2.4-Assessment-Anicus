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

	// check if user is logged in and if the welcome message has popped up or not
	if (isset($_SESSION['login']) && (!isset($_SESSION['welcome_message']))) {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Welcome, " . $_SESSION['login']['username'] . ".";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";

		// ensure that welcome message only prints once after login
		$_SESSION['welcome_message'] = True;
	}

	if (isset($_SESSION['login'])) {
		$_SESSION['login'] = time();
		// automatically logout user in specific amount of time  - specifed below (default: 3 days?)
		$inactive = 30;
		$session_time = time() - $_SESSION['login'];

		if ($session_time > $inactive) {
			header("Location: logout.php");
		}
	}

	if (!empty($_GET['s'])) {
		echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
			<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
		</svg>";

		echo "You have been logged out!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
			</div>";
		header("refresh:3;url=index.php");
	}


	?>

	<!--START OF HTML - HOMEPAGE -->
	<div class="img-fluid banner-image w-100 vh-100 d-flex justify-content-center align-items-center z-0 ">
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

	<div class="container-fluid overflow-hidden px-4 py-5 bg-dark w-100 shadow-lg">
		<div class="row">
			<div class="col-md-7">
				<div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg hover-zoom card_img">
					<div class="d-flex flex-column h-100 px-4 pt-5 mt-5 text-white text-shadow-1">
						<ul class="d-flex list-unstyled mt-auto">
							<li class="me-auto pt-5 mt-5">
								<img class="rounded-circle border border-white" src="./images/cat_transparent.svg" width="32" height="32" alt="logo" loading="lazy">
							</li>
							<li class="d-flex align-items-center">
								<a class="text-decoration-none text-white pt-5 mt-5"><small>Anicus 2023</small></a>
							</li>
						</ul>
					</div>

				</div>
			</div>
			<div class="col-md-5 text-end m-0 fade-right reveal_once">
				<h2 class="fw-bold ">Welcome to the <span class="text-white text_effect">World of Anime.</span></h2>
				<p>Anime is a type of animation originating from Japan. It has a wide range of genres for all type of viewers, including, but not limted to: <span class="fw-bold">action, drama, romance, comedy, horror, fantasy, sports, sci-fi, 'slice of life'</span> etc.</p>
				<hr>
				</hr>
				<h4>Don't know where to start?</h4>

				<div class="d-inline-flex">
					<i class="fa-solid fa-check pt-1 px-2"></i>
					<a href="#" class="text-decoration-underline text-primary">
						<h5 class="text-muted">Check our 'Anime for Beginners Lists'</h5>
					</a>
				</div>
				<!--SEARCH FORM-->
				<form class="d-inline-flex pt-2" action="search.php" method="POST">
					<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" value="<?php if (isset($_POST['searchterm'])) echo $_POST['searchterm']; ?>">
					<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
				</form>
			</div>
		</div>

	</div>

	<div class="overflow-hidden container-fluid my-5">
		<div class="row">
			<div class="promo_text text-primary">
				<h3 class="fw-bold">Create your own list</h3>
				<p>Tired of keeping track of all the Anime you've watched?</p>
			</div>
		</div>
	</div>

	<div class="container-fluid px-4 py-5 bg-dark w-100">
		<div class="row">
			<div class="col-md-7 px-4">
				<h2 class="fw-bold">Anime listing made easy <span class="text-muted text_effect">with us.</span></h2>
			</div>
			<div class="col-md-5">
				<div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg hover-zoom card_img_2">
					<div class="d-flex flex-column h-100 p-5 pb-3 mt-5 text-white text-shadow-1">
						<ul class="d-flex list-unstyled mt-auto">
							<li class="me-auto pt-5 mt-5">
								<img class="rounded-circle border border-white" src="./images/cat_transparent.svg" width="32" height="32" alt="logo" loading="lazy">
							</li>
							<li class="d-flex align-items-center">
								<a class="text-decoration-none text-white pt-5 mt-5"><small>Anicus 2023</small></a>
							</li>
						</ul>
					</div>
				</div>

				</p>
			</div>
		</div>
	</div>


</body>


<?php
include('footer.php');
?>

</html>