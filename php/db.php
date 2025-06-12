<?php
$host = 'localhost';
$db = 'location_voiture';
$user = 'user';
$pass = 'password'; // ajouter votre username et password de MySQL

$conn = new mysqli($host, $user, $pass, $db);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>