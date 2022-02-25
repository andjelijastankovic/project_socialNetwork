    <?php 
        require_once "header.php";
        require_once "connection.php";

        if(empty($_SESSION["id"])) 
        {
            header("Location: login.php");
        }

        // promenljiva $logId predstavlja trenutno 'ulogovanog' korisnika
        $logId = $_SESSION["id"];

        $prikaz = "SELECT users.id, CONCAT(profiles.name, ' ' , profiles.surname) AS 'Name and surname', 
        users.username AS 'Username' 
        FROM users 
        INNER JOIN profiles 
        ON users.id = profiles.user_id
        WHERE profiles.user_id != '$logId'
        ORDER BY profiles.name, profiles.surname;";

        //NOT LIKE se koriste za string, ovde se koristi != pošto se porede brojevi

        $rezultat = $conn->query($prikaz);

        if(!$rezultat->num_rows) 
        {
            echo "<p class='text-danger'> There are no users to show! </p>";
        }
        else 
        {
            echo "<div class='container py-5'>";
                echo "<div class='row py-5 d-flex justify-content-center'>";
                    echo "<table class='table-dark table-bordered table-hover table-striped'>";
                        
                        echo 
                        "
                            <tr> 
                                <th class='p-2 text-center'> Name and Surname </th>
                                <th class='p-2 text-center'> Username </th>
                                <th class='p-2 text-center'> Actions </th>
                            </tr>
                        ";
                        
                        foreach($rezultat as $row)
                        {
                            echo "<tr>";
                                echo "<td class='p-2 text-center'>" . $row['Name and surname'] . "</td>";
                                echo "<td class='p-2 text-center'>" . $row['Username'] . "</td>";
                                $friendID = $row['id'];
                                echo "<td class='p-2 text-center'>" . "<a href='follow.php?friend_id=$friendID'>Follow!</a>" . " or " . "<a href='unfollow.php?friend_id=$friendID'>Unfollow!</a>" . "</td>";
                            echo "</tr>";
                        }

                    echo "</table>"; 
                echo "</div>";
            echo "</div>";
        }
        
    
    
    ?>
    
</body>
</html>