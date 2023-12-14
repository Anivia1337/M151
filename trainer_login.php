<?php

// Sessionhandling starten
session_start();
session_regenerate_id(true);
// Datenbankverbindung
include('include/dbconnector.inc.php');

$error = '';
$message = '';
$username = $password = '';


// Formular wurde gesendet und Besucher ist noch nicht angemeldet.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// username
	if (isset($_POST['email'])) {
		//trim and sanitize
		$username = htmlspecialchars(trim($_POST['email']));

		// Prüfung username
		if (empty($username)) {
			$error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte den Benutzername ein.<br />";
	}
	// password
	if (isset($_POST['passwort'])) {
		//trim and sanitize
		$password = trim($_POST['passwort']);
		// passwort gültig?
		if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
			$error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
		}
	} else {
		$error .= "Geben Sie bitte das Passwort ein.<br />";
	}

	// kein Fehler
	if (empty($error)) {
		// Query erstellen
		$query = "SELECT trainer_id, email, passwort from trainer where email = ?";

		// Query vorbereiten
		$stmt = $mysqli->prepare($query);
		if ($stmt === false) {
			$error .= 'prepare() failed ' . $mysqli->$error . '<br />';
		}
		// Parameter an Query binden
		if (!$stmt->bind_param("s", $username)) {
			$error .= 'bind_param() failed ' . $mysqli->$error . '<br />';
		}
		// Query ausführen
		if (!$stmt->execute()) {
			$error .= 'execute() failed ' . $mysqli->$error . '<br />';
		}
		// Daten auslesen
		$result = $stmt->get_result();

		// Userdaten lesen
		if ($row = $result->fetch_assoc()) {

			// Passwort ok?
			if (password_verify($password, $row['passwort'])) {

				// TODO - Session personifizieren
				$_SESSION['loggedin'] = true;
				$_SESSION['email'] = $username;
				// TODO - Session ID regenerieren
				session_regenerate_id(true);
				// TODO - weiterleiten auf admin.php
				header('Location: trainer_verwaltung.php');
				// TODO - Script beenden
				exit();
			} else {
				$error .= "Benutzername oder Passwort ist falsch";
			}
		} else {
			$error .= "Benutzername oder Passwort ist falsch";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>
</head>

<body style="background: #181a1b; filter: invert(1) hue-rotate(180deg);">
	<?php
	include('include/nav.php');
	?>
	<div class="container">
		<h1>Login</h1>
		<p>
			Bitte melden Sie sich mit E-Mail und Passwort an.
		</p>
		<?php
		// fehlermeldung oder nachricht ausgeben
		if (!empty($message)) {
			echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
		} else if (!empty($error)) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<label for="email">E-Mail *</label>
				<input type="text" name="email" class="form-control" id="email" value=""
					placeholder="Gross- und Keinbuchstaben, min 6 Zeichen."
					title="Gross- und Keinbuchstaben, min 6 Zeichen." maxlength="100" required="true">
			</div>
			<!-- password -->
			<div class="form-group">
				<label for="passwort">Passwort</label>
				<input type="password" name="passwort" class="form-control" id="passwort"
					placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute"
					pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
					title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
					maxlength="255" required="true">
			</div>
			<button type="submit" name="button" value="submit" class="btn btn-info" onklick="click">Senden</button>
			<button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
		</form>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
		crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
		crossorigin="anonymous"></script>

	<script>
		// Get a reference to the button element
		var submit = document.getElementById('submit');
		// Event listener for the button click "event"
		submit.addEventListener('click', function () {
			// Redirect to the target URL
			window.location.href = 'verwaltung.php';
		});
	</script>
</body>

</html>