<?php
$panier = $_SESSION['panier'];
{

$prixTotal = $_SESSION['prixTotal'];



function recapitulatifPanier($panier, $pdo, $prixTotal)
{


    foreach ($panier as $idPizza) {
        $requete = "SELECT * FROM VuePizzaProposee WHERE idPizza = :idPizza";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':idPizza', $idPizza);
        $stmt->execute();

        $pizza = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pizza) {
            $nom = htmlspecialchars($pizza['nomPizza']);
            $allergenes = htmlspecialchars($pizza['nomAllergene']);


            echo "<div class='pizza-container'>";
            echo "<p id='pizza-title'>$nom</p>";
            echo "<p class='pizza-allergenes'>Allergènes : $allergenes</p>";
                include ("calculerPrix.php");
                calculerPrix($id);
            echo "</div>";
        }
    }

    echo "<br>";
    echo "<p id='prix'> Prix total de votre commande : $prixTotal € </p>";
}}



?>