    <?php 
        require_once "header.php";
        require_once "connection.php";

        if(empty($_SESSION["id"])) 
        {
            header("Location: login.php");
        }

       
        // promenljiva $logId predstavlja trenutno ulogovanog korisnika
        $logId = $_SESSION["id"];


        if(!empty($_GET["follow"]))
        {
            //logovani korisnik šalje zahtev
            $friendID = $conn->real_escape_string($_GET["follow"]);

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

                $rezultat1 = $conn->query($sql);
                if(!$rezultat1)
                {
                    echo "<div class='text-danger'> Error: " . $conn->error . "</div>";
                }
            }

        }

        if(!empty($_GET["unfollow"]))
        {
            //logovani korisnik šalje zahtev
            $friendID = $conn->real_escape_string($_GET["unfollow"]);
            
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
                echo "<div class='text-danger'> Error: " . $conn->error . "</div>";
            }

        }

        if(!empty($_GET["user_id"]))
        {
            $friendID = $conn->real_escape_string($_GET["user_id"]);
        }
        

        $prikaz = "SELECT users.id, CONCAT(profiles.name, ' ' , profiles.surname) AS 'Name and surname', 
        users.username AS 'Username' 
        FROM users 
        INNER JOIN profiles 
        ON users.id = profiles.user_id
        WHERE profiles.user_id != $logId
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
                                $friendID = $row['id'];
                                echo "<td class='p-2 text-center'><a href='profile.php?user_id=$friendID'>" . $row['Name and surname'] . "</a></td>";
                                echo "<td class='p-2 text-center'>" . $row['Username'] . "</td>";
                                

                                //Ispitujemo da li pratim korisnika...
                                $sql1 = "SELECT * FROM followers 
                                WHERE sender_id = $logId
                                AND receiver_id = $friendID";

                                $rezultat1 = $conn->query($sql1);
                                $f1 = $rezultat1->num_rows; // 0 ili 1 - 0 ako ne pratim korisnika i 1 ako ga pratim 

                                //Ispitujemo da li korisnik prati mene... 
                                $sql2 = "SELECT * FROM followers WHERE 
                                sender_id = $friendID 
                                AND receiver_id = $logId";
                                
                                $rezultat2 = $conn->query($sql2);
                                $f2 = $rezultat2->num_rows; // ili 0 ili 1 

                                if($f1 == 0)
                                {
                                    if($f2 == 0)
                                    {
                                        $text = "Follow!";
                                    }
                                    else 
                                    {
                                        $text = "Follow back!";
                                    }
                                    echo "<td class='p-2 text-center'>" . "<a href='followers.php?follow=$friendID'>$text</a>" . "</td>";
                                }
                                else 
                                {
                                    echo "<td class='p-2 text-center'>" . "<a href='followers.php?unfollow=$friendID'>Unfollow!</a>" . "</td>"; 
                                }
                            echo "</tr>";
                        }

                    echo "</table>"; 
                echo "</div>";
            echo "</div>";
        }
        
        

        
            
        
        
    ?>
    
</body>
</html>