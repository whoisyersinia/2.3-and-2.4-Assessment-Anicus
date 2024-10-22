<?php
require_once('./includes/basehead.html');
require_once('./includes/connectlocal.inc');

if (isset($_POST['regi'])) {
	$trimmed = array_map('trim', $_POST);

	$u = $e = $p = FALSE;

	$errors = array();

	if (empty($_POST['password'] || $_POST['email'] || $_POST['username'])) {
		array_push($errors, "Fields empty!");
	} else {

		//email validation
		if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
			$e = mysqli_real_escape_string($conn, $trimmed['email']);
		} else {
			array_push($errors, "Please enter a valid email address!");
		}

		//password validation
		$re = '/^[\w~`!@#$%^&*()_+={[}|:;"\'<,>.?\']{7,}$/';

		if (preg_match($re, $trimmed['password'])) {
			if ($_POST['password'] == $_POST['conf_password']) {
				$p = mysqli_real_escape_string($conn, $trimmed['password']);
				$p = hash('sha256', $p);
			} else {
				array_push($errors, "Your passwords do not match!");
			}
		} else {
			array_push($errors, "Your password is less than 7 character's long!");
		}

		// username validation
		if (preg_match('/^\w{2,}$/', $trimmed['username'])) {
			if (preg_match('/^\w{2,16}$/', $trimmed['username'])) {
				$u = mysqli_real_escape_string($conn, $trimmed['username']);
			} else {
				array_push($errors, "Your username exceeds the chracter limit (16) or special character added!");
			}
		} else {
			array_push($errors, "Your username is less than 2 characters long or special character added!");
		}
	}
}
// if ok
if ($e && $p && $u) {

	//check if user/email already exists
	$check_email_exists = "SELECT `email` FROM `user` WHERE `email`='" . $e . "'";
	$check_user_exists = "SELECT `username` FROM `user` WHERE `username`='" . $u . "'";

	$r = mysqli_query($conn, $check_email_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));
	$r_2 = mysqli_query($conn, $check_user_exists) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r_2) == 0) {
		if (mysqli_num_rows($r) == 0) {

			// set expiry 30 minutes after date now
			date_default_timezone_set("Pacific/Auckland");
			$now = time();
			$thirtyMinutes = $now + (30 * 60);
			$date_thirtyminutes = date('Y-m-d H:i:s', $thirtyMinutes);

			$a = md5(uniqid(rand(), true));

			//create user

			$query = "INSERT into `user` (`username`, `email`, `password`, `token`, `activation_expiry`,`email_confirmation`) VALUES ('$u', '$e', '$p', '$a', '$date_thirtyminutes', 0)";

			$result = mysqli_query($conn, $query);

			// create activation link which sends email
			if (mysqli_affected_rows($conn) == 1) {
				$url = 'activation.php?e=' . urlencode($e) . '&a=' . $a . '&u=' . $u;
				header("Location: $url");
				mysqli_close($conn);
			}
		} else {
			array_push($errors, "Email already taken!");
		}
	} else {
		array_push($errors, "Username already taken!");
	}
}
?>

<head>
	<title>Register - Anicus</title>
</head>
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
<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-auto m-auto border border-light rounded-3 px-4 py-4 ">
		<form method="POST" action="./register.php">
			<a href="./index.php">
				<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
			</a>
			<h1 class="h3 mb-3 fw-semibold text-light">Sign Up</h1>

			<div class="form-floating">
				<input name="username" type="text" class="form-control border border-3 border-tertiary" placeholder="Username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
				<label for="floatingInput">Username</label>
				<div id="usernameHelp" class="form-text text-light">You cannot include special characters (e.g $ or :)</div>

			</div>

			<div class="form-floating mt-4">
				<input name="email" type="email" class="form-control border border-3 border-info" placeholder="name@example.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
				<label for="floatingInput">Email address</label>
				<div id="emailHelp" class="form-text text-light">We'll never share your email with anyone else</div>
			</div>

			<div class="form-floating mt-2">
				<input name="password" type="password" class="form-control border border-3 border-info" placeholder="Password">
				<label for="floatingPassword">Password</label>
				<div id="passwordHelp" class="form-text text-light">Your password must be at least 7 characters long</div>
			</div>

			<div class="form-floating mt-2">
				<input name="conf_password" type="password" class="form-control border border-3 border-info" placeholder="Confirm password">
				<label for="floatingPassword">Confirm Password</label>
			</div>
			<br>
			<button class="w-100 btn btn-lg btn-primary" type="submit" name="regi">Create Account</button>
			<p class="mt-5 mb-3 text-muted text-center text-light">&copy; Anicus 2023</p>
		</form>
	</main>
</div>

<?php
include('footer.php');
