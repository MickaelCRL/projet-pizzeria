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
        <?php include("../model/panier.php");
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        affichePanier()        
        ?>
        </main>   
    </body>
    <br>
    <?php include("../view/footer.html"); ?>
    </html>