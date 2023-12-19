<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de paiement</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include("../view/menu.php"); ?>

<body>
    <section>
        <h1>Commande en ligne</h1>
    </section>
    <section>
        <div class="formulaire">

            <h3>Informations personnelles</h3>
            <form id="infos-personnelles">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required><br><br>
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" required><br><br>
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required><br><br>
                <label for="code-postal">Code Postal :</label>
                <input type="text" id="code-postal" name="code-postal" required><br><br>
            </form>
        </div>
    </section>
    <section>
        <div class="recap-commande">
            <h3>Récapitulatif de la commande</h3>
            <!-- Cette div sera remplie dynamiquement -->
        </div>
        <button id="annuler">Annuler</button>
    </section>
    <section>
        <div class="choix-paiement">
            <h3>Choix du paiement</h3>
            <button id="paiement-cash">Paiement à la caisse</button>
            <button id="paiement-ligne">Paiement en ligne</button>
        </div>
        <button id="confirmer">Confirmer la commande</button>
    </section>
</body>
<?php include("../view/footer.html"); ?>

</html>