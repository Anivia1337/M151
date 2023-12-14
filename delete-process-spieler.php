<?php
include('include/dbconnector.inc.php');
$sql = "DELETE FROM spieler WHERE spieler_id='" . $_GET["spieler_id"] . "'";
if (mysqli_query($mysqli, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($mysqli);
}
mysqli_close($mysqli);
header("Location: trainer_verwaltung.php");
?>