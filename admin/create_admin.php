<?php include '../auth/db.php'; ?>

<?php

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; // Connexion ou Inscription
    $email = $_POST['email'];

    if ($action === "Se connecter") {
        // Connexion
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msgsucc = "Connexion réussie !";
            header("Location: ../admin/admin.php"); 
        } else {
            $msgerr = "Compte introuvable. Vérifiez votre adresse ou inscrivez-vous.";
        }
        $stmt->close();
    } elseif ($action === "S'inscrire") {
        // Inscription
        $name = $_POST['nomad'] ?? null;
        $name = $_POST['email'] ?? null;
        $num = $_POST['num'] ?? null;
        $role = $_POST['role'] ?? 'admin'; // Par défaut, rôle admin
        $sql = "INSERT INTO admin (nomad, email, num, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $num, $role);

        if ($stmt->execute()) {
            $msgsucc = "Compte créé avec succès!";
        } else {
            $msgerr = "Erreur lors de la création du compte administrateur.";
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
    <style>
        /* Ajoutez du style ici si nécessaire */ 
        .msgerr { color: red; }
        .msgsucc { color: green; }
        .hidden { display: none; }
        .active { font-weight: bold; }
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
                <label for="email">Courriel : </label>
                <input type="text" id="email" name="email" placeholder="admin@gmail.com" required>
            </div>
            <input type="hidden" name="action" value="Se connecter">
            <div class="form-group">
                <button type="submit">Se connecter</button>
            </div>
        </form>

        <!-- Formulaire d'Inscription -->
        <form id="register-form" action="" method="POST" class="hidden">
            <div class="form-group">
                <label for="nomad">Nom :</label>
                <input type="text" id="nomad" name="nomad" placeholder="Votre nom" required>
            </div>
            <div class="form-group">
                <label for="email">Courriel :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
            </div>
            <div class="form-group">
                <label for="num">Numéro de téléphone :</label>
                <input type="text" id="num" name="num" placeholder="Votre numéro" required>
            </div>
            <input type="hidden" name="action" value="S'inscrire">
            <div class="form-group">
                <button type="submit">Créer un compte administrateur</button>
            </div>
        </form>

        <?php if (isset($msgerr)): ?>
            <div class="msgerr"><?= htmlspecialchars($msgerr) ?></div>
        <?php endif; ?>
        <?php if (isset($msgsucc)): ?>
            <div class="msgsucc"><?= htmlspecialchars($msgsucc) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
