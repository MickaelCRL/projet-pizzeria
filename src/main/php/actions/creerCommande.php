<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/controllerPizza.php");
include_once("../controller/controllerCommande.php");
include_once("../controller/controllerAdresse.php");
include_once("../controller/controllerVille.php");
include_once("../controller/controllerClient.php");
include_once("../controller/controllerContient.php");
include_once("../controller/controllerProduit.php");
include_once("../controller/controllerInclut.php");
include_once("../controller/controllerUtilise.php");
include_once("../controller/controllerIngredient.php");

// $_SESSION['panier'] 
// $_SESSION['tabQuantite'] 
// $_SESSION['panierProduit'] 
// $_SESSION['tabQuantiteProduit'] 
// $_SESSION['prixTotal']

$dateCommande = date("Y-m-d H:i:s");
$modePaiement = $_SESSION['modePaiement'];
$idClient = controllerClient::getIdClientByIdCompteClient($_SESSION["idCompteClient"]);
$adresse = $_SESSION['adresse'];
$ville = $_SESSION['ville'];
$codePostal = $_SESSION['codePostal'];

$resultGetIdVille = controllerVille::getIdVille($ville, $codePostal);
if ($resultGetIdVille) {
    $idVille = $resultGetIdVille['idVille'];

    $resultGetIdAdresse = controllerAdresse::getIdAdresse($adresse);

    if ($resultGetIdAdresse) {
        $idAllergene = $resultGetIdAdresse['idAdresse'];

    } else {
        controllerAdresse::addAdresse($adresse, $idVille);
        $idAllergene = controllerAdresse::getIdAdresse($adresse);
    }

} else {
    controllerVille::addVille($ville, $codePostal);
    $idVille = controllerVille::getIdVille($ville, $codePostal);
    controllerAdresse::addAdresse($adresse, $idVille);
    $idAllergene = controllerAdresse::getIdAdresse($adresse);
}

$idCommande = controllerCommande::addCommandeAndGetId($dateCommande, $modePaiement, $idClient, $idAllergene);

$panier = $_SESSION['panier'];
$tabQuantite = $_SESSION['tabQuantite'];

foreach ($panier as $idPizza) {
    $pizzaPanier = controllerPizza::getPizzaPanier($idPizza);

    if ($pizzaPanier->rowCount() > 0) {

        while ($row = $pizzaPanier->fetch(PDO::FETCH_ASSOC)) {
            $lienImage = htmlspecialchars($row['lienImage']);
            $nomPizza = htmlspecialchars($row['nomPizza']);
            $pizzaDuMoment = false;
            $elementRecette = controllerPizza::getPizzaIngredient($idPizza);
            $recette = implode(", ", $elementRecette);
            $etatPizza = false;
            $quantitePizzaAPrepare = $tabQuantite[$idPizza];

            $idNewpizza = controllerPizza::addPizzaAndGetId($nomPizza, $pizzaDuMoment, $recette, $quantitePizzaAPrepare, $etatPizza, $lienImage);
            controllerContient::addContient($idCommande, $idPizza, null, $quantitePizzaAPrepare);

            foreach ($elementRecette as $nomIngredient) {
                $idIngredient = controllerIngredient::getIngredientIdByNom($nomIngredient);
                controllerUtilise::addUtilise($idNewpizza, $idIngredient);

            }

        }

    }
}

foreach ($_SESSION['panierPizzaPersonaliser'] as $idPizza => $listRecettePizza) {
    $occurrences = array_count_values($listRecettePizza);
    foreach ($occurrences as $recette => $count) {
        $pizzaPersonnalierPanier = controllerPizza::getPizzaPanier($idPizza);
        if ($pizzaPersonnalierPanier->rowCount() > 0) {
            while ($row = $pizzaPersonnalierPanier->fetch(PDO::FETCH_ASSOC)) {
                $lienImage = htmlspecialchars($row['lienImage']);
                $nomPizza = htmlspecialchars($row['nomPizza']) . " Personnaliser";
                $pizzaDuMoment = false;
                $etatPizza = false;
                $quantitePizzaAPrepare = $count;

                $idNewpizza = controllerPizza::addPizzaAndGetId($nomPizza, $pizzaDuMoment, $recette, $quantitePizzaAPrepare, $etatPizza, $lienImage);
                controllerContient::addContient($idCommande, $idPizza, null, $quantitePizzaAPrepare);

                $elementRecette = explode(", ", $recette);
                foreach ($elementRecette as $nomIngredient) {
                    $idIngredient = controllerIngredient::getIngredientIdByNom($nomIngredient);
                    controllerUtilise::addUtilise($idNewpizza, $idIngredient);

                }

            }

        }
    }
}

$panierProduit = $_SESSION['panierProduit'];

foreach ($panierProduit as $idProduit) {
    $produitPanier = controllerProduit::getProduitPanier($idProduit);

    if ($produitPanier->rowCount() > 0) {

        while ($row = $produitPanier->fetch(PDO::FETCH_ASSOC)) {
            $quantiteInclut = $_SESSION['tabQuantiteProduit'][$idProduit];
            controllerInclut::addInclut($idCommande, $idProduit, $quantiteInclut);

        }
    }
}

header('Location: ../actions/viderPanier.php');
?>