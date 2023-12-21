<header>
    <div id="title-container">
        <img src="../static/img/pizza_icon.png" alt="Pizza Icon" id="logo">
        <h1>Pizza Paradise</h1>
    </div>
    <nav>
        <a href="./vueAcceuil.php">Accueil</a>
        <a href="./vuePizzaClient.php">Pizza</a>
        <?php 
            session_start();
            if (isset($_SESSION["nom"])) {
                echo "<a href='./vueEspaceCompte.php'>Espace compte</a>";
            }
            else{
                echo " <a href='./vueConnexion.php'>Se connecter</a>";
            }
            if (isset($_SESSION["nom"])) {
                echo "<a href='./vuePanier.php'>Votre panier</a>";
            }
        ?>     
    </nav>
</header>