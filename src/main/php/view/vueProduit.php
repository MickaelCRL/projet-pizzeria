<!DOCTYPE html>
<html>

<head>
    <title>Produit</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>

<body>
    <?php include("../view/navigation.php"); ?>
    <main class="mainProduit">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include("../controller/controllerProduit.php");
        $listProduit = controllerProduit::getAllProduit();
        if ($listProduit->rowCount() > 0) {
            while ($row = $listProduit->fetch(PDO::FETCH_ASSOC)) {
                $idProduit = htmlspecialchars($row['idProduit']);
                $nomProduit = htmlspecialchars($row['nomProduit']);
                $prixProduit = controllerProduit::getPrixProduit($idProduit);
                echo "<div class='produit-container'>";
                echo "<p id='produit-title'>$nomProduit</p>";
                echo "<p class='produit-prix'>Prix : $prixProduit €</p>";
                echo "<div class='produit-details'>";
                // Afficher un bouton pour ajouter l'ingrédient
                echo "<form action='../actions/ajoutProduitPanier.php' method='post'>";
                echo "<input type='hidden' name='idProduit' value='$idProduit'>";
                echo "<input type='hidden' name='prixProduit' value='$prixProduit'>";
                echo "<button type='submit' id='order-button' >Ajouter au panier
                        <img src='../static/img/shop_icon.png' alt='Shop Icon' id='icon'>
                      </button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                if (isset($_GET['idProduit']) && $_GET['idProduit'] == $idProduit && isset($_GET['quantite'])) {
                    echo "<p class='confirmation'>Produit ajoutée au panier.</p>";
                }
            }
        } else {
            echo "<p class='erreur'>Aucun produit trouvé.</p>";
        }


        ?>
    </main>
    <?php include("../view/footer.html"); ?>
</body>

</html>