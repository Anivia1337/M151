<?php
// Verbindung zur Datenbank herstellen
include('include/dbconnector.inc.php');

// Überprüfen, ob das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trainer-ID und bearbeitete Daten aus Formular auslesen und vor SQL-Injektion schützen
    $trainer_id = $mysqli->real_escape_string($_POST['trainer_id']);
    $vorname = $mysqli->real_escape_string($_POST['vorname']);
    $nachname = $mysqli->real_escape_string($_POST['nachname']);
    $email = $mysqli->real_escape_string($_POST['email']);

    // Trainer-Daten in der Datenbank aktualisieren
    $statement = $mysqli->prepare("UPDATE trainer SET vorname = ?, nachname = ?, email = ? WHERE trainer_id = ?");
    $statement->bind_param('sssi', $vorname, $nachname, $email, $trainer_id);
    $statement->execute();

    // Erfolgsmeldung ausgeben
    echo "Die Trainer-Daten wurden erfolgreich aktualisiert!";
} else {
    // Fehler: Das Formular wurde nicht abgesendet
    echo "Das Formular wurde nicht abgesendet!";
}