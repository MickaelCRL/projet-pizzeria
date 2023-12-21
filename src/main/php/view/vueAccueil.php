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
        <div id="presentation">
            <img src="../static/img/m.jpg" alt="Pizza du moment" id="pizza-image">
            <div id="pizza-details">
                <p id="pizza-title">Pizza du moment : 4 fromages</p>
                <button id="order-button">
                    <a href='vuePizzaClient.php'>
                        Commander
                        <img src="../static/img/shop_icon.png" alt="Shop Icon" id="shop-icon">
                </button>
            </div>
        </div>
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
            if(!isset($_SESSION["nom"])){
                echo "
                <div id='button-container'>
                <button id='compte-button'>
                    <a href='espace_compte.php'>
                        Espace compte             
                        <img src='../static/img/user_icon.png' alt='user icon' id='user-icon'>  
                    </a>              
                </button>
            
            <button id='co-button'>
                    <a href='inscription.php'>
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