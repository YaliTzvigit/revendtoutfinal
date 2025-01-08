<?php
include '../includes/header1.php';

// Récupération des paramètres envoyés
if (isset($_GET['title'])) {
    $product_title = urldecode($_GET['title']);
} else {
    echo "Aucun article sélectionné.";
    exit;
}

// Simulation de récupération des données du produit basé sur le titre
$products = [
    'OLDSCHOOL VANS PG' => [
        'description' => "Les chaussures OldSchool Vans PG sont idéales pour les amateurs de style vintage.",
        'image' => '../images/_3 Vans.jpeg',
        'price' => '25,00 €',
        'promo_price' => null,
    ],
    'T BAG 21 Nov.' => [
        'description' => "Sac pratique et élégant, parfait pour vos journées chargées.",
        'image' => '../images/bag2.jpeg',
        'price' => '22,00 €',
        'promo_price' => null,
    ],
    'SEBACO OLD 70S' => [
        'description' => "Mocassin en cuir véritable, cousu à la main avec une semelle robuste en caoutchouc. Design classique et décontracté, souvent dans des teintes comme le marron ou le bleu marine. Confortable, durable, et emblématique du style nautique chic.",
        'image' => '../images/SEBACO IV.jpeg',
        'price' => '40,00 €',
        'promo_price' => null,
    ],
    'CAMERA CANON' => [
        'description' => "Un appareil photo performant offrant une excellente qualité d'image. Disponible en versions reflex, hybrides ou compactes, il est équipé d'un capteur avancé, d'un autofocus rapide et de commandes intuitives. Idéal pour capturer des moments avec précision, que ce soit en photo ou en vidéo.",
        'image' => '../images/Canon G7X Mark ii.jpeg',
        'price' => '40,00 €',
        'promo_price' => '50,00 €',
    ],
    'Bombers WEATHER' => [
        'description' => "Un vêtement qui combine l’élégance décontractée d’un bomber avec le confort d’un pull.",
        'image' => '../images/BOMBERS.jpeg',
        'price' => '25,00 €',
        'promo_price' => '45,00 €',
    ],
];

$product = $products[$product_title] ?? null;

if (!$product) {
    echo "Ce produit n'existe pas.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product_title) ?></title>
    <link rel="stylesheet" href="../public/stylesall.css">
</head>
<body>
    <div class="product-page">
        <header>
            <a href="../paysell/shop.php" class="btn-back">< &nbsp;Retour à la boutique</a><br>
            <h1><?= htmlspecialchars($product_title) ?></h1>
        </header>
        <main>
            <div class="product-details">
                <!-- Colonne gauche : image du produit -->
                <div class="product-image">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product_title) ?>">
                </div>
                
                <!-- Colonne droite : informations détaillées -->
                <div class="product-info">
                    <p><strong>Prix :</strong> <?= htmlspecialchars($product['price']) ?></p>
                    <?php if ($product['promo_price']): ?>
                        <p><strong>Prix promo :</strong> <?= htmlspecialchars($product['promo_price']) ?></p>
                    <?php endif; ?>
                    <p><strong>Description :</strong> <?= htmlspecialchars($product['description']) ?></p>
                    
                    <!-- Informations sur le vendeur -->
                    <div class="vendor-info">
                        <p><strong>Vendeur :</strong> fanny</p>
                        <p>2 mois actif sur REVENDTOUT</p>
                        <p>1 mois expérience</p>
                        <p>
                            Etat : <span>7/10</span>
                        </p>
                        <a href="https://wa.me/0788729838" target="_blank" class="btn-save">Contactez le vendeur</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<br><br>

<?php include '../includes/footer.php'; ?>
