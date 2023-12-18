<header>
    <div id="title-container">
        <img src="img/pizza_icon.png" alt="Pizza Icon" id="logo">
        <h1>Pizza Paradise</h1>
    </div>
    <nav>
        <a href="indexPizza.php">Accueil</a>
        <a href="pizza.php">Pizza</a>
        <?php 
            session_start();
            if (isset($_SESSION["nom"])) {
                echo "<a href='espace_compte.php'>Espace compte</a>";
            }
            else{
                echo " <a href='connexionClient.php'>Se connecter</a>";
            }
        ?>     
    </nav>
</header>