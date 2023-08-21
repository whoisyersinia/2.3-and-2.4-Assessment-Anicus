<?php
require_once('./includes/basehead.html');
require_once('header.php');

if (isset($_GET['a']) && (strlen($_GET['a']) == 32)) {

	$a = $_GET['a'];
	$q = "SELECT * FROM `user` WHERE (`token` = '$a')";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	while ($row = mysqli_fetch_assoc($r)) {
		$exp_date = $row['activation_expiry'];
		$u = $row['username'];
		$e = $row['email'];
		$t = $row['token'];
	}

	$na = md5(uniqid(rand(), true));
	$url = 'activation.php?e=' . urlencode($e) . '&a=' . $na . '&u=' . $u;

	if (mysqli_affected_rows($conn) == 0) {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
?>

<title>Success</title>

<body>
	<div class="container-fluid bg-dark vh-100 w-100 d-flex justify-content-center align-content-center">
		<main class="text-center w-auto m-auto">
			<a href="index.php">
				<img src="./images/cat_transparent.svg" alt="logo" class="p-4" width="200px" height="200px">
			</a>
			<h2 class='text-primary fw-bold'>Activation email has been sent.</h2>
			<p class='text-primary'>Not in your inbox? <strong>Check your spam</strong> or resend by <a class="a-link text-primary" href="<?php if (isset($url)) echo $url; ?>">cliking this link.</a></p>
		</main>
	</div>

</body>

</html>
<?php
include('footer.php');
