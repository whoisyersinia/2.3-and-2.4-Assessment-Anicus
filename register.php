<?php
require_once('basehead.php');
require_once("./connectlocal.inc");

if (isset($_POST['regi'])) {
	if ($_POST['password'] == $_POST['conf_password']) {

		$name = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$q = "INSERT into `user` (`username`, `email`, `password`) VALUES ('$name', '$email', '$password')";

		$r = @mysqli_query($conn, $q);
	} else {
		echo 'help me';
	}
}
?>

<head>
	<title>Register - Anicus</title>
</head>
<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
	<main class="text-center w-auto m-auto border border-light rounded-3 px-4 py-4 ">
		<form method="POST" action="index.php">
			<img class="p-0 mb-2" src="./images/cat_transparent.svg" width="100px" height="100px" alt="logo">
			<h1 class="h3 mb-3 fw-semibold text-light">Sign Up</h1>

			<div class="form-floating">
				<input name="username" type="text" class="form-control border border-3 border-tertiary" id="floatingInput" placeholder="Username" value="">
				<label for="floatingInput">Username</label>
			</div>

			<div class="form-floating mt-4">
				<input name="email" type="email" class="form-control border border-3 border-info" id="floatingInput" placeholder="name@example.com" value="">
				<label for="floatingInput">Email address</label>
				<div id="emailHelp" class="form-text text-light">We'll never share your email with anyone else</div>
			</div>

			<div class="form-floating mt-2">
				<input name="password" type="password" class="form-control border border-3 border-info" id="floatingPassword" placeholder="Password" value="">
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