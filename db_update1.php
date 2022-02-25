<?php 

    require_once "connection.php";

    $nova = "ALTER TABLE profiles 
    ADD bio TEXT AFTER dob;";

    $rezultat = $conn->query($nova);

    if(!$rezultat)
    {
        "Error: " . $conn->error;
    }
?>