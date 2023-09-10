<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

include('header.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {
	if (isset($_GET['id']) && (isset($_GET['userid']))) {

		$id = $_GET['id'];
		$userid = $_GET['userid'];
		$current_userid = $_SESSION['iduser'];



		//check if list exists if not 404 error
		$q = "SELECT * FROM `anime` WHERE (`idanime` = '$id')";
		$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
		while ($row = mysqli_fetch_assoc($r)) {
			$t = $row['title'];
		}



		if ($_GET['id'] == " ") {
			ob_end_clean();
			header("Location: index.php");
			exit();
		}

		if (mysqli_num_rows($r) == 0) {
			http_response_code(404);
			header("Location: /anicus/errordocs/404.html");
			die();
		}


		if ($userid !== $current_userid) {
			http_response_code(403);
			header("Location: /anicus/errordocs/403.html");
			die();
		}

		$q = "SELECT * FROM `reviews` WHERE (`anime_idanime` = $id) AND (`user_iduser` = $userid)";
		$result = mysqli_query($conn, $q);

		if (mysqli_num_rows($result) !== 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$rating = $row['rating'];
				$review = $row['review'];
			}
		} else {
			$review = "";
		}

		$errors = array();
		if (isset($_POST['submit'])) {
			ini_set('display_errors', '1');
			ini_set('display_startup_errors', '1');
			error_reporting(E_ALL);


			$r = $re = FALSE;

			if (empty($_POST['rating'])) {
				array_push($errors, "Required field cannot be empty!");
				// if there are no changes
			} else {


				$re = preg_replace('/\s+/', ' ', $_POST['review']);
				$re3 = '/^[\w~`!@#$%^&*()_+={[}|:;"\'<,>.?\' ]{0,255}$/';
				if (!empty($re)) {
					if (preg_match($re3, $re)) {
						$re = mysqli_real_escape_string($conn, $re);
					} else {
						array_push($errors, "Your review is more than 255 characters!");
					}
				} else {
					$re = NULL;
				}

				$r = mysqli_real_escape_string($conn, $_POST['rating']);
			}

			if ($r && ($re !== False)) {
				$check_review_exists = "SELECT * FROM `reviews` WHERE (`anime_idanime` = $id) AND (`user_iduser` = $userid)";
				$result = mysqli_query($conn, $check_review_exists);
				if (mysqli_num_rows($result) == 0) {
					$query = "INSERT into `reviews` (`rating`, `review`, `anime_idanime`, `user_iduser`) VALUES ('$r', '$re', '$id', '$userid')";
					$result_1 = mysqli_query($conn, $query);
					header("Location: animelist.php?id=$userid&s=addre");
					mysqli_close($conn);
				}
				$q = "UPDATE `reviews` SET `rating` ='$r', `review` = '$re' WHERE (`anime_idanime` = $id) AND (`user_iduser` = $userid)";
				$result_2 = mysqli_query($conn, $q);
				header("Location: animelist.php?id=$userid&s=updatere");
				mysqli_close($conn);
			}
		}
	} else {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}
}
if ($errors) {
	echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
	<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
</svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
	</div>";
};


echo "<title>Rating</title>"
?>


<body class=" bg-dark container-fluid">
	<div class=" bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
		<main class="text-center w-75 m-auto border border-light rounded-3 px-5 py-4 ">

			<form method="POST" action="rating.php?id=<?php echo $id; ?>&userid=<?php echo $userid; ?>" autocomplete="off">
				<a href="index.php">
					<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
				</a>
				<h1 class="h3 fw-semibold text-light">Reviewing <span class="text-primary"><?php echo $t; ?></span></h1>
				<p>Fields with <span class="text-warning fw-bold">*</span> are required fields</p>


				<div class="d-inline-flex gap-5 justify-content-center align-content-center">
					<div class="col-md-3">
						<div class="form-floating">
							<input name="rating" type="number" class="form-control border border-3 border-info" id="floatingInput" value="<?php if (!isset($_POST['rating'])) {
																																																															echo $rating;
																																																														} else {
																																																															echo $_POST['rating'];
																																																														}; ?>" min="1" max="10">
							<label for="floatingInput">Rating<span class="text-warning fw-bold">*</span></label>
							<div id="ratingHelp" class="form-text text-primary">1-10 <br>(1 - Horrible to 10 - Masterpiece)</div>

						</div>
					</div>


					<div class="col-md-12">
						<div class="form-floating">
							<textarea name="review" type="text" class="form-control border border-3 border-info" id="floatingSynopsis" cols="30" rows="5"><?php if (!isset($_POST['review'])) {
																																																																							echo $review;
																																																																						} else {
																																																																							echo $_POST['review'];
																																																																						}; ?></textarea>
							<label for="floatingSynopsis">Review</label>
							<div id="synopsisHelp" class="form-text text-light">Minimise <span class="fw-bold text-warning">spoilers!</span> (Max: 255 characters)</div>
						</div>
					</div>
				</div>

				<div class="mt-3 d-flex justify-content-center align-content-center gap-3">
					<button class="btn btn-lg btn-tertiary text-white border-primary" type="button" onclick="window.location.href='animelist.php?id=<?php $userid ?>'">Cancel</button>

					<button class="btn btn-lg btn-primary" type="submit" name="submit">Save Changes</button>
				</div>
				<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Anicus 2023</p>

			</form>
		</main>
	</div>


</body>
<?php

include('footer.php');
