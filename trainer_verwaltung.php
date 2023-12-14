<?php

// Session starten
session_start();
session_regenerate_id();
// variablen initialisieren
$error = $message = '';
?>

<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administrationbereich</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="index.php">Trainer Bereich</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">

				<?php
				// wenn Session personalisiert
				echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';

				?>
			</ul>
		</div>
	</nav>


	<?php
	if (isset($_SESSION['loggedin'])) {
		include('include/dbconnector.inc.php');
	}
	$result = mysqli_query($mysqli, "SELECT * FROM trainer");
	if (mysqli_num_rows($result) > 0) {
		?>
		<!-- Erstellung der Tabelle -->
		<table>
			<tr>
				<td>Trainer ID</td>
				<td>Vorname</td>
				<td>Nachname</td>
				<td>Email</td>

			</tr>
			<?php
			$i = 0;
			while ($row = mysqli_fetch_array($result)) {
				?>
				<tr>
					<td>
						<?php echo $row["trainer_id"]; ?>
					</td>
					<td>
						<?php echo $row["vorname"]; ?>
					</td>
					<td>
						<?php echo $row["nachname"]; ?>
					</td>
					<td>
						<?php echo $row["email"]; ?>
					</td>
					<td><a href="update-process-trainer.php?trainer_id=<?php echo $row["trainer_id"]; ?>">Update</a></td>
					<td><a href="delete-process-trainer.php?trainer_id=<?php echo $row["trainer_id"]; ?>">Delete</a></td>
				</tr>
				<?php
				$i++;
			}
			?>


		</table>
		<?php
	} else {
		echo "No result found";
	}
	?>

	<form method="post" action="insert-process-trainer.php">
		First name:<br>
		<input type="text" name="vorname">
		<br>
		Last name:<br>
		<input type="text" name="nachname">
		<br>
		Email:<br>
		<input type="email" name="email">
		<br>
		Passwort:<br>
		<input type="text" name="passwort">
		<br><br>
		<input type="submit" name="save" value="submit">
	</form>
</body>

</html>



<?php
include('include/dbconnector.inc.php');
$result = mysqli_query($mysqli, "SELECT * FROM spieler");
?>
<!DOCTYPE html>
<html>

<head>
	<title> Retrive data</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	if (mysqli_num_rows($result) > 0) {
		?>
		<!-- Erstellung der Tabelle -->
		<table>
			<tr>
				<td>Trainer ID</td>
				<td>Vorname</td>
				<td>Nachname</td>
				<td>Email</td>

			</tr>
			<?php
			$i = 0;
			while ($row = mysqli_fetch_array($result)) {
				?>
				<tr>
					<td>
						<?php echo $row["spieler_id"]; ?>
					</td>
					<td>
						<?php echo $row["vorname"]; ?>
					</td>
					<td>
						<?php echo $row["nachname"]; ?>
					</td>
					<td>
						<?php echo $row["email"]; ?>
					</td>
					<td><a href="update-process-spieler.php?spieler_id=<?php echo $row["spieler_id"]; ?>">Update</a></td>
					<td><a href="delete-process-spieler.php?spieler_id=<?php echo $row["spieler_id"]; ?>">Delete</a></td>
				</tr>
				<?php
				$i++;
			}
			?>


		</table>
		<?php
	} else {
		echo "No result found";
	}
	?>

	<form method="post" action="insert-process-spieler.php">
		First name:<br>
		<input type="text" name="vorname">
		<br>
		Last name:<br>
		<input type="text" name="nachname">
		<br>
		Email:<br>
		<input type="email" name="email">
		<br>
		Passwort:<br>
		<input type="text" name="passwort">
		<br><br>
		<input type="submit" name="save" value="submit">
	</form>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
		crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
		crossorigin="anonymous"></script>
</body>

</html>