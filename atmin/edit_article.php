<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/add.css">
	<title> GUDNEWS ADMIN </title>
</head>

<body>
	<form name="form_user" action="" method="post" enctype="multipart/form-data">
		<a href="crud.php"> Articole </a>

		<?php
		include "../database/connect.php";

		$id = $_GET['id'];
		$query = "SELECT * FROM articles WHERE id='$id'";
		$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$row = mysqli_fetch_assoc($sql);

		$nume_imagine_old = $row['nume_imagine'];
		$categorie    = $row['categorie'];
		$titlu = $row['titlu'];
		$description  = $row['descrierea'];
		$continutu   = $row['continutu'];
		$data_plasarii     = $row['data_plasarii'];
		$nr_vizionari = $row['nr_vizionari'];

		?>

		<h2>Editare articol -> id:<?php echo $row['id']; ?></h2>
		<h4>Selectare imagine pentru incarcare:</h4>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<br><br>
		<label for="category">Categorie</label>
		<input type="text" name="category" id="category" value="<?php echo $categorie; ?>">
		<br><br>
		<label for="title">Titlu</label>
		<textarea name="title" id="title"> <?php echo $titlu; ?> </textarea>
		<br><br>
		<label for="description">Descrierea</label></td>
		<textarea name="description" id="description"> <?php echo $description; ?> </textarea>
		<br><br>
		<label for="continutu">Continutu</label></td>
		<textarea style="height: 50vh;" class="content" name="continutu" id="continutu"> <?php echo $continutu; ?> </textarea>
		<br><br>
		<label for="date">Data Plasarii</label></td>
		<input type="date" name="date" id="date" value="<?php echo $data_plasarii; ?>">
		<br><br><br>
		<input type="submit" name="submit" value="adauga">

		<?php

		if (isset($_POST['submit'])) {
			$category   = $_POST['category'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$continutu  = $_POST['continutu'];
			$continutu = str_replace("'","\'",$continutu);
			$continutu = str_replace('"','\"',$continutu);
			$date = $_POST['date'];

			$nume_imagine_upload = basename($_FILES["fileToUpload"]["name"]);
				//if image was not selected
			if (empty($nume_imagine_upload)) {
				$update_query = "UPDATE articles SET
										categorie = '$category',
										titlu = '$title',
										descrierea = '$description',
										continutu = '$continutu',
										data_plasarii = '$date'
										WHERE id = '$id'";

				if (mysqli_query($conn, $update_query))
					echo '<script class="message"> window.location.href = "edit_article.php?id='.$id.'"; </script>';
				else
					echo '<b class="message"> Eroare la actualizarea înregistrării: ' . mysqli_error($conn) . '</b>';
			} else {
				$target_dir = "../img/post/";
				$target_file = $target_dir . $nume_imagine_upload;

				if (file_exists("../img/post/" . $nume_imagine_old)) {
					unlink("../img/post/" . $nume_imagine_old);
	
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						echo "<b class=\"message\">The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.</b>";
						$update_query = "UPDATE articles SET
												nume_imagine = '$nume_imagine_upload',
												categorie = '$category',
												titlu = '$title',
												descrierea = '$description',
												continutu = '$continutu',
												data_plasarii = '$date'
												WHERE id = '$id'";
	
							if (mysqli_query($conn, $update_query))
								echo '<b class="message"> Adaugare executata cu succes </b>';
							else
								echo '<b class="message"> Eroare la actualizarea înregistrării: ' . mysqli_error($conn) . '</b>';
						} else 
							echo "<b class=\"message\">Sorry, there was an error uploading your file.</b>";
				} else 
					echo 'Could not delete ' . $nume_imagine_old . ', file does not exist, maybe you already deleted it.';
			}

		}
		mysqli_close($conn);
		?>
	</form>
</body>

</html>