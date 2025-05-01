<?php
require_once 'db.php'; // Inclut ta connexion à la base

// Vérifie que le formulaire a bien été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telephone = htmlspecialchars($_POST['numero']);

    // Vérifie si l'email existe déjà
    $check = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "❌ Cet email est déjà enregistré.";
        exit;
    }

    // Insertion de l'utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $email, $mot_de_passe, $telephone);

    if ($stmt->execute()) {
        echo "✅ Inscription réussie. <a href='../login.html'>Se connecter</a>";
    } else {
        echo "❌ Erreur lors de l'inscription : " . $stmt->error;
    }

    $stmt->close();
    $check->close();
    $conn->close();
} else {
    echo "Méthode non autorisée.";
}
?>
