

<?php include '../includes/header.php'; ?><br>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revendtbd";

$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$code = $_GET['code'] ?? null;

if ($code) {
    $sql = "SELECT * FROM users WHERE validation_code = :code AND code_expiration >= NOW() AND is_active = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':code', $code, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Activer le compte
        $updateSql = "UPDATE users SET is_active = 1, validation_code = NULL WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
        $updateStmt->execute();

        echo "Votre compte a été activé avec succès ! <a href='connexion.php'>Connectez-vous ici.</a>";
    } else {
        echo "Lien invalide ou expiré.";
    }
} else {
    echo "Aucun code fourni.";
}
?>
