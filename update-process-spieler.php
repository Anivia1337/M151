<?php
// TSession starten
session_start();
session_regenerate_id();
// variablen initialisieren
$error = $message = '';
if (isset($_SESSION['loggedin'])) {
    include('include/dbconnector.inc.php');
    if (count($_POST) > 0) {
        mysqli_query($mysqli, "UPDATE spieler set spieler_id='" . $_POST['spieler_id'] . "', vorname='" . $_POST['vorname'] . "', nachname='" . $_POST['nachname'] . "',email='" . $_POST['email'] . "' WHERE spieler_id='" . $_POST['spieler_id'] . "'");
        $message = "Record Modified Successfully";
    }
    $result = mysqli_query($mysqli, "SELECT * FROM spieler WHERE spieler_id='" . $_GET['spieler_id'] . "'");
    $row = mysqli_fetch_array($result);
}
?>
<html>

<head>
    <title>Spieler Daten korrektur</title>
</head>

<body>
    <form name="frmUser" method="post" action="">
        <div>
            <?php if (isset($message)) {
                echo $message;
            } ?>
        </div>
        <div style="padding-bottom:5px;">
            <a href="trainer_verwaltung.php">zurück</a>
        </div>
        ID: <br>
        <input type="hidden" name="spieler_id" class="txtField" value="<?php echo $row['spieler_id']; ?>">
        <input type="text" name="spieler_id" value="<?php echo $row['spieler_id']; ?>">
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
        <input type="submit" name="submit" value="Submit" class="buttom">

    </form>
</body>

</html>