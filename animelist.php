<?php

require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');
include('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (!isset($_SESSION['login'])) {
	header("Location: login.php?s=req");
} else {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		if (isset($_GET['s'])) {
			if (!empty($_GET['s'] === 'add')) {
				echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
				echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
				<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
			</svg>";

				echo "Successfully added anime to list!";

				echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
				header("refresh:3;url=animelist.php?id=$id");
			}
			if (!empty($_GET['s'] === 'warning')) {
				echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
				echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
					<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
				</svg>";

				echo "Anime already in list!";

				echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
					</div>";
				header("refresh:3;url=animelist.php?id=$id");
			}
			if (!empty($_GET['s'] === 'delete')) {
				echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
				echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
				<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
			</svg>";

				echo "Successfully deleted anime from list!";

				echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
				header("refresh:3;url=animelist.php?id=$id");
			}
			if (!empty($_GET['s'] === 'updatere')) {
				echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
				echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
				<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
			</svg>";

				echo "Successfully updated review!";

				echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
				header("refresh:3;url=animelist.php?id=$id");
			}
			if (!empty($_GET['s'] === 'addre')) {
				echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
				echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
				<path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
			</svg>";

				echo "Successfully added review!";

				echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
				</div>";
				header("refresh:3;url=animelist.php?id=$id");
			}
		}



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

		$q = "SELECT * FROM `anime_list` LEFT JOIN `anime` ON anime.idanime = anime_list.anime_idanime LEFT JOIN `reviews` ON anime.idanime = reviews.anime_idanime WHERE anime_list.user_iduser = $id;";
		$r = mysqli_query($conn, $q);

		if (mysqli_num_rows($r) == 0) {
			$msg = "<h3 class='px-5 fs-3 text-primary'>Sorry, no anime on you list. Start adding by searching above.</h3>";
		}
		while ($row = mysqli_fetch_array($r)) {
			$res = True;
			$animeid = $row['idanime'];
			$title = $row['title'];
			$genre = $row['genre'];
			$userid = $row['iduser'];

			$rating = $row['rating'];
			if (is_null($rating)) {
				$rating = '?';
			}

			$count += 1;

			if ($id == $userid) {
				array_push(
					$animeresult,
					"<tr>
					<th>$count</th>
					<th><img src='./images/bg-4.png' alt='img'  width='100px'></th>
					<th><a class='a-link text-primary pe-2' href='infoanime.php?id=$animeid'>$title</a>
					<div class='d-inline-flex'>
					<a class='d-flex justify-content-end align-content-end px-2' style='font-size:0.8rem' href='list.php?id=$animeid&a=delete'>Remove</a>
					<a class='d-flex justify-content-end align-content-end px-1' style='font-size:0.8rem' href='editanime.php?id=$animeid'>Edit</a>
					</div> 
					</th> 
					<th><a class='text-white' href='rating.php?id=$animeid&userid=$id'>$rating<a></th>
					<th>$genre</th>
	
	
					</tr>"

				);
			} else {
				array_push(
					$animeresult,
					"<tr>
					<th>$count</th>
					<th><img src='./images/bg-4.png' alt='img'  width='100px'></th>
					<th><a class='a-link text-primary pe-2' href='infoanime.php?id=$animeid'>$title</a><div class='d-inline-flex'><a class='d-flex justify-content-end align-content-end' style='font-size:0.8rem' href='list.php?id=$animeid&a=delete'>Remove</a></div> </th> 
					<th><a class='text-white' href='rating.php?id=$animeid&userid=$id'>$rating<a></th>
					<th>$genre</th>
	
	
					</tr>"

				);
			}
		}
	} else {
		ob_end_clean();
		header("Location: index.php");
		exit();
	}
}


echo "<title>Your list</title>"
?>


<body class="mt-5 pt-5 min-vh-100 bg-dark container-fluid">

	<div class='px-4 d-flex flex-column justify-content-center align-content-center'>

		<div class="row mx-auto pb-2">
			<img src="./images/cat_transparent.svg" alt="logo" width="200px" height="200px">
		</div>

		<div class="row-md-6">
			<h1 class="text-center fs-1 fw-bold text-black pt-4"><?php echo $_SESSION['username'] ?>'s List</h1>

		</div>


		<div class="row text-center">
			<?php if (isset($msg)) echo $msg; ?>
		</div>
		<div class="row">
			<div class="d-flex justify-content-center align-content-center mx-auto">
				<form class="d-inline-flex pb-4" action="search.php" method="GET">
					<button type='button' class='btn btn-danger btn-sm border-black text-white p-2 px-3 me-3 w-100' onclick="window.location.href='addanime.php'"><i class='fa-solid fa-plus pe-2'></i>Add anime</button>
					<button type='button' class='btn btn-info btn-sm border-black text-primary p-2 px-3 me-3 w-100' onclick="window.location.href='anime.php'"><i class="fa-solid fa-eye pe-2"></i>View all anime</button>
					<input class="form-control me-2" type="search" placeholder="Search anime" aria-label="Search" name="searchterm" required>
					<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
				</form>
			</div>
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
