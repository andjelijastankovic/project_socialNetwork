<?php 
    require_once "header.php";
    require_once "connection.php";

    $logId = $_GET["user_id"];

    if(empty($logId))
    {
        echo "<p class='badID'> Something's wrong with your ID... </p>";
    }
    else 
    {
        $idPostojiIliNe = "SELECT id FROM users WHERE id = $logId";
        $rezultat = $conn->query($idPostojiIliNe);
        
        if(!$rezultat->num_rows)
        {
            echo "<p class='badID py-5 m-5 text-center'> There's no user with that ID on Andja's Social Network...</p>";
        }
        else 
        {
            $unos = "SELECT profiles.name AS 'First name', profiles.surname
            AS 'Last name', users.username AS 'Username', 
            profiles.dob AS 'Date of birth', profiles.gender AS 'Gender', 
            profiles.bio AS 'About me' 
            FROM profiles 
            INNER JOIN users 
            ON users.id = profiles.user_id 
            WHERE user_id = $logId";

            $rezultat = $conn->query($unos);
            $row = $rezultat->fetch_assoc();
            $firstName = $row["First name"];
            $lastName = $row["Last name"];
            $userName = $row["Username"];
            $dateofBirth = $row["Date of birth"];
            $gender = $row["Gender"];
            $aboutMe = $row["About me"];


            if($gender = $row["Gender"] == "m") 
            {
                $gender = $row["Gender"];
                $color = "style='color: blue'";
            }
            elseif($gender = $row["Gender"] == "o")
            {
                $gender = $row["Gender"];
                $color = "style='color: lightgreen'";
            }
            else 
            {
                $gender = $row["Gender"]; 
                $color = "style='color: magenta'";
            }

            echo "<div class='container py-5'>";
                echo "<div class='row py-5 d-flex justify-content-center'>";
                
                    echo "<table class='table-dark table-bordered table-hover table-striped'>";
                        echo "<tr>";
                        echo "<td class='p-2 text-center'> First name </td>"; 
                            echo "<td '$color' class='p-2 text-center'>" . $firstName . "</td>"; 
                        echo "</tr>";
                    
                        echo "<tr>";
                        echo "<td class='p-2 text-center'> Last name </td>"; 
                            echo "<td '$color' class='p-2 text-center'>" . $lastName . "</td>"; 
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td class='p-2 text-center'> Username </td>"; 
                            echo "<td '$color' class='p-2 text-center'>" . $userName . "</td>"; 
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td class='p-2 text-center'> Date of birth </td>"; 
                            echo "<td '$color' class='p-2 text-center'>" . $dateofBirth . "</td>"; 
                        echo "</tr>";

                        echo "<tr>";
                            echo "<td class='p-2 text-center'> Gender </td>"; 
                            echo "<td  '$color' class='p-2 text-center'>" . $gender . "</td>"; 
                        echo "</tr>";

                        echo "<tr>";
                            echo "<td class='p-2 text-center'> About me </td>"; 
                            echo "<td '$color' class='p-2 text-center'>" . $aboutMe . "</td>"; 
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";
            echo "</div>";

            echo "<div class='container text-center justify-content-center align-middle col-md-6 offset-md-3'>";

                echo "<a href='followers.php' target='_blank' class='btn btn-primary font-weight-bold'> Followers </a>";
    
            echo "</div>";
        }
    }

    
?>