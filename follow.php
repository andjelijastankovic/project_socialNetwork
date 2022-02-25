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

        //pitamo da li to prijateljstvo već postoji...
        $sql = "SELECT * FROM followers 
        WHERE sender_id = $logId 
        AND receiver_id = $friendID";

        $rezultat = $conn->query($sql);

        if($rezultat->num_rows == 0)
        {
            $sql = "INSERT INTO followers(sender_id, receiver_id)
            VALUES 
            ($logId, $friendID);"; 

            /*  
                pošto su integer, onda nema potrebe da se
                koriste apostrofi, jer ako se stave apostrofi, 
                onda će broj da konvertuje u string i pravi samo višak posla
            */

            $rezultat1 = $conn->query($sql);
            if(!$rezultat1)
            {
                die("Error: " . $conn->error);
            }
        }
    }
    
    header("Location: followers.php"); //redirekcija na stranicu followers.php








?>