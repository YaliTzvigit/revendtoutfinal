<?php include '../includes/header1.php'; ?>
<?php include '../auth/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP.COM</title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
</head>
<body>
<br> <br> <br>
<div class="hr">
    <hr noshade>
</div>
<br> <br>
<p class="global">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"></i> &nbsp; Vue d'ensemble </p>
<br> 

<div class="product-grid">
    <?php
    // Récupération des produits depuis la base de données
    $sql = "SELECT * FROM produits";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            echo '<div class="product">';
            echo '<img src="../images/'.$product['image'].'" alt="'.$product['titreprod'].'">';
            echo '<h4>'.$product['titreprod'].'</h4>';
            echo '<p class="price">'.$product['prix'].'€';
            if ($product['prix_promo']) {
                echo '<span class="promo-price">'.$product['prix_promo'].'€</span>';
            }
            echo '</p>';
            echo '<a href="../public/descrip_prod.php?id='.$product['id'].'" class="view-description">Voir l\'article</a>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucun produit disponible.</p>';
    }
    ?>
</div>

<br> <br> <br>
<?php include '../includes/footer.php'; ?>
