<?php
require_once 'db.php'; // Inclut la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['password'];

    // Prépare et exécute la requête pour récupérer l'utilisateur
    $stmt = $conn->prepare("SELECT id, nom, mot_de_passe FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifie si un utilisateur correspond
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Vérifie le mot de passe
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Démarre la session et redirige
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];

            echo "<script>
                    alert('✅ Connexion réussie. Bienvenue, " . htmlspecialchars($user['nom']) . "!');
                    window.location.href = '../louer.html';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Mot de passe incorrect.');
                    window.location.href = '../login.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('❌ Aucun utilisateur trouvé avec cet e-mail.');
                window.location.href = '../login.html';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Méthode non autorisée.";
}
?>
