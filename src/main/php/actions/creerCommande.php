<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/controllerPizza.php");
include_once("../controller/controllerCommande.php");
include_once("../controller/controllerAdresse.php");
include_once("../controller/controllerVille.php");
include_once("../controller/controllerClient.php");

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
        $idAdresse = $resultGetIdAdresse['idAdresse'];

    } else {
        controllerAdresse::addAdresse($adresse, $idVille);
        $idAdresse = controllerAdresse::getIdAdresse($adresse);
    }

} else {
    controllerVille::addVille($ville, $codePostal);
    $idVille = controllerVille::getIdVille($idVille, $codePostal);
    controllerAdresse::addAdresse($adresse, $idVille);
    $idAdresse = controllerAdresse::getIdAdresse($adresse);
}


controllerCommande::addCommande($dateCommande, $modePaiement, $idClient, $idAdresse);




header('Location: ../actions/viderPanier.php');
?>