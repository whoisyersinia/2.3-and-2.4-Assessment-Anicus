<?php
require_once('./includes/basehead.html');
require_once("./includes/connectlocal.inc");

if (isset($_POST['regi'])) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);


	$trimmed = array_map('trim', $_POST);

	$u = $e = $p = FALSE;

	$errors = array();

	if (empty($_POST['password'] || $_POST['email'] || $_POST['username'])) {
		echo "<p class='text-warning'>Fields empty</p>";
	} else {

		//email validation
		if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
			$e = mysqli_real_escape_string($conn, $trimmed['email']);
		} else {
			echo "<p class='text-warning'>Please enter a valid email address!</p>";
		}

		//password validation
		if (preg_match('/^\w{7,}$/', $trimmed['password'])) {
			if ($_POST['password'] == $_POST['conf_password']) {
				$p = mysqli_real_escape_string($conn, $trimmed['password']);
				$p = hash('sha256', $p);
			} else {
				echo "<p class='text-warning'>Your passwords do not match!</p>";
			}
		} else {
			echo "<p class='text-warning'>Your password is less than 7 character's long!</p>";
		}

		//password username
		if (preg_match('/^\w{2,}$/', $trimmed['username'])) {
			if (preg_match('/^\w{2,30}$/', $trimmed['username'])) {
				$u = mysqli_real_escape_string($conn, $trimmed['username']);
			} else {
				echo "<p class='text-warning'>Your username exceeds the chracter limit (30)!</p>";
			}
		} else {
			echo "<p class='text-warning'>Your username is less than 2 characters long!</p>";
		}
	}

	if ($e && $p && $u) {
		$check_email_exists = "SELECT `email` FROM `user` WHERE `email`='" . $e . "'";
		$check_user_exists = "SELECT `username` FROM `user` WHERE `username`='" . $u . "'";

		$r = mysqli_query($conn, $check_email_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));
		$r_2 = mysqli_query($conn, $check_user_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r_2) == 0) {
			if (mysqli_num_rows($r) == 0) {
				date_default_timezone_set("Pacific/Auckland");
				$now = time();
				$fiveMinutes = $now + (30 * 60);
				$date_fiveMinutes = date('Y-m-d H:i:s', $fiveMinutes);

				$a = md5(uniqid(rand(), true));

				$query = "INSERT into `user` (`username`, `email`, `password`, `token`, `activation_expiry`,`email_confirmation`) VALUES ('$u', '$e', '$p', '$a', '$date_fiveMinutes', 0)";

				$result = @mysqli_query($conn, $query);

				if (mysqli_affected_rows($conn) == 1) {
					$url = 'activation.php?e=' . urlencode($e) . '&a=' . $a . '&u=' . $u;
					header("Location: $url");
					mysqli_close($conn);
				}
			}
		} else {
			echo "<p class='text-warning'>Email already taken!</p>";
		}
	} else {
		echo  "<p class='text-warning'>Username already taken!</p>";
	}
}
?>

<head>
	<title>Register - Anicus</title>
</head>
<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-auto m-auto border border-light rounded-3 px-4 py-4 ">
		<form method="POST" action="./register.php">
			<a href="./index.php">
				<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
			</a>
			<h1 class="h3 mb-3 fw-semibold text-light">Sign Up</h1>

			<div class="form-floating">
				<input name="username" type="text" class="form-control border border-3 border-tertiary" id="floatingInput" placeholder="Username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
				<label for="floatingInput">Username</label>
			</div>

			<div class="form-floating mt-4">
				<input name="email" type="email" class="form-control border border-3 border-info" id="floatingInput" placeholder="name@example.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
				<label for="floatingInput">Email address</label>
				<div id="emailHelp" class="form-text text-light">We'll never share your email with anyone else</div>
			</div>

			<div class="form-floating mt-2">
				<input name="password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Password">
				<label for="floatingPassword">Password</label>
				<div id="passwordHelp" class="form-text text-light">Your password must be at least 7 characters long</div>
			</div>

			<div class="form-floating mt-2">
				<input name="conf_password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Confirm password">
				<label for="floatingPassword">Confirm Password</label>
			</div>
			<br>
			<button class="w-100 btn btn-lg btn-primary" type="submit" name="regi">Create Account</button>
			<p class="mt-5 mb-3 text-muted text-center text-light">&copy; 2023</p>
		</form>
	</main>
</div>