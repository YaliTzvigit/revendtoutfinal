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

// Ajout d'un produit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Vérification de l'extension de l'image (facultatif)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_ext)) {
            echo "Format d'image non valide !";
        } else {
            // Générer un nom unique pour le fichier 
            $imagename = 'up_' . time() . '.' . $file_ext;

            // Vérifier si le répertoire "uploads" existe, sinon le créer
            $upload_dir = '../images/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Créer le dossier "uploads" s'il n'existe pas
            }

            // Déplacer l'image dans le dossier "uploads"
            $image_path = $upload_dir . basename($imagename);
            if (move_uploaded_file($image_tmp, $image_path)) {
                $titreprod = $_POST['titreprod'];
                $prix = $_POST['prix'];
                $description = $_POST['description'];
                $nomvendeur = $_POST['nomvendeur'];
                $numwhatsapp = $_POST['whatsapp_seller'];
                $localisation = $_POST['localisation'];
                $etat = $_POST['etat'];

                // Validation et formatage du numéro WhatsApp
                if (!str_starts_with($numwhatsapp, '+225')) {
                    $numwhatsapp = '+225' . ltrim($numwhatsapp);
                }

                // Insertion du produit dans la base de données
                $stmt = $pdo->prepare("INSERT INTO produits (image, titreprod, prix, description, etat, nomvendeur, localisation, whatsapp_seller) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$imagename, $titreprod, $prix, $description, $etat, $nomvendeur, $localisation, $numwhatsapp]);

                echo "Produit ajouté.";
                header('Location: admin.php');
                exit;
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
    } else {
        echo "Aucune image téléchargée ou erreur d'image.";
    }
}

// Suppression d'un produit
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $query_image = "SELECT image FROM produits WHERE id = :id";
    $stmt_image = $pdo->prepare($query_image);
    $stmt_image->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_image->execute();

    $image_data = $stmt_image->fetch(PDO::FETCH_ASSOC);
    if ($image_data && file_exists("../uploads/" . $image_data['image'])) {
        unlink("../uploads/" . $image_data['image']);
    }

    $query_delete = "DELETE FROM produits WHERE id = :id";
    $stmt_delete = $pdo->prepare($query_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);

    if ($stmt_delete->execute()) {
        header("Location: admin.php?message=Produit supprimé avec succès");
        exit(); 
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
}

// Récupération des produits
$query = "SELECT p.id, p.image, p.titreprod, p.prix, p.description, p.etat, p.nomvendeur, p.localisation, p.whatsapp_seller
          FROM produits p";
$produits = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Produits</title>
    <link rel="stylesheet" href="../includes/css/admin.css">
</head>
<body>
    <header>
        <div class="titread">&copy; L'administrateur</div>
        <nav>
            <a href="">Mon compte</a> 
            <a href="">Messages</a>
            <a href="">Paramètres</a> 
        </nav>
    </header>
    <br><br>
    <div class="container">
        <h1>Administration des Produits</h1><br>

        <!-- Formulaire pour ajouter un produit -->
        <form action="../admin/admin.php" method="POST" enctype="multipart/form-data">
            <label for="image">Image :</label>
            <input type="file" name="image" id="image" required><br>
            
            <label for="titreprod">Titre du produit :</label>
            <input type="text" name="titreprod" id="titreprod" required><br>
            
            <label for="prix">Prix :</label>
            <input type="number" name="prix" id="prix" required><br>
            
            <label for="description">Description :</label>
            <textarea name="description" id="description" rows="7" maxlength="255" required></textarea><br>

            <label for="etat">État :</label>
            <input type="number" id="etat" name="etat" required><br>

            <label for="nomvendeur">Nom du vendeur :</label>
            <input type="text" name="nomvendeur" id="nomvendeur" required><br>

            <label for="localisation">Localisation :</label>
            <input type="text" name="localisation" id="localisation" required><br>
            
            <label for="whatsapp_seller">Numéro WhatsApp du vendeur :</label>
            <input type="text" name="whatsapp_seller" id="whatsapp_seller" required><br>

            <button type="submit">Ajouter le produit +</button>
        </form>

        <br><br>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>État</th>
                    <th>Nom du vendeur</th>
                    <th>Localisation</th>
                    <th>Numéro WhatsApp du vendeur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit) : ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['id']) ?></td>
                        <td><img src="../uploads/<?= htmlspecialchars($produit['image']) ?>" alt="Image Produit"></td>
                        <td><?= htmlspecialchars($produit['titreprod']) ?></td>
                        <td><?= floatval($produit['prix']) ?> FCFA</td>
                        <td><?= htmlspecialchars($produit['description']) ?></td>
                        <td><?= intval($produit['etat']) ?>/10</td>
                        <td><?= htmlspecialchars($produit['nomvendeur']) ?></td>
                        <td><?= htmlspecialchars($produit['localisation']) ?></td>
                        <td><?= htmlspecialchars($produit['whatsapp_seller']) ?></td>
                        <td>
                            <a href="../includes/editprod.php?id=<?= $produit['id'] ?>" class="btn-edit">Modifier</a>
                            <a href="?delete_id=<?= $produit['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
