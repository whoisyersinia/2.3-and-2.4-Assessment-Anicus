<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

if (isset($_GET['id'])) {

	if ($_GET['id'] == "") {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}


	$q = "SELECT * FROM `anime` WHERE (`idanime` = '$_GET[id]')";

	$r = mysqli_query($conn, $q)  or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

	if (mysqli_num_rows($r) == 0) {
		http_response_code(404);
		header("Location: /anicus/errordocs/404.html");
		die();
	}

	while ($row = mysqli_fetch_assoc($r)) {
		$t = $row['title'];
		$g = $row['genre'];
		$ep = $row['episodes'];

		$sy = $row['synopsis'];
		$da = $row['date_aired'];
		$img = $row['image_url'];
	}

	//check if variable is null 
	if (!is_null($da)) {

		//convert date to str - readable format
		$date = new DateTime($da);
		$da = $date->format('jS \o\f F Y');
	} else {
		//if null print unknown
		$da = "Unknown";
	}

	if (!is_null($sy)) {
		$sy = $sy;
	} else {
		$sy = "No synopsis found.";
	}

	//create delete url
	$id = $_GET['id'];
	$userid = $_SESSION['iduser'];

	$durl = "deleteanime.php?id=$id";
	$eurl = "editanime.php?id=$id";
	$aurl = "list.php?id=$id";


	$donclick = "\"$durl\"";
	$eonclick = "\"$eurl\"";
	$aonclick = "\"$aurl\"";
} else {
	ob_end_clean();
	header("Location: index.php");
	exit();
}

include('header.php');
echo "<title>$t</title>"
?>


<body class="mt-5 pt-5 min-vh-100">

	<div class='px-4'>
		<div class=' d-flex justify-content-between'>
			<h2 class='fw-bold'><?php echo $t ?></h2>
			<h4 class=" fw-light"><?php echo $ep ?> episode(s)</h4>
		</div>
		<h4 class='text-tertiary fst-italic'><?php echo $g ?></h4>
		<h6>Aired: <?php echo $da ?> </h6>

		<div class="pt-2">

			<!--Function buttons - if anime is uploaded by user or not-->
			<?php

			$userid = $_SESSION['iduser'];
			$id = $_GET['id'];
			$q = "SELECT * FROM `anime` WHERE (`idanime` = '$id') AND (`iduser` = '$userid')";
			$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

			if (mysqli_num_rows($r) == 1) {
				echo "	<button type='button' class='btn btn-danger btn-sm border-black text-white p-2' onclick='window.location.href=$eonclick'><i class='fa-solid fa-pencil pe-2'></i>Edit</button>";
				echo "<button type='button' class='btn btn-warning btn-sm border-black text-white p-2 mx-2' onclick='window.location.href=$donclick'> <i class='fa-solid fa-trash-can pe-2'></i></i>Delete</button>";
			} else {
				echo "<button type='button' class='btn btn-success btn-sm border-black text-white p-2' onclick='window.location.href=$aonclick'> <i class='fa-solid fa-plus pe-2'></i>Add to list</button>";
			}
			?>


		</div>

		<h3 class="pt-4">Synopsis:</h3>
		<hr>
		<p><?php echo $sy ?></p>

	</div>



</body>


<?php

include('footer.php');
