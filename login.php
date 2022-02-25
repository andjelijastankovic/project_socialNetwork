<?php
    //otvaranje sesije na početku stranice 
    session_start();

    require_once "connection.php";

    $usernameErr = $passErr = "*";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //korisnik je poslao username i pass i pokušava da se uloguje... 
        $username = $conn->real_escape_string($_POST["username"]);
        $pass = $conn->real_escape_string($_POST["pass"]);
        $val = true; //znači da je sve validno 

        if(empty($username))
        {
            $val = false;
            $usernameErr = "Username can't be left blank!"; 
        }
        if(empty($pass))
        {
            $val = false;
            $passErr = "Password can't be left blank!";
        }
        if($val)
        {
            //pokušamo da ulogujemo korisnika samo ako su sva polja forme popunjena
            $sql = "SELECT * FROM users WHERE
            username = '$username'";

            $rezultat = $conn->query($sql);
            
            if($rezultat->num_rows == 0)
            {
                $usernameErr = "This username doesn't exist!";
            }
            else 
            {
                //postoji korisničko ime, treba proveriti šifre 
                $row = $rezultat->fetch_assoc();
                $dbPass = $row["pass"];
                
                if($dbPass != md5($pass))
                {
                    $passErr = "Incorrect password!";
                }
                else 
                {
                    //ovde vršimo logovanje 
                    $_SESSION["id"] = $row["id"];
                    
                    $sql = "SELECT CONCAT(profiles.name, ' ', profiles.surname) AS
                    'full_name' FROM users
                    INNER JOIN profiles
                    ON users.id = profiles.user_id
                    WHERE users.username = '$username'";

                    $rezultat = $conn->query($sql);
                    $row = $rezultat->fetch_assoc();
                    $_SESSION["full_name"] = $row["full_name"];
                    
                    header("Location: followers.php");
                }
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to the Social Network!</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="justify-content-center text-center py-3">
        <img src="social.png">
    </div>

    <div class="justify-content-center text-center">
        <p> Enter your username and password for login! </p>
    </div>

    <div class="container">
        <div class="row py-3 d-flex justify-content-center">
            <form action="#" method="POST" class="text-center">

                <p>
                    <label for="username" class="form-label"> Username: </label>
                    <input type="text" name="username" id="username" class="form-control">
                    <span class="text-danger"> <?php echo $usernameErr ?> </span>
                </p>

                <p>
                    <label for="pass" class="form-label"> Password: </label>
                    <input type="password" name="pass" id="pass" class="form-control">
                    <span class="text-danger"> <?php echo $passErr ?> </span>
                </p>

                <input type="submit" value="Login!" class="btn btn-success">

            </form>
        </div>
    </div>
    
</body>
</html>