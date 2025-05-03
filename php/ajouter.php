<?php
session_start(); // Démarre la session pour s'assurer que les informations de session sont disponibles

require_once 'db.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si le formulaire a été soumis et si le fichier est téléchargé
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Sécurise les entrées utilisateur en échappant les caractères spéciaux
    $marque = mysqli_real_escape_string($conn, $_POST['marque']);
    $modele = mysqli_real_escape_string($conn, $_POST['modele']);
    $prix_jour = mysqli_real_escape_string($conn, $_POST['prix_jour']);

    // Récupère les informations sur le fichier téléchargé
    $file = $_FILES['image'];
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    // Génère un nom de fichier simple comme img1, img2, etc., en fonction du nombre d'images dans la base de données
    $sql = "SELECT COUNT(*) AS total FROM vehicules";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalImages = $row['total'];

    // Définir le nouveau nom de fichier basé sur le nombre total d'images
    $newFileName = 'img' . ($totalImages + 1) . '.' . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Définir le répertoire de téléchargement des fichiers
    $uploadDirectory = '../uploads/'; 

    // Vérifie s'il n'y a pas d'erreur lors du téléchargement du fichier
    if ($fileError === 0) {
            // Déplace le fichier dans le répertoire des téléchargements
            if (move_uploaded_file($fileTmpName, $uploadDirectory . $newFileName)) {
                // Insère les informations du véhicule dans la base de données
                $sql = "INSERT INTO vehicules (utilisateur_id, marque, modele, prix_jour, disponible, image)
                        VALUES ('{$_SESSION['user_id']}', '$marque', '$modele', '$prix_jour', 1, '$newFileName')";

                // Si l'insertion dans la base de données est réussie, redirige l'utilisateur
                if (mysqli_query($conn, $sql)) {
                    header("Location: ../louer.html"); // Redirige vers la page louer.html
                    exit(); // Termine l'exécution du script
                } else {
                    echo 'Erreur: ' . mysqli_error($conn); // Affiche l'erreur en cas de problème avec la requête
                }
            } else {
                echo 'Erreur lors du téléchargement du fichier.'; // Affiche un message d'erreur si le fichier n'a pas été téléchargé correctement
            }
    } else {
        echo 'Erreur lors du téléchargement du fichier.'; // Affiche un message d'erreur si une erreur est survenue lors du téléchargement du fichier
    }
} else {
    echo 'Aucun fichier téléchargé.'; // Affiche un message si aucun fichier n'a été soumis
}

?>
