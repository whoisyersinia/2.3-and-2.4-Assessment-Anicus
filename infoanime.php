<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
include('header.php');

if (isset($_GET['id'])) {

	if ($_GET['id'] == "") {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}


	//check if anime exists
	$id = $_GET['id'];

	$q = "SELECT * FROM `anime` WHERE (`idanime` = '$id')";

	$r = mysqli_query($conn, $q)  or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /anicus/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$t = $row['title'];
		$g = $row['genre'];
		$ep = $row['episodes'];

		$sy = $row['synopsis'];
		$da = $row['date_aired'];
		$img = $row['image_url'];
	}

	//check if variable is null 
	if (!is_null($da)) {

		//convert date to str - readable format
		$date = new DateTime($da);
		$da = $date->format('jS \o\f F Y');
	} else {
		//if null print unknown
		$da = "Unknown";
	}

	if (!is_null($sy)) {
		$sy = $sy;
	} else {
		$sy = "No synopsis found.";
	}

	//create redirect url
	$id = $_GET['id'];
	$userid = $_SESSION['iduser'];

	$durl = "deleteanime.php?id=$id";
	$eurl = "editanime.php?id=$id";
	$aurl = "list.php?id=$id";
	$rurl = "list.php?id=$id&a=delete";


	$donclick = "\"$durl\"";
	$eonclick = "\"$eurl\"";
	$aonclick = "\"$aurl\"";
	$ronclick = "\"$rurl\"";
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}


echo "<title>$t</title>"
?>


<body class="mt-5 pt-5 min-vh-100">

	<div class='px-4'>
		<div class=' d-flex justify-content-between'>
			<h2 class='fw-bold'><?php echo $t ?></h2>
			<h4 class=" fw-light"><?php echo $ep ?> episode(s)</h4>
		</div>
		<h4 class='text-tertiary fst-italic'><?php echo $g ?></h4>
		<h6>Aired: <?php echo $da ?> </h6>

		<div class="pt-2">

			<!--Function buttons - if anime is uploaded by user or not-->
			<?php
			if (isset($_SESSION['login'])) {
				$userid = $_SESSION['iduser'];
				$id = $_GET['id'];
				$q = "SELECT * FROM `anime` WHERE (`idanime` = '$id') AND (`iduser` = '$userid')";
				$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

				if (mysqli_num_rows($r) == 1) {
					echo "	<button type='button' class='btn btn-danger btn-sm border-black text-white p-2' onclick='window.location.href=$eonclick'><i class='fa-solid fa-pencil pe-2'></i>Edit</button>";
					echo "<button type='button' class='btn btn-warning btn-sm border-black text-white p-2 mx-2' onclick='window.location.href=$donclick'> <i class='fa-solid fa-trash-can pe-2'></i></i>Delete</button>";
				}
				$q = "SELECT `idanime_userlist` FROM `anime_userlist` WHERE(`iduser` = '$userid')";
				$r = mysqli_query($conn, $q);
				while ($row = mysqli_fetch_assoc($r)) {
					$listid = $row['idanime_userlist'];
				}
				$q = "SELECT * FROM `anime_list` WHERE (`anime_idanime` = $id) AND (`idanime_userlist` = '$listid')";
				$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
				if (mysqli_num_rows($r) !== 1) {
					echo "<button type='button' class='btn btn-success btn-sm border-black text-white p-2' onclick='window.location.href=$aonclick'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>";
				} else {
					echo "<br><button type='button' class='btn btn-warning btn-sm border-black text-white p-2 mt-3' onclick='window.location.href=$ronclick''> <i class='fa-solid fa-trash-can pe-2'></i></i>Remove from list</button>";
				}
			}

			?>

		</div>

		<h3 class="pt-4">Synopsis:</h3>
		<hr>
		<p><?php echo $sy ?></p>

		<?php 	//review query 
		if (isset($_SESSION['login'])) {

			$userid = $_SESSION['iduser'];

			$q = "SELECT * FROM `anime` LEFT JOIN `reviews` ON anime.idanime = reviews.anime_idanime WHERE (reviews.user_iduser = $userid) AND (reviews.anime_idanime = $id);";
			$r = mysqli_query($conn, $q);

			if (mysqli_num_rows($r) !== 0) {
				while ($row = mysqli_fetch_assoc($r)) {
					$rating = $row['rating'];
					$rating = "<i class='fa-solid fa-star pe-2 fs-4'></i>$rating/10";
					$review = $row['review'];

					$reurl = "rating.php?id=$id&userid=$userid";
					$reonclick = "\"$reurl\"";

					if (!is_null($review)) {
						$review = "$review <br> <button type='button' class='btn btn-info btn-sm border-black text-primary mt-4' onclick='window.location.href=$reonclick'><i class='fa-solid fa-star pe-2'></i>Edit Review</button>";
					} else {
						$review = "Your review cannot be found.";
					}
				}
			} else {
				$reurl = "rating.php?id=$id&userid=$userid";
				$reonclick = "\"$reurl\"";
				$rating = "<button type='button' class='btn btn-info btn-sm border-black text-primary' onclick='window.location.href=$reonclick'><i class='fa-solid fa-star pe-2'></i>Review Anime</button>";
				$review = "Your review cannot be found.";
			}
		} else {
			$review = "Login to review $t";
		}
		?>

		<h3 class="pt-4">Your Review:</h3>
		<hr>
		<h2 class="text-success"><?php echo $rating ?></h2>
		<p><?php echo $review ?></p>

		<?php
		$reviewresult = array();

		$userid = $_SESSION['iduser'];

		$q = "SELECT * FROM `anime` LEFT JOIN `reviews` ON anime.idanime = reviews.anime_idanime WHERE (reviews.anime_idanime = $id)";
		$result = mysqli_query($conn, $q);
		if (mysqli_num_rows($result) !== 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$userid = $row['user_iduser'];
				$rating = $row['rating'];
				$rating = "<i class='fa-solid fa-star pe-2 fs-4'></i>$rating/10";
				$reviewdes = $row['review'];

				$q = "SELECT * FROM `user` WHERE `iduser` = '$userid'";
				$r = mysqli_query($conn, $q);

				while ($row = mysqli_fetch_array($r)) {
					$username = $row['username'];
				}


				array_push(
					$reviewresult,
					"<h3 class='pt-1'>From $username</h3>
						<h2 class='text-success'>$rating</h2>
						<p>$reviewdes</p><hr>"
				);
			}
			echo $count;
		} else {
			array_push(
				$reviewresult,
				"<p class='pb-1'>No reviews can be found.</p>"
			);
		}

		?>

		<h3 class="pt-2">Reviews:</h3>
		<hr>
		<?php
		if (isset($reviewresult)) {
			foreach ($reviewresult as $review) {
				echo $review;
			};
		}
		?>
	</div>



</body>


<?php

include('footer.php');
