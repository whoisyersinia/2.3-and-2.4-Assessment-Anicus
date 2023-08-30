<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_POST['search'])) {
	$searchtitle = $_POST['searchterm'];
	$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$searchtitle%')";
	$r = mysqli_query($conn, $q);
}
if (mysqli_num_rows($r) == 0) {
	$msg = "<h1 class=''>Sorry, no results found!</h1>";
}

// count how many results are there
$result_count = 0;
$animeresult = array();

while ($row = mysqli_fetch_array($r)) {
	$msg = "<h1 class='fs-1'>Here's what we found for $searchtitle. </h1>";
	$result_count += 1;

	if ($row['date_aired'] !== '0000-00-00') {
		$da = $row['date_aired'];
	} else {
		$da = NULL;
	}
	if ($row['synopsis'] !== NULL) {
		$sy = $row['synopsis'];
	} else {
		$sy = NULL;
	}


	array_push($animeresult, "<div class='container-fluid pt-3'>
					<div class='row row-cols-sm-1 row-cols-lg-4 row-cols-md-2 d-flex g-5 align-items-sm-start justify-content-sm-start p-0'>
						<div class='col d-flex justify-content-start align-self-start'>
							<div class='card' style='width: 18rem;'>
								<img src='./images/bg-4.png' class='card-img-top' alt='...>
								<div class='card-body m-2'>
									<h5 class='card-title text-break fw-bold' style='font-size: clamp(1rem, 1.3vw, 1.5rem);'>$row[title]</h5>
									<h6 class='card-subtitle mb-2 text-wrap text-tertiary'>$row[genre]</h6>
									<h6 class='card-title text-break;'>Episodes: $row[episodes]</h6>
									<h6 class='card-subtitle mb-2 text-wrap'>Date aired: $da</h6>
									<h6 class='card-subtitle text-wrap'>$sy</h6>
								</div>
							</div>
						</div>
					</div>
				</div>");
}

echo "<title>Search - $searchtitle </title>";
include("header.php");

?>

<body class="d-flex flex-column min-vh-100 mt-5 pt-5 mx-5 ">

	<?php
	echo $msg;
	?>
	<form class="d-inline-flex" action="search.php" method="POST">
		<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" value="<?php if (isset($_POST['searchterm'])) echo $_POST['searchterm']; ?>">
		<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
	</form>
	<?php
	echo "<p class='pt-2'>$result_count result(s) </p>";
	if (isset($animeresult)) {
		foreach ($animeresult as $anime) {
			echo $anime;
		};
	}
	?>

</body>



<?php
include('footer.php');
