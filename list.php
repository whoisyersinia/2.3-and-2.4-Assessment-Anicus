<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();


if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {
	if (isset($_GET['id'])) {

		$userid = $_SESSION['iduser'];

		$q = "SELECT `idanime_userlist` FROM `anime_userlist` WHERE(`iduser` = '$userid')";
		$r = mysqli_query($conn, $q);
		while ($row = mysqli_fetch_assoc($r)) {
			$listid = $row['idanime_userlist'];
		}


		//if anime exists
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
			header("Location: /anicus/errordocs/404.html");
			die();
		}


		if (!empty($_GET['a'] === 'delete')) {
			$q = "DELETE FROM `anime_list` WHERE (`anime_idanime` = '$id') AND (`idanime_userlist` = '$listid')";
			$r = mysqli_query($conn, $q);
			$url = "animelist.php?id=" . $userid . "&s=delete";
			header("Location: $url");
			mysqli_close($conn);
		}


		//if anime already in list

		$q = "SELECT * FROM `anime_list` WHERE (`anime_idanime` = '$id') AND (`idanime_userlist` = '$listid')";
		$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

		if (mysqli_num_rows($r) == 1) {
			$url = "animelist.php?id=" . $userid . "&s=warning";
			header("Location: $url");
			mysqli_close($conn);
		} else {
			// if ok - insert query

			$q = "INSERT into `anime_list` (`anime_idanime`, `idanime_userlist`) VALUES ('$id', '$listid')";
			$r = mysqli_query($conn, $q);


			$url = "animelist.php?id=" . $userid . "&s=add";
			header("Location: $url");
			mysqli_close($conn);
		}
	} else {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}
}





echo "<title>Adding anime to list</title>";
