<?php
require_once("./includes/connectlocal.inc");
require_once('./includes/basehead.html');

if (!empty($_GET['s'])) {
	echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top z-2' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' class='me-2'
	id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
	<path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
	</svg>";

	echo "Successfully added anime!";

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
	</div>";
	header("refresh:3;url=anime.php");
}

?>
<title>Anime</title>

<a href="addanime.php">Add anime</a>

<form class="mx-auto pt-2" action="search.php" method="POST">
	<input class="form-control me-2" type="search" placeholder="Search for anime" aria-label="Search" name="searchterm" value="<?php if (isset($_POST['searchterm'])) echo $_POST['searchterm']; ?>">
	<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
</form>


<?php

include('footer.php');
