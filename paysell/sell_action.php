
<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'revendtbd';
$username = 'root';
$password = ''; // empty

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification des données soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['titreprod']) ? htmlspecialchars(trim($_POST['titreprod'])) : '';
    $price = isset($_POST['prix']) ? floatval($_POST['prix']) : 0;
    $pricep = isset($_POST['prix_promo']) ? floatval($_POST['prix_promo']) : 0;
    $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : '';
    $imageDir = '../images/';
    $uploadedImages = [];

    // Validation des champs
    if (empty($name) || empty($price) || empty($pricep) || empty($description)) {
        die("Veuillez remplir tous les champs requis.");
    }

    // Validation des fichiers téléchargés
    if (isset($_FILES['addphoto']) && count($_FILES['addphoto']['name']) > 0) {
        foreach ($_FILES['addphoto']['name'] as $key => $name) {
            $tmpName = $_FILES['addphoto']['tmp_name'][$key];
            $error = $_FILES['addphoto']['error'][$key];
            $size = $_FILES['addphoto']['size'][$key];

            // Vérification des erreurs
            if ($error !== UPLOAD_ERR_OK) {
                die("Erreur lors de l'upload de l'image : $name.");
            }

            // Vérification de la taille du fichier (limité à 5 Mo)
            if ($size > 5 * 1024 * 1024) {
                die("Le fichier $name est trop volumineux (limite : 5 Mo).");
            }

            // Génération d'un nom de fichier unique
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '.' . $ext;

            // Déplacement du fichier
            if (move_uploaded_file($tmpName, $imageDir . $uniqueName)) {
                $uploadedImages[] = $uniqueName;
            } else {
                die("Échec du téléchargement de l'image : $name.");
            }
        }
    }

    // Insertion dans la base de données
    try {
        $stmt = $pdo->prepare("
            INSERT INTO produits (image, titreprod, prix, prix_promo, description)
            VALUES (:name, :price, :pricep, :images, :description)
        ");

        $stmt->execute([
            ':title' => $name,
            ':description' => $price,
            ':category' => $pricep,
            ':price' => $price,
            ':images' => json_encode($uploadedImages) // Stocker les noms des fichiers sous forme de JSON
        ]);

        echo "Article ajouté avec succès !";
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de l'article : " . $e->getMessage());
    }
} else {
    echo "Requête invalide.";
}
?>
