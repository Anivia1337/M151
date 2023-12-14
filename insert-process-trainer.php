<?php
if (isset($_SESSION['loggedin'])) {
	include('include/dbconnector.inc.php');
}

if (isset($_POST['save'])) {
	$first_name = $_POST['vorname'];
	$last_name = $_POST['nachname'];
	$email = $_POST['email'];
	$password = trim($_POST['password']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$sql = "INSERT INTO trainer (vorname,nachname,email,passwort)
	 VALUES ('$first_name','$last_name','$email','$password_hash')";
	if (mysqli_query($mysqli, $sql)) {
		echo "New record created successfully !";
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($mysqli);
	}
	mysqli_close($mysqli);
	header("Location: trainer_verwaltung.php");
}
?>