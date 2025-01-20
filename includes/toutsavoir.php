
<?php include '../auth/db.php'; 

session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre d'Aide - Revendtout</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../includes/css/aide.css">
</head>
<body id="content">
    <!-- Navbar -->
    <nav class="navbar" id="">
        <div class="logo">
            <a href="#">Revendtout</a>
        </div>
        <ul class="nav-links">
            <li><a href="../public/index.php">Accueil</a></li>
            <li><a href="../paysell/shop.php">Boutique</a></li>
            <li><a href="#helpcenter">Centre d'Aide</a></li>
            <li><a href="#footer">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="../auth/signup.php" class="btn">S'inscrire | Se connecter</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="help-center" id="helpcenter">
        <h1>CENTRE D'AIDE &nbsp; <i class="fa-regular fa-circle-question"></i></h1>
        <section class="help-section">
            <h2>Comment acheter un article ?</h2>
            <p>Pour acheter un article sur Revendtout, suivez ces étapes :</p>
            <ol>
                <li>Inscrivez-vous (si vous n'avez pas de compte) ou connectez-vous à votre compte.</li>
                <li>Parcourez les catégories ou utilisez la barre de recherche.</li>
                <li>Sélectionnez l'article souhaité, vérifiez les détails et cliquez sur <strong>"Contactez le vendeur"</strong>.</li>
                <li>Vous serez directement redirigé vers WhatsApp pour une discussion instantanée avec le vendeur.</li>
                <li>Suivez les instructions du vendeur pour finaliser le paiement et recevoir votre article.</li>
            </ol>
        </section>

        <section class="help-section">
            <h2>Comment vendre un article ?</h2>
            <p>Pour vendre un article sur Revendtout :</p>
            <ol>
                <li>Inscrivez-vous ou connectez-vous à votre compte.</li>
                <li>Accédez à votre tableau de bord et cliquez sur "Vendre un article".</li>
                <li>Téléchargez le ou les photos, remplissez le formulaire avec les détails de l'article.</li>
                <li>L'administrateur examinera votre article. Vous recevrez un message sur WhatsApp pour vous informer de l'approbation ou non de celui-ci. Si votre article est approuvé, il sera publié. Dans le cas contraire, aucune publication.</li>
            </ol>
        </section>

        <section class="help-section">
            <h2>Conditions Générales d'Utilisation</h2>
            <p>Veuillez lire attentivement les CGU avant d'utiliser notre plateforme :</p>
            <ul>
                <li>Les utilisateurs doivent fournir des informations exactes lors de leur inscription.</li>
                <li>Les articles publiés doivent respecter les lois et les règlements en vigueur.</li>
                <li>Revendtout se réserve le droit de supprimer toute annonce inappropriée.</li>
            </ul>
        </section><br><br>
        <h1> CONFIANCE ET SECURITE &nbsp; <i class="fa-solid fa-shield-halved"></i></h1>
        <section class="help-section">
            <h2>Garantie sur la fiabilité de la plateforme : </h2>
            <ul>
                <li><p> <strong> Transactions sécurisées : </strong> Les paiements se feront via les moyens de paiment WAVE/OM.</p> </li>
                <li><p> <strong> Authenticité des produits ou services : </strong> Les produits listés sur la plateforme respectent les normes ou ont été vérifiés.</p> </li>
                <li><p> <strong> Respect des conditions d'utilisation : </strong> Les politiques du site sont transparentes et respectent les lois.</p> </li>
            </ul><br><br>
            <h2> Protection des Données Personnelles : </h2>
            <ul>
                <li><p> <strong> Confidentialité des données : </strong> Respect strict des règlements sur la confidentialité </p></li>
                <li><p> Les données sensibles des utilisateurs (mots de passe...) sont protégées contre tout risque de vol. </p></li>
                <li><p> <strong> Consentement : </strong> Les utilisateurs doivent fournir des consentements pour utiliser les informations personnelles.</p></li>
        </section><br><br>
        <h1> PAIEMENT &nbsp; <i class="fa-regular fa-credit-card"></i> </h1>
        <section class="help-section">
            <h2> Comment procéder au paiement : </h2>
            <ul>
                <li><p> À l'heure actuelle, les paiements seront effectués via Wave et Mobile Money.</p></li>
                <li><p> Les paiements seront effectués directement entre les clients et les vendeurs. </p></li>
            </ul>
            <p>Pour plus de détails, consultez <a href="cgu.php">nos CGU</a>.</p>

        </section><br>
        <blockquote>NB : REVENDTOUT n'est pas responsable des conflits entre clients et vendeurs.</blockquote>
    </main> <br><br>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <p>&copy; 2025 REVENDTOUT.com. Tous droits réservés.</p>
        <p><i class="fa-solid fa-phone"></i> - 0788729838/0788942495 </p>
        <p><i class="fa-solid fa-envelope"></i> - stellardeals@gmail.com </p>
        <a href="#content"><p class="enhaut"> &nbsp; <i class="fa-solid fa-arrow-up">&nbsp; EN HAUT</i></p></a>
    </footer>

    <!-- script js -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Animation pour la barre de navigation
        const navbar = document.querySelector(".navbar");
        if (navbar) {
            navbar.classList.add("animate-top");
        }

        // Animation pour le Help Center
        const helpCenter = document.querySelector(".help-center");
        if (helpCenter) {
            helpCenter.classList.add("animate-right");
        }

        // Animation pour le footer
        const footer = document.querySelector(".footer");
        if (footer) {
            footer.classList.add("animate-bottom");
        }
    });
</script>


</body>
</html>
