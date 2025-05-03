<?php
session_start(); 

require_once 'db.php';

$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

$sql = "SELECT * FROM vehicules 
        JOIN utilisateurs ON vehicules.utilisateur_id = utilisateurs.id 
        WHERE utilisateurs.id = '$user_id'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$vehicules = [];

while ($row = mysqli_fetch_assoc($result)) {
    $vehicules[] = $row;
}

header('Content-Type: application/json');
echo json_encode($vehicules);
?>
