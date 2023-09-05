<?php
require_once('./includes/basehead.html');
require_once("./includes/connectlocal.inc");

$errors = array();

if (isset($_GET['id'])) {

	$id = $_GET['id'];
	$q = "SELECT * FROM `anime` WHERE (`idanime` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if ($_GET['id'] == " ") {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		include('404.php');
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$ti = $row['title'];
		$ge = $row['genre'];
		$epi = $row['episodes'];
		$da = $row['date_aired'];
		$sy = $row['synopsis'];
	}

	if (isset($_POST['submit'])) {
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);

		$errors = array();

		// convert array to string
		$t = $g = $ep = FALSE;

		if (isset($_POST['genre'])) {
			$genre = implode(', ', $_POST['genre']);
		}
		if (empty($_POST['title'] || $_POST['genre'] = array() || $_POST['ep'])) {
			array_push($errors, "Required fields cannot be empty!");
			// if there are no changes
		} elseif ($_POST['title'] === $ti && $genre === $ge && $_POST['ep'] === $epi && $_POST['date_aired'] == $da && $_POST['synopsis'] == $sy) {
			array_push($errors, "Please edit to continue!");
		} else {

			$title = preg_replace('/\s+/', ' ', $_POST['title']);
			$re = '/^[\w~`!@#$%^&*()_+={[}|:;"\'<,>.?\' ]{2,}$/';
			$re2 = '/^[\w~`!@#$%^&*()_+={[}|:;"\'<,>.?\' ]{2,255}$/';

			if (preg_match($re, $title)) {
				if (preg_match($re2, $title)) {
					$t = mysqli_real_escape_string($conn, $title);
				} else {
					array_push($errors, "Your title exceeds the chracter limit (255)!");
				}
			} else {
				array_push($errors, "Your title is less than 2 characters long!");
			}

			if (isset($_POST['genre'])) {
				$genre = implode(', ', $_POST['genre']);
				$g = mysqli_real_escape_string($conn, $genre);
			} else {
				array_push($errors, "Genre field empty!");
			}

			if ($_POST['ep'] <= 0) {
				array_push($errors, "Episodes must not equal or be less than 0!");
			} else {
				$ep = mysqli_real_escape_string($conn, $_POST['ep']);
			}

			date_default_timezone_set("Pacific/Auckland");
			$now = time();
			$date_now = date('Y-m-d', $now);

			if (!strtotime($_POST['date_aired']) !== false) {
				$da = NULL;
			} else {
				if ($_POST['date_aired'] > $date_now) {
					array_push($errors, "Airing date must not be in the future.");
				} else {
					$da = mysqli_real_escape_string($conn, $_POST['date_aired']);
				}
			}
			var_dump($da);

			$synopsis = preg_replace('/\s+/', ' ', $_POST['synopsis']);

			$re3 = '/^[\w~`!@#$%^&*()_+={[}|:;"\'<,>.?\' ]{0,255}$/';
			if (!empty($synopsis)) {
				if (preg_match($re3, $synopsis)) {
					$sy = mysqli_real_escape_string($conn, $synopsis);
				} else {
					array_push($errors, "Your synopsis is more than 255 characters!");
				}
			} else {
				$sy = NULL;
			}
		}
	}

	if ($t && $g && $ep) {

		$check_title_exists = "SELECT `title` FROM `anime` WHERE `idanime` != '$id' AND `title` = '" . $t . "'";
		$r = mysqli_query($conn, $check_title_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 0) {

			$query = "UPDATE `anime` SET `title` = '$t', `synopsis` = " . ($sy == NULL ? "NULL" : "'$sy'") . ", `genre` = '$g', `date_aired` = " . ($da == NULL ? "NULL" : "'$da'") . ", `episodes` = '$ep' WHERE (`idanime` = '$id')";

			$result = mysqli_query($conn, $query);

			header("Location: anime.php?s=update");
			mysqli_close($conn);
		} else {
			array_push($errors, "Anime already exists. (Same Title Found!)");
		}
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}

