<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenir les données du formulaire
    $nom = $_POST["nom"];
    $allergenes = $_POST["alergenes"];
    $allergenes = explode(",", $allergenes);
    // Image de la pizza 
    $chemin = "../static/img/";
    $cheminLien = "img/";
    $target_file = $chemin . basename($_FILES["fileToUpload"]["name"]);
    // Vérifiez si le fichier est une image réelle ou une fausse image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        // Déplacez le fichier téléchargé vers le répertoire souhaité
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "L'image " . basename($_FILES["fileToUpload"]["name"]) . " a été importée avec succès.";
            $lienImage = $cheminLien . basename($_FILES["fileToUpload"]["name"]);
        }
    } else {
        $lienImage = null;
    }
    include("../controller/controllerPizza.php");
    $idNouvellePizza = controllerPizza::nouvellePizza($nom, $lienImage);
    // Récupérer les quantités des ingrédients et leurs ID
    include("../controller/controllerUtilise.php");
    // Boucle pour les ingrédients
    foreach ($_POST['ingredient'] as $idIngredient => $value) {
        // Vérifier si la checkbox est cochée
        if ($value == $idIngredient) {
            // La checkbox est cochée, appel de la fonction
            controllerUtilise::addUtilise($idNouvellePizza, $idIngredient);
        }
    }
    // Boucle pour les allergènes
    foreach ($allergenes as $allergene) {
        controllerPizza::nouvelAllergenePizza($idNouvellePizza, $allergene);
    }

    // Mettre à jour l'attribut recette en fonction des nouveaux ingrédients 
    controllerPizza::updateRecettePizza($idNouvellePizza);
    header("Location: ../view/vuePizzaGestionnaire.php");
}
?>
<?php include("../view/footer.html"); ?>