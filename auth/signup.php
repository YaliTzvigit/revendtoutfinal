<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revendtbd";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

// Gestion des formulaires
$message = ""; // Variable pour afficher des messages d'erreur ou de succès
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['register'])) {
        // Inscription
        $nom = htmlspecialchars(trim($_POST['nom']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $num = htmlspecialchars(trim($_POST['num']));
        $password = htmlspecialchars(trim($_POST['mdp']));
        $confirm_password = htmlspecialchars(trim($_POST['mdpconfirm']));

        // Validation
        if (empty($nom) || empty($email) || empty($num) || empty($password) || empty($confirm_password)) {
            $message = "Tous les champs sont obligatoires.";
        } elseif ($password !== $confirm_password) {
            $message = "Les mots de passe ne correspondent pas.";
        } elseif (
            strlen($password) < 8 ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            $message = "Le mot de passe doit avoir au moins 8 caractères, un chiffre, et un caractère spécial.";
        } else {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Vérifier si l'email existe déjà
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $message = "Cet e-mail est déjà utilisé.";
            } else {
                // Insérer les données
                try {
                    $stmt = $conn->prepare("INSERT INTO users (nom, email, num, mdp) VALUES (:nom, :email, :num, :mdp)");
                    $stmt->bindParam(':nom', $nom);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':num', $num);
                    $stmt->bindParam(':mdp', $hashed_password);

                    if ($stmt->execute()) {
                        $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    } else {
                        $message = "Erreur lors de l'inscription.";
                    }
                } catch (PDOException $e) {
                    $message = "Erreur : " . $e->getMessage();
                }
            }
        }
    } elseif (isset($_POST['login'])) {
        // Connexion
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($_POST['mdp']);

        if (empty($email) || empty($password)) {
            $message = "Tous les champs sont obligatoires.";
        } else {
            // Vérifier les identifiants
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['mdp'])) {
                $message = "Connexion réussie ! Bienvenue, " . htmlspecialchars($user['nom']) . ".";
                // Redirection ou session à gérer ici
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Création de Compte</title>
    <link rel="stylesheet" href="../includes/css/signlogin.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<header>
    <div class="logo">REVENDTOUT</div>
    <nav>
        <a href="../public/index.php">Accueil</a>
        <a href="../paysell/shop.php">Acheter</a>
        <a href="../paysell/sell.php">Vendre un article</a>
        <a href="#contact">Contact</a>
    </nav>
</header><br><br><br><br>

<blockquote> Bienvenue sur <span>REVENDTOUT</span> </blockquote>

<main>
    <div class="container">
        <div class="tabs">
            <button class="active" data-target="#login">Se connecter</button>
            <button data-target="#register">Créer un compte</button>
        </div>

        <?php if (!empty($message)) : ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Connexion -->
        <div id="login" class="form active">
            <form method="POST" action="">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email" id="email" placeholder="Adresse e-mail" required>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>

                <button type="submit" name="login">Se connecter</button>
            </form>
        </div>

        <!-- Inscription -->
        <div id="register" class="form">
            <form method="POST" action="">
                <label for="username">Votre nom</label>
                <input type="text" name="nom" id="username" placeholder="Votre nom sur Revendtout" required>

                <label for="email-register">Adresse e-mail</label>
                <input type="email" name="email" id="email-register" placeholder="Adresse e-mail" required>

                <label for="numtel">Votre numéro de téléphone</label>
                <input type="text" name="num" id="numtel" placeholder="Votre numéro de téléphone" required>

                <label for="password-register">Nouveau mot de passe</label>
                <input type="password" name="password" id="password-register" placeholder="Mot de passe" required>

                <label for="confirm-password">Confirmez le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirmez le mot de passe" required>

                <button type="submit" name="register">Créer son compte</button>
            </form>
        </div>
    </div>
</main>

<footer id="contact">
    <p>&copy; 2025 Tous droits réservés. Plateforme d'inscription.</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tabs button');
    const forms = document.querySelectorAll('.form');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            forms.forEach(f => f.classList.remove('active'));
            tab.classList.add('active');
            document.querySelector(tab.dataset.target).classList.add('active');
        });
    });
});
</script>
</body>
</html>
