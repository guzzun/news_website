<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/crud.css">
	<title> GUDNEWS ADMIN </title>
</head>
<body>
	
	
	<form action="crud.php" method="post">
		
		<div class="actions">
			<a href="../index.php" class="add">Back</a>
			<a href="add_article.php" class="add">Adaugă articol</a>
		</div>
			<?php
			include "../database/connect.php";
				$query = "SELECT * FROM articles";

				$sql = mysqli_query($conn, $query);
				echo '<table  id="customers">';
				echo "<thead>
						<tr>
							<th>ID</th>
							<th>Img</th>
							<th>Categorie</th>
							<th>Titlu</th>
							<th>Descrierea</th>
							<th>Continut</th>
							<th>Data </th>
							<th>Views</th>
							<th>Actiuni</th>
						</tr>
					</thead>
					<tbody>";
				while ($row = mysqli_fetch_row($sql)) {
					$rows = count($row);
					echo "<tr>";
					for ($i=0; $i < $rows; $i++)
						if($i == 5)
							echo  "<td>".substr($row[$i],0,280)."...</td>";
						else
							echo  "<td>$row[$i]</td>";
						echo '
							<td class="action_styles">
								<a href="edit_article.php?id='.$row[0].'" class="link">
									<img alt="Editează" title="Editează" src="images/edit.svg" width="18px" hspace="10">
								</a>  
								<a href="delete_article.php?id='.$row[0].'" class="link">
									<img alt="Șterge" title="Șterge" src="images/delete.svg" width="18px" hspace="10">
								</a>
							</td>
						';
					echo "</tr>";
				}
				echo "</tbody></table>";


			mysqli_close($conn);
			?>
	</form>
</body>
</html>