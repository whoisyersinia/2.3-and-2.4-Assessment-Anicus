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
	echo '<h1>No results found</h1>';
}

while ($row = mysqli_fetch_assoc($r)) {
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

	echo "<div class='container-fluid p-5'>
					<div class='row row-cols-sm-1 row-cols-lg-4 row-cols-md-2 d-flex g-5 align-items-sm-center justify-content-sm-center p-0'>
						<div class='col d-flex justify-content-left align-self-left'>
							<div class='card p-0' style='width: 18rem;'>
								<img src='./images/bg-4.png' class='card-img-top' alt='...>
								<div class='card-body px-2'>
									<h5 class='card-title text-break fw-bold' style='font-size: clamp(1rem, 1.3vw, 1.5rem);'>$row[title]</h5>
									<h6 class='card-subtitle mb-2 text-wrap'>$row[genre]</h6>
									<h6 class='card-title text-break;'>Episodes: $row[episodes]</h6>
									<h6 class='card-subtitle mb-2 text-wrap'>$da</h6>
									<h6 class='card-subtitle text-wrap'>$sy</h6>
								</div>
							</div>
						</div>
					</div>
				</div>";
}

echo "<title>Search - $searchtitle </title>"
?>





<?php
include('footer.php');
