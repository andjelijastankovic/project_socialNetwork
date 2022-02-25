<?php 

    //kreiranje objekta konekcije
    $servername = "localhost";
    $user = "admin";
    $password = "nikica988";
    $db = "mreza";

    $conn = new mysqli($servername, $user, $password, $db);
    if($conn->connect_error)
    {
        die("Error connecting to database: " . $conn->connect_error);
    }

?>