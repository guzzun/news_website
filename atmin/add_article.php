<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/add.css">
	<title> GUDNEWS ADMIN </title>
</head>

<body>
	<form name="form_user" method="post" action="" enctype="multipart/form-data">
		<a href="crud.php">
				Listează articole
		</a>

		<h1>Adaugare articol</h1>
		<h3>Select image to upload:</h3>
		<input required type="file" name="fileToUpload" id="fileToUpload">
		<br><br>
		<label for="category">Categorie</label>
		<input required type="text" name="category" id="category">
		<br><br>
		<label for="title">Titlu</label>
		<textarea name="title" id="title"></textarea>
		<br><br>
		<label for="description">Descrierea</label></td>
		<textarea name="description" id="description"></textarea>
		<br><br>
		<label for="continutu">Continutu</label></td>
		<textarea name="continutu" id="continutu"></textarea>
		<br><br>
		<label for="date">Data Plasarii</label></td>
		<input required type="date" name="date" id="date">
		<br><br><br>
		<input type="submit" name="submit" value="adauga">

		<?php
		include "../database/connect.php";
		if (isset($_POST['submit'])) {
			$nume_imagine = basename($_FILES["fileToUpload"]["name"]);
			$target_dir = "../img/post/";
			$target_file = $target_dir . $nume_imagine;
			$uploadOk = 1;

			// Check if file already exists
			if (file_exists($target_file)) {
				// echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				// echo "<b class=\"message\">Sorry, your file was not uploaded.</b>";
				
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "<b class=\"message\">The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.</b>";
				} else {
					echo "<b class=\"message\">Sorry, there was an error uploading your file.</b>";
				}
			}

			$category   = $_POST['category'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$continutu  = $_POST['continutu'];
			$date = $_POST['date'];
			$nr_vizionari = 1;

			$query = "INSERT INTO articles (nume_imagine, categorie, titlu, descrierea, continutu, data_plasarii, nr_vizionari)
					  VALUES ('$nume_imagine', '$category', '$title', '$description', '$continutu','$date', '$nr_vizionari');";

			if (mysqli_query($conn, $query))
				print '<b class="message">Datele au fost introduse cu succes!</b>';
			else
				print '<b class="message">Error:' . $query . '<br>' . mysqli_error($conn) . '</b>';

			mysqli_close($conn);
		}
		?>
	</form>
</body>

</html>