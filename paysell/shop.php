<?php include '../includes/header1.php'; ?>


<?php
// shop.php
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

// Récupération des produits
$query = "SELECT p.id, p.image, p.titreprod, p.prix, p.description 
        FROM produits p";
        $produits = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat -</title>
    <link rel="stylesheet" href="../includes/css/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body> <br><br>
    <main class="container">
        <aside class="sidebar">
            <h3>À la une</h3>
            <ul>
                <li><a href="#"><i class="fa fa-car"></i><i></i> Autos<br><span>Trouvez la voiture qui vous convient</span></a></li>
                <li><a href="#"><i class="fa-solid fa-shirt"></i> Vêtements<br><span>Trouvez les vêtements qui vous conviennent le mieux</span></a></li>
                <li><a href="#"><i class="fa-solid fa-droplet"></i> Cosmétiques<br><span>Trouvez les produits convenables, pour l'entretien de votre peau</span></a></li>
                <li><a href="#"><i class="fa-solid fa-house"></i> Maison et Jardin<br><span>Trouvez des maisons, personnalisez par des experts.</span></a></li>
                <li><a href="#"><i class="fa-solid fa-book"></i> Livres et Médias<br><span>LookBooks styles, développement personnel, Home design etc</span></a></li>
                <li><a href="#"><i class="fa fa-credit-card"></i> Paiement facile<br><span>Discuter, payer, livraison</span></a></li>

            </ul>
        </aside>

        <section class="products">
            <h3>> &nbsp;Pour vous</h3><br>
            <div class="product-grid">
                <?php foreach ($produits as $produit): ?>
                <div class="product">
                    <img src="../images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['titreprod']) ?>">
                    <p class="title"><?= htmlspecialchars($produit['titreprod']) ?></p>
                    <p class="price"><?= floatval($produit['prix']) ?> FCFA</p><br>
                    <a href="../public/descrip_prod.php?id=<?= $produit['id'] ?>"> Voir l'article </a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html><br><br><br>

<?php include '../includes/footer.php';?>
