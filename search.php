<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
include("header.php");


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$query = $_GET['searchterm'];

// to calculate how many records there are for pagination 

if (isset($_GET['filter'])) {
	$filter = $_GET['filter'];

	$iduser = $_SESSION['iduser'];
	if ($filter === "upload") {
		$iduser = $_SESSION['iduser'];
		$q = "SELECT COUNT(*) As total_records  FROM `anime` WHERE (`title` LIKE '%$query%') AND (`iduser` = $iduser) ";
		if (isset($_GET['genre'])) {
			$genre = implode(', ', $_GET['genre']);
			$q = "SELECT COUNT(*) As total_records  FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%') AND (`iduser` = $iduser )";
		}
	} else {
		if (isset($_GET['genre'])) {
			$genre = implode(', ', $_GET['genre']);
			$q = "SELECT COUNT(*) As total_records FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%') ";
		} else {
			$q = "SELECT COUNT(*) As total_records  FROM `anime` WHERE (`title` LIKE '%$query%') ";
		}
	}
} else {
	if (isset($_GET['genre'])) {
		$genre = implode(', ', $_GET['genre']);
		$q = "SELECT COUNT(*) As total_records  FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%')";
	} else {
		$q = "SELECT COUNT(*) As total_records  FROM `anime` WHERE (`title` LIKE '%$query%')";
	}
}


// pagination only allowing 20 results per page
$total_result_per_page = 12;
$offset = ($page_no - 1) * $total_result_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($conn, $q);
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_result_per_page);
$second_last = $total_no_of_pages - 1;

// pagination query with limit selector in sql query
if (isset($_GET['filter'])) {
	$filter = $_GET['filter'];
	$iduser = $_SESSION['iduser'];
	if ($filter === "upload") {
		$iduser = $_SESSION['iduser'];
		$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') AND (`iduser` = $iduser) LIMIT $offset, $total_result_per_page ";
		if (isset($_GET['genre'])) {
			$genre = implode(', ', $_GET['genre']);
			$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%') AND (`iduser` = $iduser) LIMIT $offset, $total_result_per_page";
		}
	} else {
		if (isset($_GET['genre'])) {
			$genre = implode(', ', $_GET['genre']);
			$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%')  LIMIT $offset, $total_result_per_page";
		} else {
			$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') LIMIT $offset, $total_result_per_page";
		}
	}
} else {
	if (isset($_GET['genre'])) {
		$genre = implode(', ', $_GET['genre']);
		$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') AND (`genre` LIKE '%$genre%') LIMIT $offset, $total_result_per_page ";
	} else {
		$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$query%') LIMIT $offset, $total_result_per_page";
	}
}


$r = mysqli_query($conn, $q);

if (mysqli_num_rows($r) == 0) {
	$msg = "<h1 class='px-5'>Sorry, no results found!</h1>";
}
// count how many results are there
$result_count = 0;
$animeresult = array();
if (isset($_SESSION['login'])) {
	$userid = $_SESSION['iduser'];
}

while ($row = mysqli_fetch_array($r)) {
	$msg = "<h1 class='fs-1 px-5'>Here's what we found for $query. </h1>";
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
	$iduser = $row['iduser'];



	//links for redirect
	$url = "infoanime.php?id=$id";
	$windowloc = "window.location.href=";
	$onclick = $windowloc . "\"$url\"";


	//push the card to an array 
	if (isset($_SESSION['login'])) {
		if ($iduser === $userid) {
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
											<div class='pt-2 pb-2 gap-3 d-flex justify-content-start align-content-start'>
												<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'><i class='fa-solid fa-pencil pe-2'></i>Edit / Read More</button>
											</div>
										</div>
									</div>
									</div>
								"
			);
		} else {
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
											<div class='pt-2 pb-2 gap-3 d-flex justify-content-start align-content-start'>
												<button type='button' class='btn btn-success btn-sm border-black text-white'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>
												<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
											</div>
										</div>
									</div>
									</div>
								"
			);
		}
	} else {
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
										<div class='pt-2 pb-2 gap-3 d-flex justify-content-start align-content-start'>
											<button type='button' class='btn btn-success btn-sm border-black text-white'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>
											<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
										</div>
									</div>
								</div>
								</div>
							"
		);
	}
}

echo "<title>Search Results</title>";

// to include get attributes/variables into pagination

$params = $_GET;
array_pop($params);
$url = basename($_SERVER['PHP_SELF']) . '?' . http_build_query($params);



?>

<body class="flex-column min-vh-100 mt-5 pt-5 ">

	<?php
	echo $msg;
	?>
	<form action="search.php" method="GET">
		<div class=" d-inline-flex gap-2 container-fluid">
			<i class="fa-solid text-tertiary fa-filter justify-content-center align-self-center fa-xl"></i>
			<?php if (isset($_SESSION['login'])) {
				echo "<select name='filter' class='form-select' style='width: 15rem;' id='filter'>
				<option value='all' selected>All</option>
				<option value='upload'>Uploaded anime</option>
				<option value='list'>Anime in your list</option>
			</select>";
			} else {
				"<select name='filter' class='form-select' style='width: 15rem;' id='filter'>
					<option value='all' selected>All</option>
				</select>";
			}
			?>



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


			<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" value="<?php if (isset($_GET['searchterm'])) echo $_GET['searchterm']; ?>">
			<button class="btn btn-outline-primary " type="submit" name="search">Search</button>
		</div>
		<div class="d-inline-flex gap-2 mx-3">
		</div>

	</form>

	<?php
	echo "<p class='pt-0 mt-0 px-5'>$total_records result(s) found, showing $result_count results</p>";
	echo "<p class='px-5 fw-bold'>Page $page_no of $total_no_of_pages</p>";

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

	<!-- PAGINATION NAV LINKS-->
	<!-- Dynamic depending on which page you're on if your page 2 then the number saying 2 would be coloured and the user cannot use the link-->

	<nav aria-label="Page navigation example">
		<ul class="pagination justify-content-center">
			<li <?php if ($page_no <= 1) {
						echo "class='page-item disabled'";
					} else echo  "class='page-item'" ?>>
				<a <?php if ($page_no > 1) {
							echo "href='$url&page_no=$previous_page'";
						} ?> class="page-link">Previous</a>
			</li>
			<?php
			if ($total_no_of_pages <= 10) {
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
					if ($counter == $page_no) {
						echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
					} else {
						echo " <li class='page-item '><a class='page-link'href='$url&page_no=$counter'>$counter</a></li>";
					}
				}
			} ?>

			<li <?php if ($page_no >= $total_no_of_pages) {
						echo "class='page-item disabled'";
					} else echo  "class='page-item'" ?>>
				<a <?php if ($page_no < $total_no_of_pages) {
							echo "href='$url&page_no=$next_page'";
						} ?> class="page-link">Next</a>
			</li>
		</ul>
	</nav>

</body>



<?php
include('footer.php');
