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
        if (isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include("../controller/controllerProduit.php");
        // Bouton pour créer un produit
        echo "<div style='text-align: center; padding: 20px;'>";
        echo "<a href='vueCreationProduit.php' style='text-align:center;'>";
        echo "<button type='submit' id='order-button' >Créer un produit
                    <img src='../static/img/+.png' alt='Add Icon' id='icon'/> </button>";
        echo "</a>";
        echo "</div>";
        $listProduit = controllerProduit::getAllProduit();
        if ($listProduit->rowCount() > 0) {
            while ($row = $listProduit->fetch(PDO::FETCH_ASSOC)) {
                $idProduit = htmlspecialchars($row['idProduit']);
                $nomProduit = htmlspecialchars($row['nomProduit']);
                $prixProduit = controllerProduit::getPrixProduit($idProduit);
                $lienImage = htmlspecialchars($row['lienImage']);
                echo "<div class='produit-container'>";
                echo "<p id='produit-title'>$nomProduit</p>";
                echo "<img src='../static/$lienImage' alt='Pizza' class='pizza-image' height=100px width=100px>";
                echo "<p class='produit-prix'>Prix : $prixProduit €</p>";
                echo "<div class='produit-details'>";
                echo "<form action='../actions/supprimerProduit.php' method='post'>";
                echo "<input type='hidden' name='idProduit' value='$idProduit'/>";
                echo "<button type='submit' id='order-button' >Supprimer ce produit";
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
    }
    else{
        header("Location: ../view/vueAccueil.php");
    }

        ?>
    </main>
    <?php include("../view/footer.html"); ?>
</body>

</html>