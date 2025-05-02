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
        echo "<script>
                window.location.href = '../login.html'; // Redirige vers la page de connexion
                alert('❌ Cet email est déjà enregistré.');
                </script>";
        exit;
    }

    // Insertion de l'utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $email, $mot_de_passe, $telephone);

    if ($stmt->execute()) {
        // Rediriger vers login.html après une inscription réussie, avec une alerte JavaScript
        echo "<script>
                alert('✅ Inscription réussie!');
                window.location.href = '../login.html'; // Redirige vers la page de connexion
                </script>";
        exit; // Arrêter l'exécution du script après la redirection
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
