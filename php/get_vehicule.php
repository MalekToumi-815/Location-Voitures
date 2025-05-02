<?php
require_once 'db.php';

$sql = "SELECT * FROM vehicules join utilisateurs on utilisateur_id = utilisateurs.id WHERE disponible = 1 ;";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$vehicules = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicules[] = $row;
    }
}   

header('Content-Type: application/json');
echo json_encode($vehicules);
?>
