<?php
include "../database/connect.php";

	$id = $_GET['id'];
	
	$query2 = "SELECT nume_imagine FROM articles WHERE id = '$id'";	
	$filename = mysqli_query($conn, $query2);
	$filename = mysqli_fetch_row($filename);
	$filename = $filename[0];

	if (file_exists("../img/post/".$filename)) {
		unlink("../img/post/".$filename);

		$query1 = "DELETE FROM articles WHERE id = '$id'";
		mysqli_query($conn, $query1);

		header("Location: crud.php");
	} else {
		echo 'Could not delete '.$filename.', file does not exist';
	}


mysqli_close($conn);