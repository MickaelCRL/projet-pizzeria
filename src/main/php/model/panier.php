<!DOCTYPE html>
<html>
<head>
    <title>Pizzas</title>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
</head>
<body>
    <?php include("../view/menu.php"); ?>
    <main class="mainPizza">
        <h1> Votre panier </h1>
        <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            require_once("../config/connexion.php");
            connexion::connect();
            $pdo = connexion::pdo();

            $panier = $_SESSION['panier'];

            for($i=0; $i<sizeof($panier);$i++){
                $requete = "SELECT * FROM VuePizzaProposee WHERE idPizza = $panier[$i]";
                $resultat = $pdo->query($requete); 
                if ($resultat->rowCount() > 0) {
                    // Parcourir les résultats et afficher les pizzas 
                    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        $id = htmlspecialchars($row['idPizza']);
                        $lien_image = htmlspecialchars($row['lienImage']);
                        $nom = htmlspecialchars($row['nomPizza']);
                        $allergenes = htmlspecialchars($row['nomAllergene']);

                        echo "<div class='pizza-container'>";
                        echo "<img src='../static/$lien_image' alt='Pizza' class='pizza-image'>";
                        echo "<p id='pizza-title'>$nom</p>";
                        echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                        echo "</div>";                       
                    }
                    // Afficher le prix total du panier
                   
                }
                else{
                    echo "<p class='erreur'>Votre panier est vide !</p>";
                }
                
            }
            $prixTotal = $_SESSION['prixTotal'];
            echo "<br>";
            echo "<p id='prix'> Prix total de votre commande : $prixTotal € </p>";   
        ?>         
        </main>   
    </body>
    <br>
    <?php include("../view/footer.html"); ?>
    </html>