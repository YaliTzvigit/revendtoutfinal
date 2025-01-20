<!-- page d'accueil -->

<?php include '../includes/header.php'; 
      include '../auth/db.php';
?>

<br><br>

<!-- Page de chargement 
<div id="loader" class="loader">
     Animation de chargement (spinner) 
</div> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur votre site!</title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <style>
            .whatsapp-icon {
            position: fixed;
            bottom: 20px;
            left: 20px;
            font-size: 3rem;
            color: #25d366;
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out; /* Effets de transition */
        }

        .whatsapp-icon:hover {
            transform: scale(1.1); /* Agrandissement léger */
            color: #1ebe57; /* Change légèrement la couleur */
            cursor: pointer;
        }
        </style>

<body><br>

    <p> Revendtout. Votre plateforme pour acheter et revendre facilement.</p> <br> <br> <br>

    <div class="container">
        <h1>Découvre les meilleurs produits</h1>
        <p>Trouvez les articles qui vous conviennent.</p>
        
        <div class="grid">

            <div class="card">
                <img src="../images/achat.jpg" alt="Vector PSD 1">
                <h3>Le plaisir d'acheter</h3>
                <a href="../paysell/shop.php"><button>Acheter maintenant</button></a>
            </div>

            <div class="card">
                <img src="../images/scanme.jpg" alt="Vector PSD 2">
                <h3>Paiement Facile</h3>
                <a href="../includes/toutsavoir.php"><button>Comment payer ?</button></a>
            </div>

            <div class="card">
                <img src="../images/selling.jpg" alt="Vector PSD 3">
                <h3>Vendez vos artciles que vous n'utilisez plus!</h3>
                <a href="../includes/toutsavoir.php"><button>Découvrir maintenant</button>
            </div>

            <div class="card">
                <img src="../images/bestsale.jpg" alt="Vector PSD 4">
                <h3>Offres exclusives</h3>
                <button>Voir plus</button>
            </div>
        </div>
    </div>
    <br><br><br><br><br>

    <section class="grid-section" id="about">
        <div class="grid-item">
                <img src="../images/nous.png" alt="">
            </div>
            <div class="gridtxt">
                <h4> QUI SOMMES-NOUS ? </h4>
                <legend>
                Revendtout ! Fondée en 2024, notre entreprise est spécialisée dans la revente de produits divers, allant de l'électronique aux articles pour la maison, en passant par les automobiles et les cosmétiques. 
                Notre mission est de vous offrir une plateforme fiable et conviviale pour acheter et vendre des articles de qualité à des prix compétitifs.
                Nous nous engageons à offrir une expérience client exceptionnelle, avec un service personnalisé et des transactions sécurisées. Notre vision est de devenir le leader incontesté du marché de la revente en ligne, 
                en bâtissant une communauté de clients et de vendeurs satisfaits et fidèles.
            </legend>
            </div>
    </section>

    <section class="grid-section" id="about">
        <div class="gridtxt">
            <h4> NOTRE VISION </h4>
            <legend>
            Chez Revendtout, nous aspirons à révolutionner le marché de la revente en ligne. 
            Nous souhaitons devenir le premier choix pour les consommateurs à la recherche de produits de qualité à des prix compétitifs. 
            En bâtissant une plateforme transparente, sécurisée et conviviale, nous nous engageons à faciliter chaque transaction et à promouvoir la durabilité par la réutilisation des biens.
            Notre objectif est de créer une communauté dynamique de vendeurs et d'acheteurs qui partagent nos valeurs de confiance, 
            d'intégrité et d'innovation. En embrassant les technologies de pointe et en restant attentifs aux besoins de nos clients, nous nous efforçons de repousser les limites pour offrir une expérience client exceptionnelle.
        </div>
        <div class="grid-item">
            <img src="../images/VISION.jpg" alt="">
        </div>
    </section> <br><br><br><BR>

    <p> Témoignages des clients :  </p>

    <div class="testimonial-section">
        <div class="testimonials" id="testimonialSlider">
            <div class="testimonial">
                <p>"Revendtout m'a permis de vendre mes produits rapidement et facilement ! Je recommande à 100%."</p>
                <h3>- Agbatou Alex</h3>
            </div>
            <div class="testimonial">
                <p>"Une expérience utilisateur incroyable. Merci à Revendtout pour ce service génial !"</p>
                <h3>- Kouamé A.</h3>
            </div>
            <div class="testimonial">
                <p>"Grâce à Revendtout, j'ai trouvé des acheteurs pour mes articles en un rien de temps."</p>
                <h3>- Alain B.</h3>
            </div>
        </div>
        <div class="controls">
            <button id="prev">&#8249;</button>
            <button id="next">&#8250;</button>
        </div>
    </div>

<script>
    /* animation fade In */ 

    const container = document.querySelector('.container');
    if (container) {
        container.classList.add('animation-right');
    }

    const gridsection = document.querySelector('.grid-section');
    if (gridsection) {
        gridsection.classList.add('animation-left');
    }

    // Témoignages script 

    const testimonials = document.getElementById('testimonialSlider');
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        const testimonialCount = testimonials.children.length;
        let currentIndex = 0;

        function updateSlider(index) {
            const offset = -index * 100;
            testimonials.style.transform = `translateX(${offset}%)`;
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % testimonialCount;
            updateSlider(currentIndex);
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + testimonialCount) % testimonialCount;
            updateSlider(currentIndex);
        }

        // Automatic sliding
        setInterval(showNext, 5000);

        // Button controls
        nextButton.addEventListener('click', showNext);
        prevButton.addEventListener('click', showPrev);

</script>
<a href="https://wa.me/2250788729838" target="_blank" class="whatsapp-icon">
    <i class="fab fa-whatsapp"></i>
</a>
</body>
</html>     <br><br><br><br><br>


<?php include '../includes/footer.php'; ?>

