
<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
</head>
<body>
<section class="header">
        <a href="" class="logo"> REVENDTOUT</a>

        <nav class="nav" id="navbar">
            <a href="../public/index.php">< &nbsp; Retour à l'accueil</a>
            <a href="../paysell/sell.php">VENDRE</a>
            <a href="">NOUS</a>
            <a href="" class="whatsapp">WHATSAPP</a>
            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Si l'utilisateur est connecté -->
                <span class="user">
                    <a href="../userprofile/profile.php"><i class="fas fa-user-circle" title="Mon profil"></i> &nbsp; </a> 
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <a href="../auth/logout.php">Se déconnecter</a>
            <?php else: ?>
                <!-- Si l'utilisateur est déconnecté -->
                <a href="../auth/signup.php">S'inscrire | Se connecter</a>
            <?php endif; ?>
        </nav>
    </section>
<br> <br><!-- sauts de ligne -->
<section class="search">
    <input type="search">
    <select>
        <option>Toutes les catégories...</option>
        <option>Electronique</option>
        <option>Mode</option>
        <option>Cosmétique</option>
        <option>Maison et Jardin</option>
        <option>Loisirs et Sport</option>
        <option>Livres et Médias</option>
        <option>Automobile</option>
        <option>Autres</option>
    </select><input type="search">
    <button type="submit">Rechercher un article</button>
</section> <br><br>
<div class="dropdown-menu">
    <ul>
        <li><a href="#">Électronique</a>
            <ul>
                <li><a href="#">Smartphones</a></li>
                <li><a href="#">Ordinateurs</a></li>
                <li><a href="#">Accessoires</a></li>
            </ul>
        </li>
        <li><a href="#">Mode</a>
            <ul>
                <li><a href="#">Vêtements</a></li>
                <li><a href="#">Chaussures</a></li>
                <li><a href="#">Bijoux</a></li>
            </ul>
        </li>
        <li><a href="#">Cosmétique</a>
            <ul>
                <li><a href="#">Soins Corporels</a></li>
                <li><a href="#">Perruques</a></li>
            </ul>
        </li>
        <li><a href="#">Maison et Jardin</a>
            <ul>
                <li><a href="#">Meubles</a></li>
                <li><a href="#">Électroménagers</a></li>
                <li><a href="#">Outils</a></li>
            </ul>
        </li>
        <li><a href="#">Loisirs et Sport</a>
            <ul>
                <li><a href="#">Jeux</a></li>
                <li><a href="#">Équipements sportifs</a></li>
            </ul>
        </li>
        <li><a href="#">Livres et Médias</a>
            <ul>
                <li><a href="#">Livres</a></li>
                <li><a href="#">DVD</a></li>
                <li><a href="#">Jeux vidéo</a></li>
            </ul>
        </li>
        <li><a href="#">Automobile</a>
            <ul>
                <li><a href="#">Voitures</a></li>
                <li><a href="#">Motos</a></li>
                <li><a href="#">Vélos</a></li>
                <li><a href="#">Pièces</a></li>
            </ul>
        </li>
        <li><a href="#">Autres</a></li>
    </ul>
</div>
</body></html>
