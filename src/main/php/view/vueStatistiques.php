<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<?php include("../view/navigation.php"); include("../controller/controllerStatistiques.php"); ?>

<body>
<?php 
    echo "<h1 style= 'text-align: center;'> Chiffre d'affaire journalier : ";
    echo controllerStatistiques::getStatistiquesForDisplay('journalier');
    echo "</h1> <br>";
    echo "<h1 style= 'text-align: center;'> Chiffre d'affaire hebdomadaire : ";
    echo controllerStatistiques::getStatistiquesForDisplay('hebdomadaire');
    echo "</h1> <br>";
    echo "<h1 style= 'text-align: center;'> Chiffre d'affaire mensuel : ";
    echo controllerStatistiques::getStatistiquesForDisplay('mensuel');
    echo "</h1> <br>";
?>

</body>
<?php include("../view/footer.html"); ?>

</html>