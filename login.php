<?php
require_once('./includes/connectlocal.inc');
require_once('./includes/basehead.html');
session_start();

if (isset($_POST['login'])) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);

	//email validation - if empty
	if (!empty($_POST['email_user'])) {
		$e = mysqli_real_escape_string($conn, $_POST['email_user']);
	} else {
		$e = False;
		echo "<p class='text-warning'>User field empty!</p>";
	}

	// password  validation
	if (!empty($_POST['password'])) {
		$p = hash('sha256', mysqli_real_escape_string($conn, $_POST['password']));
	} else {
		$p = False;
		echo "<p class='text-warning'>Password field empty!</p>";
	}

	// if everything is okay run queries

	if ($e && $p) {
		// check if user exists with correct email and password and account is not activated
		$q = "SELECT * FROM `user` WHERE (`email` = '$e' OR `username` = '$e' AND `password` = '$p' AND `email_confirmation` = 0)";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 1) {
			echo "<p class='text-warning'>Your account hasn't been activated yet!</p>";
		}

		// check if user exists with correct email and password and account is activated

		$q = "SELECT * FROM `user` WHERE (`email` = '$e' OR `username` = '$e' AND `password` = '$p' AND `email_confirmation` = 1)";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 1) {
			$_SESSION['login'] = mysqli_fetch_array($r, MYSQLI_ASSOC);
			mysqli_free_result($r);
			mysqli_close($conn);

			ob_end_clean();
			header("Location: index.php");
			exit();
		} else {
			echo "<p class='text-warning'>Incorrect email address or password!</p>";
		}

		// check if user exists

		$q = "SELECT * FROM `user` WHERE (`email` = '$e ' OR `username` = '$e')";
		$r = mysqli_query($conn, $q) or  trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));
		if (mysqli_num_rows($r) == 1) {
			echo "<p class='text-warning'>You haven't made an account, please register by <a class='a-link text-primary' href='register.php'>clicking this link</a></p>";
		}
	} else {
		echo "<p class='text-warning'>I probably did something bad. Something went wrong. Please contact the site adminstrator!</p>";
	}
	mysqli_close($conn);
}
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
				<input name="email_user" type="text" class="pe-3 form-control border border-3 border-info" id="floatingInput" placeholder="name@example.com" value="">
				<label for="floatingInput">Email or Username</label>
			</div>

			<div class="form-floating mt-3">
				<input name="password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Password">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="checkbox mb-3">
				<label class="text-light py-2">
					<input name="remember_me" type="checkbox" value="remember-me"> Remember me
				</label>
			</div>

			<div class="checkbox mb-3">
				<p class="text-white">Don't have an account?<a href="register.php" class="text-primary text-decoration-none"> Sign up now.</a></p>
			</div>

			<button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; Anicus 2023</p>
		</form>
	</main>
</div>