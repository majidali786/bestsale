<?php 

//if (isset($_POST['query'])) {

	$connect = mysqli_connect("localhost","root","","ajax");

	$test = mysqli_real_escape_string($connect,$_POST['query']);
	
	$output = "";
	//$query = "SELECT * FROM country WHERE country_name LIKE '%".$_POST['query']."%';";
	$query = "SELECT * FROM country WHERE country_name LIKE '%$test%' ORDER BY country_name ASC";

	$result = mysqli_query($connect,$query);
	$output = '<ul class="list-unstyled">';

	if (mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$output .= '<li>'.$row["country_name"].'</li>';
		}
	} else {
		$output .= '<li>Country Not Found</li>';
	}
	$output .= '</ul>';
	echo $output;
//}

/* if (isset($_POST['query']) && !empty($_POST['query'])) {

	$connect = mysqli_connect("localhost","root","","ajax");

	if (!$connect) {
		echo "Error Connecting DataBase";
		exit();
	}
	$search = $_POST['query'];

	$query = "SELECT * FROM country WHERE country_name LIKE '%$search%'";
	$result = mysqli_query($connect,$query);

	if (mysqli_num_rows($result) > 0) {
		while ($d = mysqli_fetch_assoc($result)) {
			echo $d['country_name']."<br />";
		}
	} else {
		echo "Nothing matched with your query";
	}
} */

 ?>