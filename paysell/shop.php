

<?php include '../includes/header1.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP.COM</title>
    <link rel="stylesheet" href="../public/stylesall.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
</head>
<body><br> <br> <br>
<div class="hr">
    <hr noshade>
</div>
<br> <br>
<p class="global">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-right"></i> &nbsp; Vue d'ensemble </p>
 <br> 
<body>

    <div class="product-grid">
        <?php
        // Liste des produits
        $products = [
            [
                'image' => '../images/_3 Vans.jpeg',
                'title' => 'OLDSCHOOL VANS PG',
                'price' => '25,00 €',
                'promo_price' => null
            ],
            [
                'image' => '../images/bag2.jpeg',
                'title' => 'T BAG 21 Nov.',
                'price' => '22,00 €',
                'promo_price' => null
            ],
            [
                'image' => '../images/SEBACO IV.jpeg',
                'title' => 'SEBACO OLD 70S',
                'price' => '40,00 €',
                'promo_price' => null
            ],
            [
                'image' => '../images/Canon G7X Mark ii.jpeg',
                'title' => 'CAMERA CANON',
                'price' => '40,00 €',
                'promo_price' => '50,00 €',
    
            ],

            [
                'image' => '../images/BOMBERS.jpeg',
                'title' => 'Bombers WEATHER',
                'price' => '25,00 €',
                'promo_price' => '45,00€',
            ],
            [
                'image' => '../images/patrol',
                'title' => 'NISSAN PATROL SVG',
                'price' => '85,000€',
                'promo_price' => null
            ],
            [
                'image' => '../images/Bluecap.jpeg',
                'title' => 'Blue VINTAGE CAP',
                'price' => '10,00€',
                'promo_price' => null
            ],
            [
                'image' => '../images/KIA.jpeg',
                'title' => 'KIA ELANTRA 2023',
                'price' => '20,500€',
                'promo_price' => null
            ],
            [
                'image' => '../images/CROCO.jpeg',
                'title' => 'CROCO sneak',
                'price' => '32,00€',
                'promo_price' => null
            ],
            [
                'image' => '../images/Going Places Totes.jpeg',
                'title' => 'STREETWEAR Totes BAG 21',
                'price' => '9,00€',
                'promo_price' => null
            ],

            [
                'image' => '../images/tablechair.jpg',
                'title' => 'Saloon Table chair',
                'price' => '150,00€',
                'promo_price' => '250,00€',
            ],
            [
                'image' => '../images/Macbook.jpg',
                'title' => 'PC MacBook Air 883s',
                'price' => '1320,00€',
                'promo_price' => null
            ],
            [
                'image' => '../images/etagere.jpg',
                'title' => 'ROOM shelves',
                'price' => '60,00€',
                'promo_price' => null
            ],
            [
                'image' => '../images/samsungtv.jpg',
                'title' => 'Samsung TV Galaxy',
                'price' => '300,00€',
                'promo_price' => null
            ],
            [
                'image' => '../images/Iphone-16.png',
                'title' => 'Apple Iphone 16',
                'price' => '1729,00€',
                'promo_price' => null
            ]

        ];

        $whatsapp_number = "0788729838";
        $product_taille = "M";

        foreach ($products as $product) {
            echo '<div class="product">';
            if (isset($product['badge'])) {
                echo '<div class="badge">'.$product['badge'].'</div>';
            }
            echo '<img src="'.$product['image'].'" alt="'.$product['title'].'">';
            echo '<h4>'.$product['title'].'</h4>';
            echo '<p class="price">'.$product['price'];
            if ($product['promo_price']) {
                echo '<span class="promo-price">'.$product['promo_price'].'</span>';
            }
            echo '</p>';
            // Bouton pour voir la description
            echo '<a href="../public/descrip_prod.php?title='.urlencode($product['title']).'" class="view-description">Voir l\'article</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
<br> <br> <br>

<?php include '../includes/footer.php'; ?>
