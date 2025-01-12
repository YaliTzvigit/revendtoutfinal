
<!-- Configuration de la database -->  

<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revendtbd";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
} catch (PDOException $e) {
    // Gestion des erreurs
    die("Connexion échouée : " . $e->getMessage());
}
?>