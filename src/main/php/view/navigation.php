<header>
    <div id="title-container">
        <img src="../static/img/pizza_icon.png" alt="Pizza Icon" id="logo">
        <h1>Pizza Paradise</h1>
    </div>
    <nav>
    <?php
        session_start();
        echo "<a href='./vueAccueil.php'>Accueil</a>";
        if(!isset($_SESSION["estGestionnaire"]) || !$_SESSION["estGestionnaire"]){
            echo "<a href='./vuePizzaClient.php'>Pizza</a>";
            echo "<a href='./vueProduit.php'>Produit</a>";}
        else if(isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]){
            echo "<a href='./vuePizzaGestionnaire.php'>Pizza</a>";
            echo "<a href='./vueProduitGestionnaire.php'>Produit</a>";
        }
             
        if (isset($_SESSION["nom"]) ) {
            echo "<a href='./vueEspaceCompte.php'>Espace compte</a>";
        } else {
            echo " <a href='./vueConnexion.php'>Se connecter</a>";
        }
        if (isset($_SESSION["nom"]) && isset($_SESSION["estGestionnaire"]) && !$_SESSION["estGestionnaire"]) {
            echo "<a href='./vuePanier.php'>Votre panier</a>";
        }
        if (isset($_SESSION["estGestionnaire"]) && $_SESSION["estGestionnaire"]) {
            echo "<a href='./vueStocks.php'>Stocks</a>";
            echo "<a href='./vueStatistiques.php'>Statistiques</a>";
        }
        ?>
    </nav>
</header>