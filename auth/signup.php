
<?php include '../includes/header.php'; ?>

<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revendtbd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

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
            $message = "Connexion réussie !";
        } else {
            $message = "Utilisateur introuvable. Vérifiez le numéro.";
        }
        $stmt->close();
    } elseif ($action === "S'inscrire") {
        // Inscription
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $email);

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
    <link rel="stylesheet" href="../public/stylesall.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 350px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .tabs {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .tabs button {
            flex: 1;
            padding: 10px;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #333;
        }
        .tabs button.active {
            border-bottom: 2px solid #0056b3;
            font-weight: bold;
            color: #0056b3;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #003f8a;
        }
        .message {
            color: #ff0000;
            text-align: center;
            margin-top: 15px;
        }
        .hidden {
            display: none;
        }
    </style>
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
                <label for="num">Numéro de téléphone :</label>
                <input type="text" id="num" name="num" placeholder="+225123456789" required>
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
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
            </div>
            <div class="form-group">
                <label for="num">Numéro de téléphone :</label>
                <input type="text" id="num" name="num" placeholder="+225123456789" required>
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
</body>
</html>

<br><br>

<?php include '../includes/footer.php';?>
