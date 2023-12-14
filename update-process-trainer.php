<?php
// Session starten
session_start();
session_regenerate_id();
// variablen initialisieren
$error = $message = '';
if (isset($_SESSION['loggedin'])) {
    include('include/dbconnector.inc.php');
    if (count($_POST) > 0) {
        mysqli_query($mysqli, "UPDATE trainer set trainer_id='" . $_POST['trainer_id'] . "', vorname='" . $_POST['vorname'] . "', nachname='" . $_POST['nachname'] . "',email='" . $_POST['email'] . "' WHERE trainer_id='" . $_POST['trainer_id'] . "'");
        $message = "Record Modified Successfully";
    }
    $result = mysqli_query($mysqli, "SELECT * FROM trainer WHERE trainer_id='" . $_GET['trainer_id'] . "'");
    $row = mysqli_fetch_array($result);
}
?>
<html>

<head>
    <title>Spieler Daten korrektur</title>
</head>

<body>
<link rel="stylesheet" type="text/css" href="style.css">
        <div class="container">
            <div class="box">
            <h1 class="text">Daten Aktualisieren</h1>
            </div>
        </div>
        <br>


    <form name="frmUser" method="post" action="">
        <div>
            <?php if (isset($message)) {
                echo $message;
            } ?>
        </div>

        ID: <br>
        <input type="hidden" name="trainer_id" class="txtField" value="<?php echo $row['trainer_id']; ?>">
        <input type="text" name="trainer_id" value="<?php echo $row['trainer_id']; ?>">
        <br>
        First Name: <br>
        <input type="text" name="vorname" class="txtField" value="<?php echo $row['vorname']; ?>">
        <br>
        Last Name :<br>
        <input type="text" name="nachname" class="txtField" value="<?php echo $row['nachname']; ?>">
        <br>
        Email:<br>
        <input type="text" name="email" class="txtField" value="<?php echo $row['email']; ?>">
        <br>
        <br>
        <button type="back" name="back" value="Back" class="button" oncklick="window.location.href='trainer_verwaltung.php'" style="top: 0px;">Verwaltung</button>
        <input type="submit" name="submit" value="Submit" class="button">

    </form>
</body>
</html>