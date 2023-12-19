<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["nom"])){
        header("Location: ../model/connexionClient.php");
    }
    