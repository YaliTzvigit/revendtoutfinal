

 <!-- modifier son profil -->

<?php
include '../includes/config.php';
include '../auth/db.php';
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: ../auth/signup.php");
    exit;
}

// Récupération de l'ID utilisateur
$user_id = $_SESSION['id'];

// Récupère les données utilisateur actuelles
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
if (!$query) {
    die("Erreur dans la préparation de la requête : " . $conn->error);
}
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Erreur : utilisateur introuvable.");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['nom']);
    $new_email = trim($_POST['email']);

    // Validation basique des champs
    if (empty($new_name) || empty($new_email)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        // Mise à jour des informations utilisateur
        $update_query = $conn->prepare("UPDATE users SET nom = ?, email = ? WHERE id = ?");
        if (!$update_query) {
            die("Erreur dans la préparation de la requête : " . $conn->error);
        }
        $update_query->bind_param("ssi", $new_name, $new_email, $user_id);
        if ($update_query->execute()) {
            $success = "Profil mis à jour avec succès.";
            // Met à jour les informations en session (si nécessaire)
            $_SESSION['namep'] = $new_name;
        } else {
            $error = "Erreur lors de la mise à jour : " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="../includes/css/signlogin.css">
</head>
<body>
    <header>
        <h1>Modifier mon profil</h1>
        <a href="profile.php">Retour au profil</a>
    </header>
    <main>
        <form action="modif_profile.php" method="POST">
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php elseif (isset($success)): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            
            <label for="namep">Nom d'utilisateur :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['namep']) ?>" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <button type="submit">Mettre à jour</button>
        </form>
    </main>
</body>
</html>
