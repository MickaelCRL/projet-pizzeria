<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenir les données du formulaire
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $quantite = $_POST["quantite"];
    // Image du produit
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
    include("../controller/controllerProduit.php");
    controllerProduit::addProduit($nom,$quantite, $prix, $lienImage);
    header("Location: ../view/vueProduitGestionnaire.php");
}
?>
<?php include("../view/footer.html"); ?>