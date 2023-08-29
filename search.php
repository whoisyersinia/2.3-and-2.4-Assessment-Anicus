<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['search'])) {
	$searchtitle = $_GET['searchterm'];
	$q = "SELECT * FROM `anime` WHERE (`title` LIKE '%$searchtitle%')";
	$r = mysqli_query($conn, $q);

	while ($row = mysqli_fetch_assoc($r)) {
		echo "<h1>$row[title]</h1>";
	}
}
