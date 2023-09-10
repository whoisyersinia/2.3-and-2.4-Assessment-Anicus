<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
include('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (isset($_GET['id'])) {
	$id = $_GET['id'];

	//check if list exists if not 404 error
	$q = "SELECT * FROM `user` WHERE (`iduser` = '$id')";
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


	// get anime in list
	$res = False;
	$animeresult = array();
	$count = 0;

	$q = "SELECT * FROM `anime_list` LEFT JOIN `anime` ON anime.idanime = anime_list.anime_idanime LEFT JOIN `reviews` ON anime.idanime = reviews.anime_idanime LEFT JOIN `user` ON anime_list.user_iduser = user.iduser WHERE anime_list.user_iduser = $id;";
	$r = mysqli_query($conn, $q);

	if (mysqli_num_rows($r) == 0) {
		$msg = "<h3 class='px-5 fs-3 text-primary'>Sorry, no anime on this list.</h3>";
	}
	while ($row = mysqli_fetch_array($r)) {
		$res = True;
		$animeid = $row['idanime'];
		$title = $row['title'];
		$genre = $row['genre'];
		$userid = $row['iduser'];

		$rating = $row['rating'];
		$username = $row['username'];

		if (is_null($rating)) {
			$rating = '?';
		}

		$count += 1;

		array_push(
			$animeresult,
			"<tr>
					<th>$count</th>
					<th><img src='./images/bg-4.png' alt='img'  width='100px'></th>
					<th><a class='a-link text-primary pe-2' href='infoanime.php?id=$animeid'>$title</a>
					</th> 
					<th>$rating</th>
					<th>$genre</th>
	
	
					</tr>"

		);
	}
}



echo "<title>Viewing $username's List</title>"
?>


<body class="mt-5 pt-5 min-vh-100 bg-dark container-fluid">

	<div class='px-4 d-flex flex-column justify-content-center align-content-center'>

		<div class="row mx-auto pb-2">
			<img src="./images/cat_transparent.svg" alt="logo" width="200px" height="200px">
		</div>

		<div class="row-md-6">
			<h1 class="text-center fs-1 fw-bold text-black pt-4"><?php echo $username ?>'s List</h1>

		</div>


		<div class="row text-center">
			<?php if (isset($msg)) echo $msg; ?>
		</div>
		<?php
		if ($res === True) {
			echo "<table class='table table-hover table-responsive table-dark border-secondary table-bordered'>
			<thead>
				<tr>
					<th class='' scope='col'>#</th>
					<th  class='w-10'scope='col'>Image</th>
					<th class='w-75' scope='col'>Title</th>
					<th scope='col'>Rating</th>
					<th  class='w-25' scope='col'>Genre</th>
	
				</tr>
			</thead>
			<tbody class='table-group-divider'>
				
			";
			if (isset($animeresult)) {
				foreach ($animeresult as $anime) {
					echo $anime;
				};
			}
			echo "
			</tbody>
		</table>";
		}
		?>


	</div>

</body>
<?php

include('footer.php');
