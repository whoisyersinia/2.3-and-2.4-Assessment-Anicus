<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

?>
<title>Lists</title>

<body class="mt-5 pt-5 min-vh-100">
	<div class='container-fluid pt-3 mb-5 px-5'>
		<h1 class='fs-1 pt-2'>View lists.</h1>
		<hr>
		<div class='row row-cols-sm-1 row-cols-lg-4 row-cols-md-2 d-flex g-5 align-items-sm-start justify-content-sm-start p-0'>
			<div class='col d-flex justify-content-start align-self-start'>
				<div class='card' style='width: 18rem;'>
					<img src='./images/bg-4.png' class='card-img-top' alt='card-img'>
					<div class='card-body mx-1'>
						<h5 class='card-title text-break fw-bold text-clamp' style='font-size: clamp(1rem, 1.3vw, 1.5rem);'>Anime for Beginners</h5>
						<h6 class='card-subtitle mb-2 text-wrap text-tertiary text-wrap'>Find the anime you will fall in love with.</h6>
						<div class='pt-2 pb-2 d-flex gap-2 justify-content-start align-content-start'>
							<button type='button' class="btn btn-info btn-sm border-black" onclick="window.location.href='viewlist.php?id=80'"><i class="fa-solid fa-eye pe-1"></i>View list</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</body>


<?php

include('footer.php');
