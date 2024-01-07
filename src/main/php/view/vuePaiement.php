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
            <h2>Informations personnelles</h2>
            <form id="infos-personnelles" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse"
                    value="<?php echo isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : ''; ?>"><br><br>
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville"
                    value="<?php echo isset($_POST['ville']) ? htmlspecialchars($_POST['ville']) : ''; ?>"><br><br>
                <label for="code-postal">Code Postal :</label>
                <input type="text" id="code-postal" name="code-postal"
                    value="<?php echo isset($_POST['code-postal']) ? htmlspecialchars($_POST['code-postal']) : ''; ?>"><br><br>

                <h2>Choix du paiement</h2>
                <div class="choix-paiement">
                    <label>
                        <input type="radio" name="paiement" value="Paiement à la caisse" id="paiement-cash-radio" <?php echo (isset($_POST['paiement']) && $_POST['paiement'] === 'Paiement à la caisse') ? 'checked' : ''; ?>>
                        Paiement à la caisse
                    </label>
                    <label>
                        <input type="radio" name="paiement" value="Paiement en ligne" id="paiement-ligne-radio" <?php echo (isset($_POST['paiement']) && $_POST['paiement'] === 'Paiement en ligne') ? 'checked' : ''; ?>>
                        Paiement en ligne
                    </label>
                </div>

                <button type="submit" name="enregistrer">Enregistrer</button>
            </form>
        </div>

    </section>
    <?php
    $enregistrerClique = false;
    include("../controller/controllerPizzeria.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $enregistrerClique = true;
        if (!empty($_POST['adresse']) || !empty($_POST['ville']) || !empty($_POST['code-postal'])) {
            if (empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code-postal'])) {
                echo "<script>alert('Veuillez renseigner une adresse complète pour la livraison. Rien pas de livraison.');</script>";
                $enregistrerClique = false;
            } else {
                $destination = $_POST['adresse'] . ', ' . $_POST['ville'] . ', ' . $_POST['code-postal'] . ", France";
                $distance = controllerPizzeria::calculDistancePizzeria($destination);
                if ($distance > 30 || $distance == -1) {
                    echo "<script>alert('Vous êtes trop loin veuillez renseigner une autre adresse $distance minutes');</script>";
                    $enregistrerClique = false;
                } else {
                    $_SESSION['adresse'] = $_POST['adresse'];
                    $_SESSION['ville'] = $_POST['ville'];
                    $_SESSION['codePostal'] = $_POST['code-postal'];
                    echo "<script>alert('Enregistré $distance minutes');</script>";
                }
            }
        }

        if (!isset($_POST['paiement'])) {
            echo "<script>alert('Veuillez choisir un mode de paiement');</script>";
            $enregistrerClique = false;
        } else {
            $_SESSION['modePaiement'] = $_POST['paiement'];
        }
    }
    ?>

    <section>
        <div class="recap-commande">
            <h2>Récapitulatif de la commande</h2>
            <?php
            require_once("../controller/controllerPizza.php");

            if (!empty($_SESSION['panier']) && !empty($_SESSION['tabQuantite'])) {
                echo "<div class='recap-commande'>";
                foreach ($_SESSION['panier'] as $idPizza) {
                    $pizzaDetails = controllerPizza::getPizzaPanier($idPizza);
                    if ($pizzaDetails->rowCount() > 0) {
                        while ($row = $pizzaDetails->fetch(PDO::FETCH_ASSOC)) {
                            $nom = htmlspecialchars($row['nomPizza']);
                            $quantite = $_SESSION['tabQuantite'][$idPizza];
                            $prix = controllerPizza::getPrixPizza($idPizza);

                            echo "<p>Nom de la pizza : $nom</p>";
                            echo "<p>Quantité : $quantite</p>";
                            echo "<p>Prix unitaire : $prix €</p>";
                            echo "<hr>";
                        }
                    }
                }

                echo "</div>";
            }
            require_once("../controller/controllerProduit.php");

            if (!empty($_SESSION['panierProduit']) && !empty($_SESSION['tabQuantiteProduit'])) {
                echo "<div class='recap-commande-produits'>";
                foreach ($_SESSION['panierProduit'] as $idProduit) {

                    $produitDetails = controllerProduit::getProduitPanier($idProduit);
                    if ($produitDetails->rowCount() > 0) {
                        while ($row = $produitDetails->fetch(PDO::FETCH_ASSOC)) {
                            $nomProduit = htmlspecialchars($row['nomProduit']);
                            $quantiteProduit = $_SESSION['tabQuantiteProduit'][$idProduit];
                            $prixProduit = controllerProduit::getPrixProduit($idProduit);
                            echo "<p>Nom du produit : $nomProduit</p>";
                            echo "<p>Quantité : $quantiteProduit</p>";
                            echo "<p>Prix unitaire : $prixProduit €</p>";
                            echo "<hr>";
                        }
                    }
                }

                echo "</div>";
            }
            ?>
            <form method="post">
                <button type="submit" name="annuler">Annuler</button>
            </form>
        </div>
        <?php

        if (isset($_POST['annuler'])) {
            header('Location: ../actions/viderPanier.php');
        }
        ?>

    </section>
    <section>
        <?php
        echo "<button id=\"confirmer\" onclick=\"confirmer($enregistrerClique)\">Confirmer la commande</button>"
            ?>
    </section>
</body>
<?php include("../view/footer.html"); ?>

</html>