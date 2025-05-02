<?php
$host = 'localhost';
$db = 'location_voiture';
$user = 'root';
$pass = 'malek'; // ou ton mot de passe MySQL

$conn = new mysqli($host, $user, $pass, $db);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
