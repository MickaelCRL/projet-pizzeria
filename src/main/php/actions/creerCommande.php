<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/controllerPizza.php");
// $_SESSION['panier'] 
// $_SESSION['tabQuantite'] 
// $_SESSION['panierProduit'] 
// $_SESSION['tabQuantiteProduit'] 
// $_SESSION['prixTotal']

$panier = $_SESSION['panier'];
$tabQuantite = $_SESSION['tabQuantite'];

foreach ($_SESSION['panier'] as $idPizza) {

    $pizzaPanier = controllerPizza::getPizzaPanier($idPizza);
    if ($pizzaPanier->rowCount() > 0) {
        // Parcourir les résultats et afficher les pizzas 
        while ($row = $pizzaPanier->fetch(PDO::FETCH_ASSOC)) {
            $id = htmlspecialchars($row['idPizza']);
            $lienImage = htmlspecialchars($row['lienImage']);
            $nomPizza = htmlspecialchars($row['nomPizza']);
            $pizzaDuMoment = false;
            $elementRecette = controllerPizza::getPizzaIngredient($id);
            $recette = implode(", ", $elementRecette);
            $etatPizza = false;
            $quantitePizzaAPrepare = $tabQuantite[$id];

            controllerPizza::addPizza($nomPizza, $pizzaDuMoment, $recette, $quantitePizzaAPrepare, $etatPizza, $lienImage);
        }

    }
}

header('Location: ../view/viderPanier.php');
?>