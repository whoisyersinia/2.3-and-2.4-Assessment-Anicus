<?php
require_once('connectlocal.inc');
function redirect_user($page = 'index.php')
{
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	$url = rtrim($url, '/\\');

	$url .= '/' . $page;

	header("Location : $url");
	exit();
}

function check_login($conn, $email = '', $pass = '')
{
	$errors = array();
	if (strlen($pass) < 7) {
		$errors[] = "Password is less than 7 characters";
	} else {
		$p = mysqli_real_escape_string($conn, trim($pass));
	}
}
