<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de paiement</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/vuePaiement.css">
    <script src="../static/js/calculateDistance.js" defer></script>
    <script src="../static/js/verifPaiement.js" defer></script>
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
                <button type="submit" name="submit">Enregistrer</button>
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
            if($distance > 30 || $distance == -1 ){
                echo "<script>alert('Vous êtes trop loin veuillez renseigner une autre adresse $distance minutes');</script>";
            }
            else{
                echo "<script>alert('Enregistré $distance minutes');</script>";
            }
        }
    }
    ?>

    <section>
    <div class="recap-commande">
    <h2 >Récapitulatif de la commande</h2>
    <?php
    include("../model/panier.php");
     recapitulatifPanier($panier, $pdo, $prixTotal); ?>
</div>
        <button id="annuler">Annuler</button>
    </section>
    <section>
        <h2>Choix du paiement</h2>
        <div class="choix-paiement">
            <button id="paiement-cash" onclick="selectPayment('Paiement à la caisse')">Paiement à la caisse</button>
            <button id="paiement-ligne" onclick="selectPayment('Paiement en ligne')">Paiement en ligne</button>
        </div>
    </section>

    <section>
        <button id="confirmer" onclick="confirmCommande()">Confirmer la commande</button>
    </section>
</body>
<?php include("../view/footer.html"); ?>

</html>