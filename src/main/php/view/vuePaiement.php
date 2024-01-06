<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de paiement</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/vuePaiement.css">
    <script src="../static/js/verifPaiement.js"></script>
</head>
<?php include("./navigation.php"); ?>

<body>
    <section>
        <h1 class="vuePaiement">Commande en ligne</h1>
    </section>
    <section>
        <div class="formulaire">

            <h3>Informations personnelles</h3>
            <form id="infos-personnelles" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom"
                    value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required><br><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom"
                    value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>"
                    required><br><br>
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse"
                    value="<?php echo isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : ''; ?>"><br><br>
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville"
                    value="<?php echo isset($_POST['ville']) ? htmlspecialchars($_POST['ville']) : ''; ?>"><br><br>
                <label for="code-postal">Code Postal :</label>
                <input type="text" id="code-postal" name="code-postal"
                    value="<?php echo isset($_POST['code-postal']) ? htmlspecialchars($_POST['code-postal']) : ''; ?>"><br><br>
                <button type="submit" name="enregistrer" onclick="event.preventDefault(); test2();">Enregistrer</button>
            </form>
        </div>
    </section>
    <?php
    include("../controller/controllerPizzeria.php");
    if (!empty($_POST['adresse']) || !empty($_POST['ville']) || !empty($_POST['code-postal'])) {
        if (empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code-postal'])) {
            echo "<script>alert('Veuillez renseigner une adresse complète pour la livraison. Rien pas de livraison.');</script>";
        } else {
            $destination = $_POST['adresse'] . ', ' . $_POST['ville'] . ', ' . $_POST['code-postal'] . ", France";
            $distance = controllerPizzeria::calculDistancePizzeria($destination);
            if ($distance > 30 || $distance == -1) {
                echo "<script>alert('Vous êtes trop loin veuillez renseigner une autre adresse $distance minutes');</script>";
            } else {
                echo "<script>alert('Enregistré $distance minutes');</script>";
            }
        }
    }
    ?>

    <section>
        <div class="recap-commande">
            <h2>Récapitulatif de la commande</h2>
            <?php
            require_once("../controller/controllerPizza.php");

            // Assurez-vous que $_SESSION['panier'] et $_SESSION['tabQuantite'] existent et ne sont pas vides
            if (!empty($_SESSION['panier']) && !empty($_SESSION['tabQuantite'])) {
                echo "<div class='recap-commande'>";

                // Parcourir le panier et afficher les détails de chaque pizza
                foreach ($_SESSION['panier'] as $idPizza) {
                    // Récupérer les détails de la pizza
                    $pizzaDetails = controllerPizza::getPizzaPanier($idPizza);
                    if ($pizzaDetails->rowCount() > 0) {
                        while ($row = $pizzaDetails->fetch(PDO::FETCH_ASSOC)) {
                            $nom = htmlspecialchars($row['nomPizza']);
                            $quantite = $_SESSION['tabQuantite'][$idPizza];
                            $prix = controllerPizza::getPrixPizza($idPizza);

                            // Afficher les détails de la pizza dans le récapitulatif de la commande
                            echo "<p>Nom de la pizza : $nom</p>";
                            echo "<p>Quantité : $quantite</p>";
                            echo "<p>Prix unitaire : $prix €</p>";
                            echo "<hr>"; // Ajouter une ligne pour séparer les pizzas
                        }
                    }
                }

                echo "</div>";
            }
            require_once("../controller/controllerProduit.php");

            // Vérifiez si $_SESSION['panierProduit'] et $_SESSION['tabQuantiteProduit'] existent et ne sont pas vides
            if (!empty($_SESSION['panierProduit']) && !empty($_SESSION['tabQuantiteProduit'])) {
                echo "<div class='recap-commande-produits'>";

                // Parcourez le panier des produits et affichez les détails de chaque produit
                foreach ($_SESSION['panierProduit'] as $idProduit) {
                    // Récupérer les détails du produit
                    $produitDetails = controllerProduit::getProduitPanier($idProduit);
                    if ($produitDetails->rowCount() > 0) {
                        while ($row = $produitDetails->fetch(PDO::FETCH_ASSOC)) {
                            $nomProduit = htmlspecialchars($row['nomProduit']);
                            $quantiteProduit = $_SESSION['tabQuantiteProduit'][$idProduit];
                            $prixProduit = controllerProduit::getPrixProduit($idProduit);

                            // Afficher les détails du produit dans le récapitulatif de commande
                            echo "<p>Nom du produit : $nomProduit</p>";
                            echo "<p>Quantité : $quantiteProduit</p>";
                            echo "<p>Prix unitaire : $prixProduit €</p>";
                            echo "<hr>"; // Ajouter une ligne pour séparer les produits
                        }
                    }
                }

                echo "</div>";
            }
            ?>
        </div>
        <?php

        if (isset($_POST['annuler'])) {
            header('Location: ../actions/viderPanier.php');
        }
        ?>
        <form method="post">
            <button type="submit" name="annuler">Annuler</button>
        </form>
    </section>
    <section>
        <h2>Choix du paiement</h2>
        <div class="choix-paiement">
            <button id="paiement-cash" onclick="selectPayment('Paiement à la caisse')">Paiement à la caisse</button>
            <button id="paiement-ligne" onclick="selectPayment('Paiement en ligne')">Paiement en ligne</button>
        </div>
    </section>

    <section>
        <button id="confirmer" onclick="test()">Confirmer la commande</button>
    </section>
</body>
<?php include("../view/footer.html"); ?>

</html>