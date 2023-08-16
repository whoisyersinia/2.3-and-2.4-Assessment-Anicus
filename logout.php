<?php
require_once('./includes/connectlocal.inc');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['login'])) {
	ob_end_clean();
	header("Location: index.php");
	exit();
} else {
	$_SESSION = array();
	session_destroy();
	ob_end_clean();
	header("Location: index.php");
}
