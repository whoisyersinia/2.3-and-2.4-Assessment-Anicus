<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Cache-Control: no cache');
session_cache_limiter('private_no_expire');

if (isset($_POST['search'])) {
	$searchtitle = $_POST['searchterm'];

	if (isset($_POST['genre'])) {
		$genre = implode(', ', $_POST['genre']);
		$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$searchtitle%') AND (`genre` LIKE '%$genre%')";
	} else {
		$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$searchtitle%') ";
	}

	$r = mysqli_query($conn, $q);
}
if (mysqli_num_rows($r) == 0) {
	$msg = "<h1 class='px-5'>Sorry, no results found!</h1>";
}

// count how many results are there
$result_count = 0;
$animeresult = array();

while ($row = mysqli_fetch_array($r)) {
	$msg = "<h1 class='fs-1 px-5'>Here's what we found for $searchtitle. </h1>";
	$result_count += 1;

	if (!empty($row['date_aired'])) {
		$da = $row['date_aired'];
		$date = new DateTime($da);
		$da = $date->format('jS \o\f F Y');
	} else {
		$da = "Unknown";
	}
	if (!empty($row['synopsis'])) {
		$sy = $row['synopsis'];
	} else {
		$sy = "No synopsis found.";
	}

	$id = $row['idanime'];


	//links for redirect
	$url = "infoanime.php?id=$id";
	$windowloc = "window.location.href=";
	$onclick = $windowloc . "\"$url\"";


	//push the card to an array
	array_push(
		$animeresult,
		"<div class='col d-flex justify-content-start align-self-start'>
							<div class='card' style='width: 18rem;'>
								<img src='./images/bg-4.png' class='card-img-top' alt='card-img'>
								<div class='card-body mx-1'>
									<h5 class='card-title text-break fw-bold text-clamp' style='font-size: clamp(1rem, 1.3vw, 1.5rem);'>$row[title]</h5>
									<h6 class='card-subtitle mb-2 text-wrap text-tertiary text-clamp'>$row[genre]</h6>
									<h6 class='card-title text-break;'>Episodes: $row[episodes]</h6>
									<h6 class='card-subtitle mb-2 text-wrap text-clamp'>Date aired: $da</h6>
									<h6 class='card-subtitle text-wrap text-clamp'>$sy</h6>
									<div class='pt-2 pb-2'>
										<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
									</div>
								</div>
							</div>
							</div>
						"
	);
}

echo "<title>Search - $searchtitle </title>";
include("header.php");

?>

<body class="flex-column min-vh-100 mt-5 pt-5 ">

	<?php
	echo $msg;
	?>
	<form action="search.php" method="POST">
		<div class="d-inline-flex gap-2 container-fluid">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="text">All</span>
			</button>

			<ul class="dropdown-menu" value="all">
				<li><a class="dropdown-item" href="#" onclick="dropdown(this.innerHTML);">All</a></li>
				<li><a class="dropdown-item" href="#" onclick="dropdown(this.innerHTML);">Uploaded anime</a></li>
				<li><a class="dropdown-item" href="#" onclick="dropdown(this.innerHTML);">Anime in your list</a></li>
			</ul>

			<input class="d-none" id="gedit" value="<?php echo $genre; ?>">
			<select name="genre[]" id="floatingInput" class="form-control border border-3 border-info chosen-select" multiple data-placeholder="Filter genres" style="width: 80rem;">

				<option value="Action">Action</option>
				<option value="Adventure">Adventure</option>
				<option value="Comedy">Comedy</option>
				<option value="Drama">Drama</option>
				<option value="Slice of Life">Slice of Life</option>
				<option value="Fantasy">Fantasy</option>
				<option value="Magic">Magic</option>
				<option value="Supernatural">Supernatural</option>
				<option value="Horror">Horror</option>
				<option value="Mystery">Mystery</option>
				<option value="Psychological">Psychological</option>
				<option value="Romance">Romance</option>
				<option value="Sci-Fi">Sci-Fi</option>
			</select>


			<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" value="<?php if (isset($_POST['searchterm'])) echo $_POST['searchterm']; ?>">
			<button class="btn btn-outline-primary " type="submit" name="search">Search</button>
		</div>
		<div class="d-inline-flex gap-2 mx-3">
		</div>

	</form>

	<?php
	echo "<p class='pt-2 px-5'>$result_count result(s) </p>";

	?>
	<hr>
	<div class='container-fluid pt-3 mb-5 px-5'>
		<div class='row row-cols-sm-1 row-cols-lg-4 row-cols-md-2 d-flex g-5 align-items-sm-start justify-content-sm-start p-0'>
			<?php
			if (isset($animeresult)) {
				foreach ($animeresult as $anime) {
					echo $anime;
				};
			}
			?>
		</div>
	</div>

</body>



<?php
include('footer.php');
