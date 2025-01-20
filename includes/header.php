<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revendtout</title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
</head>
<body>
    <header>
        <div class="logo"><a href="../includes/index.php">REVENDTOUT</a></div>
        <nav>
            <a href="../public/index.php">Accueil</a>
            <a href="../paysell/shop.php">Acheter</a>
            <a href="../paysell/sell.php">Vendre un article</a>
            <a href="#about" id="">Nous</a>
            <a href="#contact" id="">Contact</a>
            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Si l'utilisateur est connecté -->
                <span class="user">
                    <a href="../userprofile/profile.php"><i class="fas fa-user-circle"></i> &nbsp; </a> 
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <a href="../auth/logout.php">Se déconnecter</a>
            <?php else: ?>
                <!-- Si l'utilisateur est déconnecté -->
                <a href="../auth/signup.php"><i class="fa-regular fa-user"></i>&nbsp; &nbsp;S'inscrire | Se connecter</a>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>
