


<!-- Modifier un produit -->


<?php
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

// Récupérer l'ID du produit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Récupérer les informations du produit à modifier
    $query = "SELECT * FROM produits WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        die("Produit introuvable !");
    }
} else {
    die("Aucun produit sélectionné.");
}

// Mettre à jour le produit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titreprod = $_POST['titreprod'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $etat = $_POST['etat'];
    $nomvendeur = $_POST['nomvendeur'];
    $localisation = $_POST['localisation'];
    $whatsapp_seller = $_POST['whatsapp_seller'];

    // Validation du numéro WhatsApp
    if (!str_starts_with($whatsapp_seller, '+225')) {
        $whatsapp_seller = '+225' . ltrim($whatsapp_seller);
    }

    // Mettre à jour les données dans la base
    $query_update = "UPDATE produits 
                     SET titreprod = :titreprod, prix = :prix, description = :description, etat = :etat,
                         nomvendeur = :nomvendeur, localisation = :localisation, whatsapp_seller = :whatsapp
                     WHERE id = :id";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->bindParam(':titreprod', $titreprod);
    $stmt_update->bindParam(':prix', $prix);
    $stmt_update->bindParam(':description', $description);
    $stmt_update->bindParam(':etat', $etat);
    $stmt_update->bindParam(':nomvendeur', $nomvendeur);
    $stmt_update->bindParam(':localisation', $localisation);
    $stmt_update->bindParam(':whatsapp', $whatsapp_seller);
    $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        header("Location: ../admin/admin.php?message=Produit mis à jour avec succès");
        exit;
    } else {
        echo "Erreur lors de la mise à jour du produit.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit</title>
    <link rel="stylesheet" href="../includes/css/admin.css">
</head>
<body>
    <h1>Modifier le produit</h1>
    <form method="POST">
        <label for="titreprod">Titre du produit :</label>
        <input type="text" name="titreprod" id="titreprod" value="<?= htmlspecialchars($produit['titreprod']) ?>" required><br>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" id="prix" value="<?= floatval($produit['prix']) ?>" required><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="7" required><?= htmlspecialchars($produit['description']) ?></textarea><br>

        <label for="etat">État :</label>
        <input type="number" name="etat" id="etat" value="<?= intval($produit['etat']) ?>" required><br>

        <label for="nomvendeur">Nom du vendeur :</label>
        <input type="text" name="nomvendeur" id="nomvendeur" value="<?= htmlspecialchars($produit['nomvendeur']) ?>" required><br>

        <label for="localisation">Localisation :</label>
        <input type="text" name="localisation" id="localisation" value="<?= htmlspecialchars($produit['localisation']) ?>" required><br>

        <label for="whatsapp_seller">Numéro WhatsApp :</label>
        <input type="text" name="whatsapp_seller" id="whatsapp_seller" value="<?= htmlspecialchars($produit['whatsapp_seller']) ?>" required><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>