//link to go back
$durl = "infoanime.php?id=$id";
require_once('header.php');

?>

<title>Edit - <?php echo $t; ?></title>

<?php
if ($errors) {
	echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
		<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
	</svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};
?>

<body>
	<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
		<main class="text-center w-75 m-auto border border-light rounded-3 px-5 py-4 ">

			<form method="POST" action="editanime.php?id=<?php echo $id; ?>" autocomplete="off">
				<a href="index.php">
					<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
				</a>
				<h1 class="h3 fw-semibold text-light">Editing <span class="text-primary"><?php echo $ti; ?></span></h1>
				<p>Fields with <span class="text-warning fw-bold">*</span> are required fields</p>


				<div class="d-inline-flex gap-5 justify-content-center">
					<div class="col-md-6">
						<div class="form-floating">
							<input name="title" type="text" class="form-control border border-3 border-info" id="floatingInput" value="<?php if (!isset($_POST['title'])) {
																																																														echo $ti;
																																																													} else {
																																																														echo $_POST['title'];
																																																													}; ?>">
							<label for="floatingInput">Title<span class="text-warning fw-bold">*</span></label>
							<div id="titleHelp" class="form-text text-warning fw-bold">Please enter the English title.</div>
						</div>
					</div>
					<div class="col-md-5">
						<label for="floatingInput">Genre<span class="text-warning fw-bold">*</span></label>

						<!-- MAKE A COMMENT ON IMLICATIONS -->
						<!-- Takes previous genre and puts it in a input and using javascript splits the string and converts it to options in the select -->

						<input class="d-none" id="gedit" value="<?php echo $ge; ?>">
						<select name="genre[]" id="floatingInput" class="form-control border border-3 border-info chosen-select" multiple data-placeholder="Start typing genres (e.g Romance)">

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


						<div id="genreHelp" class="form-text text-light mx-auto">(Max: 5)</div>

					</div>
					<div class="col-md-2">
						<div class="form-floating">
							<input name="ep" type="number" class="form-control border border-3 border-info" id="floatingInput" value="<?php if (!isset($_POST['ep'])) {
																																																													echo $epi;
																																																												} else {
																																																													echo $_POST['ep'];
																																																												}; ?>" max=" 1500">
							<label for="floatingInput">Episodes<span class="text-warning fw-bold">*</span></label>
						</div>
					</div>

				</div>

				<div class="d-inline-flex gap-5 justify-content-center mt-2">
					<div class="col-md-4">
						<div class=" form-floating">
							<input name="date_aired" type="date" class="form-control border border-3 border-info" id="floatingInput" value="<?php if (!isset($_POST['date_aired'])) {
																																																																echo $da;
																																																															} else {
																																																																echo $_POST['date_aired'];
																																																															}; ?>">
							<label for="floatingInput">Date Aired</label>
						</div>
					</div>
					<div class="col-md-10">
						<div class="form-floating">
							<textarea name="synopsis" type="text" class="form-control border border-3 border-info" id="floatingSynopsis" cols="30" rows="5"><?php if (!isset($_POST['synopsis'])) {
																																																																								echo $sy;
																																																																							} else {
																																																																								echo $_POST['synopsis'];
																																																																							}; ?></textarea>
							<label for=" floatingSynopsis">Synopsis</label>
							<div id="synopsisHelp" class="form-text text-light">Include the general plot of the series, <span class="fw-bold text-warning">without any spoilers!</span> (Max: 255 characters)</div>
						</div>
					</div>
				</div>

				<div class="mt-4 d-inline-flex gap-3">
					<button class="btn btn-lg btn-tertiary text-white border-primary" type="button" onclick='window.location.href=<?php echo "\"$durl\"" ?>'>Cancel</button>

					<button class="btn btn-lg btn-primary" type="submit" name="submit">Save Changes</button>
				</div>
				<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Anicus 2023</p>

			</form>
		</main>
	</div>

</body>

</html>
<?php
include('footer.php');
