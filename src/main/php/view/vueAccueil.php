<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Paradise</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>

<body>
    <?php include("./navigation.php"); ?>

    <main>
        <?php
        include("../controller/controllerPizza.php");
        $resultat = controllerPizza::getPizzaDuMoment();
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        $nomPizza = htmlspecialchars($row['nomPizza']);
        $lienImage = htmlspecialchars($row['lienImage']);
        echo "<div id='presentation'>
                <img src='../static/$lienImage' alt='Pizza du moment' id='pizza-image'>
                <div id='pizza-details'>
                    <p id='pizza-title'>Pizza du moment : $nomPizza</p>
                    <button id='order-button'>";
        if (isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]) {
            echo "<a href='vuePizzaGestionnaire.php'>";
        } else {
            echo "<a href='vuePizzaClient.php'>";
        }
        echo "Commander
            <img src='../static/img/shop_icon.png' alt='Shop Icon' id='icon'>
            </button>
            </div>
            </div>";

        ?>

        <div id="additional-text">
            Toutes vos pizzas sont personnalisables ! <br>
            Des boissons ou des desserts sont également disponibles.
        </div>

        <div id="discount-text">
            -50% sur votre prochaine commande si votre dernière commande dure plus de 45min.
        </div>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["nom"])) {
            echo "
                <div id='button-container'>
                <button id='compte-button'>
                    <a href='vueEspaceCompte.php'>
                        Espace compte             
                        <img src='../static/img/user_icon.png' alt='user icon' id='user-icon'>  
                    </a>              
                </button>
            
            <button id='co-button'>
                    <a href='vueConnexion.php'>
                    Se connecter
                    <img src='../static/img/user_icon.png' alt='user icon' id='user-icon'>
                    </a>
            </button>
        </div>
                ";
        }
        ?>
        <br>
    </main>

    <footer>
        &copy; 2023-2024 Pizza Paradise. Tous droits réservés.
    </footer>


</body>

</html>