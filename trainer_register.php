<?php

// Sessionhandling starten


// Datenbankverbindung
include('include/dbconnector.inc.php');

// Initialisierung
$error = $message = '';
$vorname = $nachname = $email = $password = '';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Vorname ausgefüllt?
  if (isset($_POST['vorname'])) {
    //trim and sanitize
    $vorname = htmlspecialchars(trim($_POST['vorname']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($vorname) || strlen($vorname) > 30) {
      $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Vornamen ein.<br />";
  }

  // Nachname ausgefüllt?
  if (isset($_POST['nachname'])) {
    //trim and sanitize
    $nachname = htmlspecialchars(trim($_POST['nachname']));

    //mindestens 1 Zeichen und maximal 30 Zeichen lang
    if (empty($nachname) || strlen($nachname) > 30) {
      $error .= "Geben Sie bitte einen korrekten Nachname ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte einen Nachname ein.<br />";
  }

  // Email ausgefüllt?
  if (isset($_POST['email'])) {
    //trim an sanitize
    $email = htmlspecialchars(trim($_POST['email']));

    //mindestens 1 Zeichen und maximal 100 Zeichen lang, gültige Emailadresse
    if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $error .= "Geben Sie bitte eine korrekten Emailadresse ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte eine Emailadresse ein.<br />";
  }



  // Passwort ausgefüllt
  if (isset($_POST['password'])) {
    //trim and sanitize
    $password = trim($_POST['password']);

    //mindestens 1 Zeichen , entsprich RegEX
    if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
      $error .= "Geben Sie bitte einen korrektes Password ein.<br />";
    }
  } else {
    $error .= "Geben Sie bitte ein Password ein.<br />";
  }

  // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
  if (empty($error)) {
    // Password haschen
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Query erstellen
    $query = "Insert into trainer (vorname, nachname, passwort, email) values (?,?,?,?)";

    // Query vorbereiten
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
      $error .= 'prepare() failed ' . $mysqli->$error . '<br />';
    }

    // Parameter an Query binden
    if (!$stmt->bind_param('ssss', $vorname, $nachname, $password_hash, $email)) {
      $error .= 'bind_param() failed ' . $mysqli->$error . '<br />';
    }

    // Query ausführen
    if (!$stmt->execute()) {
      $error .= 'execute() failed ' . $mysqli->$error . '<br />';
    }

    // kein Fehler!
    if (empty($error)) {
      $message .= "Die Daten wurden erfolgreich in die Datenbank geschrieben<br/ >";
      // Felder leeren und Weiterleitung auf anderes Script: z.B. Login!
      $passwort = $vorname = $nachname = $email = '';
      // Verbindung schliessen
      $mysqli->close();
      // Weiterleiten auf login.php
      header('Location: index.php');
      // beenden des Scriptes
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrierung</title>

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
    <h1>Registrierung</h1>
    <p>
      Bitte registrieren Sie sich, damit Sie diesen Dienst benutzen können.
    </p>
    <?php
    // Ausgabe der Fehlermeldungen
    if (!empty($error)) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    } else if (!empty($message)) {
      echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
    }
    ?>
    <form action="" method="post">
      <!-- vorname -->
      <div class="form-group">
        <label for="vorname">Vorname *</label>
        <input type="text" name="vorname" class="form-control" id="vorname" value="<?php echo $vorname ?>"
          placeholder="Geben Sie Ihren Vornamen an." maxlength="30" required="true">
      </div>
      <!-- nachname -->
      <div class="form-group">
        <label for="nachname">Nachname *</label>
        <input type="text" name="nachname" class="form-control" id="nachname" value="<?php echo $nachname ?>"
          placeholder="Geben Sie Ihren Nachnamen an" maxlength="30" required="true">
      </div>
      <!-- email -->
      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>"
          placeholder="Geben Sie Ihre Email-Adresse an." maxlength="100" required="true">
      </div>

      <!-- password -->
      <div class="form-group">
        <label for="password">Passwort *</label>
        <input type="password" name="password" class="form-control" id="passwort"
          placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute"
          pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
          title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
          maxlength="255" required="true">
      </div>
      <!-- Send / Reset -->
      <button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
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
</body>

</html>