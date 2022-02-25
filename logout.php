<?php 
    session_start();
    
    //ako postoji session, obriši je
    if(isset($_SESSION["id"]))
    {
        $_SESSION = array(); //session_unset();
        session_destroy();
    }

    header("Location: index.php");
?>