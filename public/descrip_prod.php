
<?php include '../includes/header1.php'; ?> <br>



<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'revendtbd';
$user = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID du produit depuis l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Produit non spécifié.");
}

$id = intval($_GET['id']);

// Récupérer les détails du produit
$query = "SELECT * FROM produits WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$produit = $stmt->fetch(PDO::FETCH_ASSOC);
$numero_whatsapp = '+225' . $produit['whatsapp_seller']; // Numéro reconnue


if (!$produit) {
    die("Produit introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Description du produit</title>
    <link rel="stylesheet" href="../includes/css/description.css" type="text/css">
    <!-- cdjns font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css">
    <style>
        /* description.css */
    </style>
</head>
<body>
<a href="../paysell/shop.php" class="backtoshop"> < &nbsp; Retour à la boutique </a>
    <div class="container">
        <blockquote><i> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Note importante : Veuillez examiner attentivement ces produits avant de passer votre commande. Les retours ne seront pas acceptés après reception d'article. Merci de votre compréhension.</i></blockquote><br>
        <div class="headup">
            <h1><?= htmlspecialchars($produit['titreprod']) ?></h1>
            <span>Posté le : <?php echo date('d/m/Y'); ?></span>
            </div>
        <div class="content">
            <div class="image-section">
                <img src="../images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['titreprod']) ?>">
            </div>
            <div class="details">
                <p class="price"><?= floatval($produit['prix']) ?> FCFA</p>
                <p class="info">Description : <?= htmlspecialchars($produit['description']) ?></p>
                <p class="etat">État du produit : <?= intval($produit['etat']) ?>/10</p>
                <div class="seller-info">
                    <h2><i class="fa-solid fa-user"></i>&nbsp;&nbsp; Informations sur le vendeur</h2>
                    <p>Nom de l'entreprise/vendeur : <?= htmlspecialchars($produit['nomvendeur']) ?></p>
                    <p><i class="fa-solid fa-location-dot"></i> &nbsp;<?= htmlspecialchars($produit['localisation']) ?></p>
                </div>
                <div class="actions">
                    <a href="https://wa.me/<?= htmlspecialchars($produit['whatsapp_seller']) ?>?text=<?= urlencode("Bonjour, je suis intéressé par votre article : " . $produit['titreprod'] . ". Veuillez me donner plus de détails.") ?>" target="_blank">
                        <button>Contacter le vendeur</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html><br><br>


<?php include '../includes/footer.php';?>
