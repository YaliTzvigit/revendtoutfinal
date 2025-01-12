<?php
include '../includes/header1.php';
include '../auth/db.php';

// Récupération des paramètres envoyés
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
} else {
    echo "Aucun article sélectionné.";
    exit;
}

// Récupérer les détails du produit depuis la base de données
$sql = "SELECT * FROM produits WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    $vendeur_id = $product['vendeur_id']; // Récupérer l'ID du vendeur
} else {
    echo "Produit non trouvé.";
    exit;
}

// Récupérer les informations du vendeur
$sql_vendeur = "SELECT * FROM vendeurs WHERE id = ?";
$stmt_vendeur = $conn->prepare($sql_vendeur);
$stmt_vendeur->bind_param("i", $vendeur_id);
$stmt_vendeur->execute();
$result_vendeur = $stmt_vendeur->get_result();

if ($result_vendeur->num_rows > 0) {
    $vendeur = $result_vendeur->fetch_assoc();
} else {
    $vendeur = null;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['titreprod']) ?></title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
</head>
<body>
    <div class="product-page">
        <header>
            <a href="../paysell/shop.php" class="btn-back">< &nbsp;Retour à la boutique</a><br>
            <h1><?= htmlspecialchars($product['titreprod']) ?></h1>
        </header>
        <main>
            <div class="product-details">
                <!-- Colonne gauche : image du produit -->
                <div class="product-image">
                    <img src="../images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['titreprod']) ?>">
                </div>
                
                <!-- Colonne droite : informations détaillées -->
                <div class="product-info">
                    <p><strong>Prix :</strong> <?= htmlspecialchars($product['prix']) ?> FCFA</p>
                    <?php if ($product['prix_promo']): ?>
                        <p><strong>Prix promo :</strong> <?= htmlspecialchars($product['prix_promo']) ?> FCFA</p>
                    <?php endif; ?>
                    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    
                    <!-- Informations sur le vendeur -->
                    <?php if ($vendeur): ?>
                        <div class="vendor-info">
                            <p><strong>Vendeur :</strong> <?= htmlspecialchars($vendeur['nom_vendeur']) ?></p>
                            <p>Etat : <span><?= htmlspecialchars($vendeur['etat']) ?>/10</span></p>
                            <a href="https://wa.me/<?= htmlspecialchars($vendeur['whatsapp']) ?>" target="_blank" class="btn-save">Contactez le vendeur</a>
                        </div>
                    <?php else: ?>
                        <p>Vendeur non trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<br><br>

<?php include '../includes/footer.php'; ?>
