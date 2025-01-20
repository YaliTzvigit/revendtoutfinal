

<!-- Gestion des users -->

<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'revendtbd';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des statistiques
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['stats'])) {
    // Nombre total d'inscriptions
    $totalQuery = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
    $totalUsers = $totalQuery->fetch(PDO::FETCH_ASSOC)['total_users'];

    // Inscriptions par jour
    $dailyQuery = $pdo->query("
        SELECT DATE(created_at) AS date, COUNT(*) AS count
        FROM users
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at) DESC
    ");
    $dailyStats = $dailyQuery->fetchAll(PDO::FETCH_ASSOC);

    // Résultat JSON
    echo json_encode([
        'total_users' => $totalUsers,
        'daily_stats' => $dailyStats
    ]);
}

 // afficher les infos 

// Récupérer les statistiques
$stats = json_decode(file_get_contents('http://localhost/REVENDTOUT/userprofile/userstats.php=true'), true);

// Affichage
echo "<h2>Statistiques d'inscription</h2>";
echo "<p>Total des utilisateurs inscrits : " . $stats['total_users'] . "</p>";

echo "<h3>Inscriptions par jour :</h3>";
echo "<ul>";
foreach ($stats['daily_stats'] as $day) {
    echo "<li>" . $day['date'] . " : " . $day['count'] . " inscriptions</li>";
}
echo "</ul>";



?>

