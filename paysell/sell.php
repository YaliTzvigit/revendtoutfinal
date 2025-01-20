
<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendre un article</title>
    <link rel="stylesheet" href="../includes/css/glbstyles.css">
    <link rel="stylesheet" href="../includes/css/sell.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<section class="header">
    <a href="../public/index.php" class="logo">REVENDTOUT</a>
    <nav class="nav" id="navbar">
        <a href="../public/index.php">< &nbsp; Retour à l'accueil</a>
        <a href="../paysell/shop.php">ACHETER</a>
        <a href="">NOUS</a>
        <a href="" class="whatsapp">WHATSAPP</a>
        <?php if (isset($_SESSION['user_name'])): ?>
                <!-- Si l'utilisateur est connecté -->
                <span class="user">
                    <a href="../userprofile/profile.php"><i class="fas fa-user-circle"></i> &nbsp; </a> 
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <a href="../auth/logout.php">Se déconnecter</a>
        <?php else: ?>
                <!-- Si l'utilisateur est déconnecté -->
                <a href="../userprofile/profile.php">S'inscrire | Se connecter</a>
        <?php endif; ?>
    </nav>
</section>

<br><br> <br>

<!-- vente formulaire -->
<h1> &nbsp;&nbsp; > &nbsp; Vendre son article </h1> <h1> &nbsp;&nbsp; < &nbsp; <a href="../paysell/shop.php">Revenir à la boutique  </h1> <br><br>
<form action="" method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="photo-upload">
            <p>Ajoutez jusqu'à 5 photos. <a href="../includes/toutsavoir.php">Comment faire ?</a></p> <br>
            <input type="file" name="addphoto[]" id="addphoto" accept="image/*" multiple style="display: none;">
            <div id="image-preview" class="image-preview"></div>
            <button type="button" id="add-more" class="add-photo-btn">+ Ajouter des photos</button>
        </div>

        <div class="form-section">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" placeholder="ex : Chemise Sézane Verte" required>
        </div>
        <div class="form-section">
            <label for="description">Décris ton article</label>
            <textarea id="description" name="description" placeholder="ex : Chemise Velours 100% friperie, porté une semaine..." required></textarea>
        </div>
        <div class="form-section">
            <label for="category">Catégorie</label>
            <select id="category" name="category" required>
                <option value="">Sélectionne une catégorie</option>
                <option value="electronique">Électronique</option>
                <option value="mode">Mode</option>
                <option value="cosmetique">Cosmétique</option>
                <option value="maison">Maison et Jardin</option>
                <option value="loisirs">Loisirs et Sport</option>
                <option value="livres">Livres et Médias</option>
                <option value="automobile">Automobile</option>
                <option value="autres">Autres</option>
            </select>
        </div>
        <div class="form-section">
            <label for="price">Prix</label>
            <input type="number" id="price" name="price" placeholder="0,00 F" step="0.01" required>
        </div>
    </div> <br>

    <div class="btn-savereset">
        <button type="submit">Ajouter</button>
    </div>
</form>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const maxImages = 5;
    let currentImageCount = 0;

    const addPhotoInput = document.getElementById("addphoto");
    const imagePreviewDiv = document.getElementById("image-preview");
    const addMoreButton = document.getElementById("add-more");

    addMoreButton.addEventListener("click", () => {
      addPhotoInput.click();
    });

    // Gérer les images sélectionnées
    addPhotoInput.addEventListener("change", (event) => {
      const files = event.target.files;

      for (let file of files) {
        if (currentImageCount >= maxImages) {
          alert("Vous ne pouvez ajouter que jusqu'à 5 photos.");
          return;
        }

        const reader = new FileReader();
        reader.onload = function () {
          const imgWrapper = document.createElement("div");
          imgWrapper.className = "preview-img-wrapper";

          const img = document.createElement("img");
          img.src = reader.result;
          img.style.maxWidth = "100px";
          img.style.height = "auto";

          const deleteButton = document.createElement("button");
          deleteButton.textContent = "X";
          deleteButton.className = "delete-btn";
          deleteButton.addEventListener("click", () => {
            imagePreviewDiv.removeChild(imgWrapper);
            currentImageCount--;
          });

          imgWrapper.appendChild(img);
          imgWrapper.appendChild(deleteButton);
          imagePreviewDiv.appendChild(imgWrapper);

          currentImageCount++;
        };

        reader.readAsDataURL(file);
      }

      addPhotoInput.value = ""; // Permet de recharger les mêmes fichiers si besoin
    });
  });
</script>
</body>
</html> <br><br><br><br>

<?php include '../includes/footer.php'; ?>
