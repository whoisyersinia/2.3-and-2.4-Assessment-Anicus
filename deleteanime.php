<?php
require_once('./includes/basehead.html');
require_once("./includes/connectlocal.inc");
require_once('header.php');

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
		$t = $row['title'];
	}


	if (isset($_POST['confirm'])) {
		$t1 = $_POST['delete'];
		if (empty($t1)) {
			array_push($errors, "Field empty!");
		}

		if ($_POST['delete'] === $t) {
			$q = "DELETE FROM `anime` WHERE (`idanime` = '$id')";
			$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

			if (mysqli_affected_rows($conn) == 1) {
				$url = 'anime.php?s=delete';
				header("Location: $url");
				mysqli_close($conn);
			}
		} else {
			array_push($errors, "Incorrect title given!");
		}
	};
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}

//link to go back
$durl = "infoanime.php?id=$id";
?>

<title>Delete - <?php echo $t; ?></title>

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
	<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center mt-5 pt-5">
		<!-- Form action = deleteanime.php plus anime id-->
		<form action="deleteanime.php?id=<?php echo $id; ?>" method="POST">
			<main class="text-center w-auto m-auto">
				<a href="index.php">
					<img src="./images/cat_transparent.svg" alt="logo" class="" width="200px" height="200px">
				</a>
				<div class="form-floating">
					<input name="delete" type="text" class="form-control border border-3 border-warning" id="floatingInput">
					<label for="floatingInput">Delete</label>
					<div id="deleteHelp" class="form-text fs-6 text-primary">To confirm please retype: <span class=" fw-bold"> <?php echo "'" . $t . "'"; ?></span>.</div>
					<div id="deleteHelp" class="form-text fs-6 text-primary">Once deleted, data cannot be retrieved.</div>
				</div>
				<div class="mt-4 d-inline-flex gap-3">

					<button class="btn btn-lg btn-tertiary text-white border-primary w-100" type="button" onclick='window.location.href=<?php echo "\"$durl\"" ?>'>Cancel</button>

					<button class="btn btn-lg btn-primary w-100" type="submit" name="confirm">Confirm</button>
				</div>
			</main>
		</form>
	</div>

</body>

</html>
<?php
include('footer.php');
