<?php
// Session starten
session_start();
// Session leeren
session_destroy();
// Weiterleiten auf login.php
header("Location: index.php");
?>