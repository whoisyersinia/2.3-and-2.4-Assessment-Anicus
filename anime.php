<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



if (!empty($_GET['s'])) {
	if ($_GET['s'] === "add") {

		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
		id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
		<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
		</svg>";

		echo "Successfully added anime!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
		header("refresh:3;url=anime.php");
	} elseif ($_GET['s'] === "delete") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
			id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
			<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
			</svg>";

		echo "Successfully deleted anime!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
			</div>";
		header("refresh:3;url=anime.php");
	} elseif ($_GET['s'] === "update") {
		echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
		echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
			id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
			<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
			</svg>";

		echo "Successfully updated anime!";

		echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
			</div>";
		header("refresh:3;url=anime.php");
	}
}


if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}


$q = "SELECT COUNT(*) As total_records FROM `anime`";

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

$q = "SELECT * FROM `anime` ORDER BY `anime`.`idanime` DESC, `anime`.`updated_on` DESC LIMIT $offset, $total_result_per_page";


$r = mysqli_query($conn, $q);

// count how many results are there
$result_count = 0;
$animeresult = array();
if (isset($_SESSION['login'])) {
	$userid = $_SESSION['iduser'];
}

while ($row = mysqli_fetch_array($r)) {
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
	$iduser = $row["iduser"];

	//links for redirect
	$url = "infoanime.php?id=$id";
	$windowloc = "window.location.href=";
	$onclick = $windowloc . "\"$url\"";
	$aurl = "list.php?id=$id";

	$aonclick = $windowloc . "\"$aurl\"";

	$durl = "list.php?id=$id&a=delete";
	$donclick = $windowloc . "\"$durl\"";


	//push the card to an array 
	if (isset($_SESSION['login'])) {
		//check if user already has this anime on their list
		$q = "SELECT * FROM `anime_list` LEFT JOIN `anime` ON anime.idanime = anime_list.anime_idanime LEFT JOIN `anime_userlist` ON anime_list.idanime_userlist = anime_userlist.idanime_userlist WHERE (anime_userlist.iduser = $userid) AND (anime.idanime = $id)";
		$result = mysqli_query($conn, $q);
		if (mysqli_num_rows($result) == 1) {
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
										<div class='pt-2 pb-2 gap-1 d-flex justify-content-start align-content-start'>
											<button type='button' class='btn btn-warning btn-sm border-black text-white' style='font-size:0.7rem' onclick='$donclick'> <i class='fa-solid fa-trash-can pe-2'></i></i>Remove from list</button>
											<button type='button' class='btn btn-info btn-sm border-black' style='font-size:0.7rem' onclick='$onclick'><i class='fa-solid fa-pencil pe-1'></i>Edit/Read More</button>
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
										<div class='pt-2 pb-2 gap-2 d-flex justify-content-start align-content-start'>
											<button type='button' class='btn btn-warning btn-sm border-black text-white' onclick='$donclick'> <i class='fa-solid fa-trash-can pe-2'></i></i>Remove from list</button>
											<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
										</div>
									</div>
								</div>
								</div>
							"
				);
			}
		} else {
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
													<div class='pt-2 pb-2 d-flex gap-2 justify-content-start align-content-start'>
														<button type='button' class='btn btn-success btn-sm border-black text-white' onclick='$aonclick'> <i class='fa-solid fa-plus'></i>Add to list</button>
														<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'><i class='fa-solid fa-pencil pe-1'></i>Edit/Read More</button>
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
														<button type='button' class='btn btn-success btn-sm border-black text-white' onclick='$aonclick'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>
														<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
													</div>
												</div>
											</div>
											</div>
										"
				);
			}
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
										<button type='button' class='btn btn-success btn-sm border-black text-white' onclick='$aonclick'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>
										<button type='button' class='btn btn-info btn-sm border-black' onclick='$onclick'>Read More</button>
									</div>
								</div>
							</div>
							</div>
						"
		);
	}
	$params = $_GET;
	array_pop($params);
	$url = basename($_SERVER['PHP_SELF']) . '?' . http_build_query($params);
}


?>
<title>Anime</title>

<body class="mt-5 pt-5 px-0 container-fluid">

	<div class="d-flex justify-content-center align-content-center mx-auto">
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
	</div>
	<div class="d-flex justify-content-center align-content-center pt-3">
		<button type='button' class='btn btn-danger border-black text-white p-2 px-3 me-3' onclick="window.location.href='addanime.php'"><i class='fa-solid fa-plus pe-2'></i>Add anime</button>
	</div>



	<hr>
	<div class='container-fluid pt-3 mb-5 px-5'>
		<h1 class='fs-1 pt-2'>View all the anime in our database.</h1>
		<?php
		echo "<p class='pt-0 mt-0'>$total_records result(s) found, showing $result_count result(s).</p>";
		echo "<p class='fw-bold'>Page $page_no of $total_no_of_pages</p>";

		?>
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

	<nav class="text-primary">
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
