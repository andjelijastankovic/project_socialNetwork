<?php 

    require_once "connection.php";


    $tabele = 
    "
        CREATE TABLE IF NOT EXISTS users
        (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(50) UNIQUE NOT NULL, 
            pass VARCHAR(255) NOT NULL
        ) ENGINE = InnoDB;

        CREATE TABLE IF NOT EXISTS profiles 
        (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL, 
            surname VARCHAR(50) NOT NULL, 
            gender CHAR(1) NOT NULL, 
            dob DATE, 
            user_id INT UNSIGNED UNIQUE, 
            FOREIGN KEY(user_id) REFERENCES users(id)
        ) ENGINE = InnoDB;

        CREATE TABLE IF NOT EXISTS followers
        (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            sender_id INT UNSIGNED NOT NULL,
            receiver_id INT UNSIGNED NOT NULL,
            FOREIGN KEY(sender_id) REFERENCES users(id), 
            FOREIGN KEY(receiver_id) REFERENCES users(id) 
        ) ENGINE = InnoDB;
    ";

    if($conn->multi_query($tabele))
    {
        echo "<p> Uspešno kreirane tabele </p>";
    }
    else 
    {
        echo "<p> Greška prilikom kreiranja tabela: " . $conn->error . "</p>";
    }

?>