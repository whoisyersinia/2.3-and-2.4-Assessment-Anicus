<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

session_start();

// check if user has logged in - if not 403 foribbden error
if (!isset($_SESSION['login'])) {
	http_response_code(403);
	header("Location: /anicus/errordocs/403.html");
	die();
}
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$current_userid = $_SESSION['iduser'];

	if ($current_userid !== $id) {
		http_response_code(403);
		header("Location: /anicus/errordocs/403.html");
		die();
	}

	//check if list exists
	$q = "SELECT * FROM `anime_userlist` WHERE (`iduser` = '$id')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));


	if ($_GET['id'] == " ") {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /anicus/errordocs/404.html");
		die();
	} else {
		while ($row = mysqli_fetch_array($r)) {
			$visible = $row['display'];
			$title = $row['header'];

			if (is_null($title)) {
				$title = "$_SESSION[username]'s list";
			}

			if ($visible == 1) {
				$visible = True;
			} else {
				$visible = False;
			}
		}
	}
}
$errors = array();
$t = FALSE;

if (isset($_POST['submit'])) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);


	if (empty($_POST['title'])) {
		array_push($errors, "Required fields empty!");
	} else {

		$title = preg_replace('/\s+/', ' ', $_POST['title']);


		if (strlen($title) > 2) {
			if (strlen($title) < 30) {
				$t = mysqli_real_escape_string($conn, $title);
			} else {
				array_push($errors, "Your title exceeds the chracter limit (30)!");
			}
		} else {
			array_push($errors, "Your title is less than 2 characters long!");
		}

		if (isset($_POST['visible'])) {
			if ($_POST['visible'] == 'public') {
				$v = 1;
			} else {
				$v = 0;
			}
		} else {
			$v = 0;
		}
	}
}
if ($t) {

	$query = "UPDATE `anime_userlist` SET `header` = '$t', `display` = '$v' WHERE (`iduser` = $current_userid)";

	$result = mysqli_query($conn, $query);
	header("Location: animelist.php?id=$id");
	mysqli_close($conn);
}


//print errors
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

<title>Settings List</title>



<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-75 m-auto border border-light rounded-3 px-5 py-4 ">

		<form action="settingslist.php?id=<?php echo $id ?>" method="POST">
			<a href="index.php">
				<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
			</a>
			<h1 class="h3 fw-semibold text-light">Settings List</h1>
			<p>Fields with <span class="text-warning fw-bold">*</span> are required fields</p>
			<div class="form-floating">
				<input name="title" type="text" class="form-control border border-3 border-info" id="floatingInput" placeholder="" value="<?php if (isset($title)) echo $title; ?>">
				<label for="floatingInput">Name<span class="text-warning fw-bold">*</span></label>
				<div id="titleHelp" class="form-text text-primary">Name your list.</div>
			</div>
			<div class="checkbox mb-3 d-flex justify-content-center align-content-center">
				<label class="text-light py-2">
					<?php
					if ($visible == True) {
						echo "<input name='visible' type='checkbox' value='public' checked> Make list visible to everyone? <span class='text-warning fw-bold'>(Currently Public)</span>";
					} else {
						echo "<input name='visible' type='checkbox' value='public' > Make list visible to everyone? <span class='text-success fw-bold'>(Currently Private)</span>";
					}
					?>
				</label>
			</div>
			<div class="mt-3  gap-3">
				<button class="btn btn-lg btn-tertiary text-white border-primary" type="button" onclick="window.location.href='animelist.php?id=<?php echo $id ?>'">Cancel</button>
				<button class="btn btn-lg btn-primary mx-2" type="submit" name="submit">Save changes</button>
			</div>
		</form>
	</main>
</div>
<?php
include('footer.php');
