<?php
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');
session_start();

if (!empty($_GET['s'])) {
	echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
		<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
	</svg>";

	echo "Create an account to start listing!";

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
	header("refresh:3;url=login.php");
}

if (isset($_POST['login'])) {
	//email validation - if empty
	$errors = array();

	if (!empty($_POST['email_user'])) {
		$e = mysqli_real_escape_string($conn, $_POST['email_user']);
	} else {
		$e = False;
		array_push($errors, "User field empty!");
	}

	// password  validation
	if (!empty($_POST['password'])) {
		$p = hash('sha256', mysqli_real_escape_string($conn, $_POST['password']));
	} else {
		$p = False;
		array_push($errors, "Password field empty!");
	}

	// if everything is okay run queries

	if ($e && $p) {
		// check if user exists with correct email and password and account is not activated
		$q = "SELECT * FROM `user` WHERE (`email` = '$e' OR `username` = '$e' AND `password` = '$p' AND `email_confirmation` = 0)";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 1) {
			array_push($errors, "Your account hasn't been activated yet!");
		}

		// check if user exists with correct email and password and account is activated

		$q = "SELECT * FROM `user` WHERE (`email` = '$e' OR `username` = '$e' AND `password` = '$p' AND `email_confirmation` = 1)";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 1) {
			//split user variables to its session variable
			$_SESSION = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$_SESSION['login'] = true;

			//create list
			$userid = $_SESSION['iduser'];

			$q = "SELECT * FROM `anime_userlist` WHERE (`iduser` = '$userid')";
			$result =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

			if (mysqli_num_rows($result) == 0) {
				$q = "INSERT into `anime_userlist` (`display`, `iduser`) VALUES (0, '$userid')";
				mysqli_query($conn, $q);

				$q = "SELECT * FROM `anime_userlist` WHERE (`iduser` = '$userid')";
				$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));
				while ($row = mysqli_fetch_array($r)) {
					$listid = $row['idanime_userlist'];
				}
			} else {
				while ($row = mysqli_fetch_array($r)) {
					$listid = $row['idanime_userlist'];
				}
			}

			$_SESSION['listid'] = $listid;


			mysqli_free_result($r);
			mysqli_close($conn);

			ob_end_clean();
			header("Location: index.php");
			exit();
		} else {
			array_push($errors, "Incorrect email address or password!");
		}

		// check if user exists

		$q = "SELECT * FROM `user` WHERE (`email` = '$e ' OR `username` = '$e')";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));
		if (mysqli_num_rows($r) == 1) {
			array_push($errors, "You haven't made an account, please register.");
		}
	} else {
		array_push($errors, "I probably did something bad. Something went wrong. Please contact the site adminstrator!");
	}
	mysqli_close($conn);
}
?>
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

<title>Login - Anicus</title>
<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-auto m-auto border border-light rounded-3 px-5 py-4">
		<form method="POST" action="login.php">
			<a href="./index.php">
				<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
			</a>
			<h1 class="h3 mb-3 fw-semibold text-light">Sign in</h1>

			<div class="form-floating">
				<input name="email_user" type="text" class="pe-3 form-control border border-3 border-info" id="floatingInput" placeholder="name@example.com" value="<?php if (isset($_POST['email_user'])) echo $_POST['email_user']; ?>">
				<label for="floatingInput">Email or Username</label>
			</div>

			<div class="form-floating mt-3">
				<input name="password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Password">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="checkbox mb-3">
				<p class="text-white">Don't have an account?<a href="register.php" class="text-primary text-decoration-none"> Sign up now.</a></p>
			</div>

			<button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; Anicus 2023</p>
		</form>
	</main>
</div>
<?php
require_once('footer.php');
