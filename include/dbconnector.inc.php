<?php

// - mit eigener Datenbak verbinden
// - namen an nutzen angepasst
$host = 'localhost';
$database = 'sportverein';
$username = 'connector';
$password = 'connector';

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// Fehlermeldung, falls Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}