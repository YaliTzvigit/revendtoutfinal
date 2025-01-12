

<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revendtbd";

try {
    // Création d'une instance PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration du mode d'erreur de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Connexion échouée : " . $e->getMessage());
}

session_start(); // Pour gérer la session de connexion


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; // Connexion ou Inscription
    $email = $_POST['email'];

    if ($action === "Se connecter") {
        // Connexion
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); 
            $_SESSION['user_name'] = $user['nom']; 
            $_SESSION['user_email'] = $user['email']; 
            $message = "Connexion réussie !";
            header("Location: ../public/index.php");
            exit();
        } else {
            $message = "Utilisateur introuvable. Vérifiez le numéro.";
        }
        $stmt->close();
    } elseif ($action === "S'inscrire") {
        // Inscription
        $name = $_POST['name'];
        $email = $_POST['email'];
        $num = $_POST['num'];
        $sql = "INSERT INTO users (nom, email, num) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $num);

        if ($stmt->execute()) {
            $message = "Inscription réussie !";
        } else {
            $message = "Erreur lors de l'inscription.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription</title>
    <link rel="stylesheet" href="../includes/css/signlogin.css">
</head>
<body>
    <div class="container">
        <div class="tabs">
            <button id="login-tab" class="active" onclick="toggleForm('login')">Connexion</button>
            <button id="register-tab" onclick="toggleForm('register')">Inscription</button>
        </div>

        <!-- Formulaire de Connexion -->
        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <label for="email">Courriel : </label>
                <input type="text" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
            <input type="hidden" name="action" value="Se connecter">
            <div class="form-group">
                <button type="submit">Se connecter</button>
            </div>
        </form>

        <!-- Formulaire d'Inscription -->
        <form id="register-form" action="" method="POST" class="hidden">
            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" placeholder="Votre nom" required>
            </div>
            <div class="form-group">
                <label for="email">Courriel :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
            </div>
            <div class="form-group">
                <label for="num">Numéro de téléphone :</label>
                <input type="text" id="num" name="num" placeholder="(+225) 0123456789" required>
            </div>
            <input type="hidden" name="action" value="S'inscrire">
            <div class="form-group">
                <button type="submit">S'inscrire</button>
            </div>
        </form>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

    </div>
    <script>
        function toggleForm(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');

            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginTab.classList.remove('active');
                registerTab.classList.add('active');
            }
        }

    </script>
</body>
</html>
