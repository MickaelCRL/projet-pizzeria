<header>
    <div id="title-container">
        <img src="../static/img/pizza_icon.png" alt="Pizza Icon" id="logo">
        <h1>Pizza Paradise</h1>
    </div>
    <nav>
        <a href="../model/indexPizza.php">Accueil</a>
        <a href="../model/pizza.php">Pizza</a>
        <?php 
            session_start();
            if (isset($_SESSION["nom"])) {
                echo "<a href='../model/espace_compte.php'>Espace compte</a>";
            }
            else{
                echo " <a href='../model/connexionClient.php'>Se connecter</a>";
            }
            if (isset($_SESSION["nom"])) {
                echo "<a href='../model/panier.php'>Votre panier</a>";
            }
        ?>     
    </nav>
</header>