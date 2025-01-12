<?php
include '../auth/db.php';

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Vérification et récupération sécurisée des données du formulaire
    $name = isset($_POST['titreprod']) ? htmlspecialchars(trim($_POST['titreprod'])) : '';
    $price = isset($_POST['prix']) ? floatval($_POST['prix']) : 0;
    $pricep = isset($_POST['prix_promo']) ? floatval($_POST['prix_promo']) : 0;
    $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : '';
    $nom_vendeur = isset($_POST['nom_vendeur']) ? htmlspecialchars(trim($_POST['nom_vendeur'])) : '';
    $etat = isset($_POST['etat']) ? intval(trim($_POST['etat'])) : 0; 
    $whatsapp = isset($_POST['whatsapp']) ? htmlspecialchars(trim($_POST['whatsapp'])) : '';

    // Validation des champs obligatoires
    if (empty($name) || $price <= 0 || empty($description) || empty($nom_vendeur) || empty($etat) || empty($whatsapp)) {
        echo "<script>alert('Veuillez remplir tous les champs obligatoires correctement.');</script>";
    } else {
        // Vérification de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = "../images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);  // Crée le dossier si il n'existe pas
            }

            // Récupérer l'extension du fichier image
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            // Vérifier l'extension du fichier
            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                echo "<script>alert('Format de fichier non valide.');</script>";
                exit;
            }

            // Générer un nom de fichier unique
            $file_name = uniqid('product_', true) . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;

            // Déplacer le fichier téléchargé dans le répertoire de destination
            if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                // Ajouter le produit dans la base de données avec le statut "pending"
                $add_sql = "INSERT INTO produits (titreprod, prix, prix_promo, description, nom_vendeur, etat, whatsapp, image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($add_sql);
                $stmt->bind_param("sddssiss", $name, $price, $pricep, $description, $nom_vendeur, $etat, $whatsapp, $file_name);

                if ($stmt->execute()) {
                    echo "<script>alert('Produit ajouté avec succès.');</script>";
                } else {
                    echo "<script>alert('Erreur lors de l\'ajout du produit.');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Erreur lors du téléchargement de l\'image.');</script>";
            }
        } else {
            echo "<script>alert('Veuillez ajouter une image valide pour le produit.');</script>";
        }
    }
}

// Supprimer un produit
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Supprimer l'image associée
    $image_query = $conn->query("SELECT image FROM produits WHERE id = $delete_id");
    if ($image_query->num_rows > 0) {
        $image = $image_query->fetch_assoc()['image'];
        $image_path = "../images/" . $image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $delete_sql = "DELETE FROM produits WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Produit supprimé avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression du produit.');</script>";
    }
    $stmt->close();
}

// Récupérer tous les produits
$products = $conn->query("SELECT * FROM produits");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des produits</title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
</head>
<body>
    <header>
        <h1>Panneau d'administration</h1>
    </header>

    <div class="container">
        <!-- Section d'ajout de produit -->
        <div class="add-product-form">
            <h3>Ajouter un produit</h3>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="titreprod" placeholder="Nom du produit" required>
                <input type="number" step="0.01" name="prix" placeholder="Prix en FCFA" required>
                <input type="number" name="prix_promo" placeholder="Prix Promo">
                <input type="text" name="description" placeholder="Description du produit" required>
                <input type="text" name="nom_vendeur" placeholder="Nom du vendeur" required>
                <input type="number" name="etat" placeholder="Etat du produit /10" required>
                <input type="text" name="whatsapp" placeholder="Contact WHATSAPP du vendeur" required>
                <input type="file" name="image" accept=".jpg, .jpeg, .png" required>
                <button type="submit" name="add_product">Ajouter un produit</button>
            </form>
        </div><br><br>

        <!-- Section de gestion des produits -->
        <div class="product-management">
            <h2>Produits disponibles</h2><br>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du produit</th>
                        <th>Prix</th>
                        <th>Prix promo</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Nom du Vendeur</th>
                        <th>Etat du produit</th>
                        <th>WHATSAPP DU VENDEUR</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['titreprod']; ?></td>
                        <td><?php echo $row['prix']; ?> FCFA</td>
                        <td><?php echo $row['prix_promo']; ?> FCFA</td>
                        <td><img src="../images/<?php echo $row['image']; ?>" alt="Image produit" width="50"></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['nom_vendeur'];?></td>
                        <td><?php echo $row['etat'];?></td>
                        <td><?php echo $row['whatsapp'];?></td>
                        <td>
                            <a href="admin.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
       
       body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}
 
header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
}

h1 {
    font-size: 25px;text-transform : uppercase;font-weight: bold;
}

nav {
    display: flex;
    justify-content: center;
    background-color: #444;
    padding: 10px 0;
    position : sticky; 
}

nav a {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    margin: 0 10px;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav a:hover {
    background-color: #555;
}

/* Conteneur principal */
.container {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

.section {
    margin-bottom: 40px;
}

.section h2 {
    font-size: 19px;
    background-color: #333;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* Tableaux */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 15px;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

a {
    text-decoration: none;
}

a:hover { color : rgb(145, 18, 18);}
/* Boutons */
.btn {
    display: inline-block;
    padding: 10px 15px;
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

.btn.delete {
    background-color: #FF0000;
}

.btn.delete:hover {
    background-color: #cc0000;
}

/* Formulaires */
form {
    margin-top: 20px;
}

form input[type="text"],
form input[type="number"],
form input[type="file"],
form textarea {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

form button {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

form button:hover {
    background-color: #218838;
}

/* Responsive 
@media (max-width: 768px) {
    body {
        font-size: 14px;
    }

    nav {
        flex-direction: column;
    }

    nav a {
        margin-bottom: 10px;
    }

    table, th, td {
        font-size: 12px;
    }

    .btn {
        padding: 8px 12px;
        font-size: 12px;
    }
}

    </style>
</body>
</html>

<?php $conn->close(); ?>
<?php include '../includes/footer.php'; ?>
