<?php 
    session_start();
    require_once "connection.php";

    // promenljiva $logId predstavlja trenutno 'ulogovanog' korisnika
    $logId = $_SESSION["id"];


    if(!empty($_GET["friend_id"]))
    {
        //logovani korisnik šalje zahtev
        $friendID = $conn->real_escape_string($_GET["friend_id"]);
        
        /* 
            $friendID = $_GET["friend_id"];
            Kad god se uzimaju upiti iz $_GET ili $_POST metode,
            koristi se $friendID = $conn->real_escape_string($_GET["friend_id"]);
        */

        $sql = "DELETE FROM followers 
        WHERE sender_id = $logId 
        AND receiver_id = $friendID";

        $rezultat = $conn->query($sql);

        if(!$rezultat) 
        {
            die("Error: " . $conn->error);
        }
    }
    

    header("Location: followers.php"); //redirekcija na stranicu followers.php








?>