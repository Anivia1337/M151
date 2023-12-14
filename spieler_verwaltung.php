
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // TSession starten
session_start();
session_regenerate_id();
   if (isset($_SESSION['spieler'])) {
        include('include/dbconnector.inc.php');
      }else { die(); header('Location: index.php');}
        if(count($_POST)>0) {
        mysqli_query($mysqli,"UPDATE user set spieler_id='" . $_POST['spieler_id'] . "', vorname='" . $_POST['vorname'] . "', nachname='" . $_POST['nachname'] . "',email='" . $_POST['email'] . "' WHERE spieler_id='" . $_POST['spieler_id'] . "'");
        $message = "Record Modified Successfully";
        }
        $result = mysqli_query($mysqli,"SELECT * FROM spieler WHERE spieler_id='" . $_GET['spieler_id'] . "'");
        $row= mysqli_fetch_array($result);
  
    ?>

</head>
<body>
<form name="frmUser" method="post" action="">
<div>
    <?php if(isset($message)) { echo $message; } ?>
</div>
<div style="padding-bottom:5px;">
<a href="logout.php">logout</a>
</div>

<link rel="stylesheet" type="text/css" href="style.css">
        <div class="container">
            <div class="box">
            <h1 class="text">Verwaltung der der eigenen Daten</h1>
            </div>
        </div>

        Username: <br>
        <input type="hidden" name="spieler_id" class="txtField" value="<?php echo $row['spieler_id']; ?>">
        <input type="text" name="spieler_id"  value="<?php echo $row['spieler_id']; ?>">
        <br>

        First Name: <br>
        <input type="text" name="vorname" class="txtField" value="<?php echo $row['vorname']; ?>">
        <br>

        Last Name :<br>
        <input type="text" name="nachname" class="txtField" value="<?php echo $row['nachname']; ?>">
        <br>

        Email:<br>
        <input type="text" name="email" class="txtField" value="<?php echo $row['email']; ?>">

        <input type="submit" name="submit" value="Submit" class="buttom">

</form>
</body>
</html>
