    <?php 
        session_start();
    ?>
    
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="justify-content-center text-center py-3">
        <img src="social.png">
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <?php 
                $name = $surname = $gender = $date = $username = $pass = $retypepass = "";

                //greške 
                $nameErr = $surnameErr = $dateErr = $usernameErr = $passErr = $retypepassErr = "";


                if($_SERVER["REQUEST_METHOD"] == "POST")
                {

                    //name validacija 
                    // The str_replace() function replaces some characters with some other characters in a string.
                    // ctype_alpha() checks if all of the characters in the provided string, text, are alphabetic.
                    // The preg_replace() function returns a string or array of strings where 
                    //all matches of a pattern or list of patterns found in the input are replaced with substrings.
                    if(empty($_POST["name"]) || !ctype_alpha(str_replace(" ","",$_POST["name"])))
                    {
                        $nameErr = "You must enter your name!";
                    }
                    elseif(strlen($_POST["name"]) > 50)
                    {
                        $nameErr = "Name must have less than 50 charachters!";
                    }
                    else
                    {
                        $name = preg_replace("/\t|\s{2,}/","",$_POST["name"]);
                        //ako ima tabova ili više od dva space-a, spaja ih 
                    }

                    //surname validacija
                    if(empty($_POST["surname"]) || !ctype_alpha(str_replace(" ","",$_POST["surname"])))
                    {
                        $surnameErr = "You must enter your name!";
                    }
                    elseif(strlen($_POST["surname"]) > 50)
                    {
                        $surnameErr = "Surname must have less than 50 charachters!";
                    }
                    else
                    {
                        $surname = preg_replace("/\t|\s{2,}/","",$_POST["surname"]);
                        //ako ima tabova ili više od dva space-a, spaja ih 
                    }

                    //Gender validacija
                    $gender = $_POST["gender"];

                    //Date of birth validacija
                    if(empty($_POST["date"]))
                    {
                        //$prikaz = TRUE;
                        $date = $_POST["date"];
                    }
                    elseif($_POST["date"] < "1900-12-31")
                    {
                        $dateErr = "You must be alive to register :)";
                    }
                    else 
                    {
                        $date = $_POST["date"];
                    }

                    //username validacija
                    if(empty($_POST["username"]) || strpos($_POST["username"], " ") !== false)
                    {
                        $usernameErr = "You must enter your username without spaces and tabs!";
                    }
                    elseif(strlen($_POST["username"]) < 5 || strlen($_POST["username"]) > 50) 
                    {
                        $usernameErr = "Your username must have between 5 and 50 characters!";
                    }
                    else 
                    {
                        $username = $_POST["username"];
                    }
        
                    //Password validacija
                    if(empty($_POST["pass"]) || strpos($_POST["pass"], " ") !== false)
                    {
                        $passErr = "You must enter your password without spaces and tabs!";
                    }
                    elseif(strlen($_POST["pass"]) < 5 || strlen($_POST["pass"]) > 25)
                    {
                        $passErr = "Your password must have between 5 and 25 characters!";
                    }
                    else 
                    {
                        $pass = $_POST["pass"];
                    }

                    //Retype password validacija
                    if($_POST["retypepass"] === $_POST["pass"])
                    {
                        $retypepass = $_POST["retypepass"];
                    }
                    else 
                    {
                        $retypepassErr = "Your password and retype password must match!";
                    }
                }
            ?>

            <?php 

                if($name != "" && $surname != "" && $username != "" && $pass != "" && $retypepass != "" && $pass == $retypepass)
                {
                    require_once "connection.php";

                    $name = $conn->real_escape_string($name);
                    $surname = $conn->real_escape_string($surname);
                    $username = $conn->real_escape_string($username);
                    $pass = $conn->real_escape_string($pass);
                    $pass = md5($pass);
                    //$retypepass = $conn->real_escape_string($retypepass);

                    $upitZaUniqueUsername = "SELECT * FROM users WHERE username='$username'";
                    $rezultat = $conn->query($upitZaUniqueUsername);

                    $br = $rezultat->num_rows; // mysqli_num_rows($rezultat)

                    if($br != 0)
                    {
                        $usernameErr = "Sorry! Username already taken, choose another one! (:";
                    }
                    else 
                    {
                        $sql = "INSERT INTO users(username, pass)
                        VALUES 
                        ('$username', '$pass')";

                        $rezultat = $conn->query($sql);

                        /*
                            if($conn->query($sql))
                            {
                                echo "<p class='text-success'> Uspešno izvršeni unos u tabelu USERS! </p>";
                            }
                            else 
                            {
                                echo "<p class='text-danger'> Došlo je do greške prilikom dodavanja unosa u USERS: " . $conn->error .  "</p>";
                            }
                        */

                        $sql2 = "SELECT id FROM users WHERE username='$username'";
                        $rezultat = $conn->query($sql2); 
                        $red = $rezultat->fetch_assoc();
                        $id = $red['id'];

                        $sql3 = "INSERT INTO profiles(name, surname, gender, dob, user_id)
                        VALUES 
                        ('$name', '$surname', '$gender', '$date', '$id');";

                        $rezultat = $conn->query($sql3);

                        /*
                            if($conn->query($sql3))
                            {
                                echo "<p class='text-success'> Uspešno izvršeni unos u tabelu PROFILES! </p>";
                            }
                            else 
                            {
                                echo "<p class='text-danger'> Došlo je do greške prilikom dodavanja unosa u PROFILES: " . $conn->error .  "</p>";
                            }
                        */

                        //redirekcija nakon uspešno unetog korisnika
                        header("Location: login.php");

                    }  
                }

            ?>

            <form action="#" method="POST" class="text-center">

                <div>
                    <label class="form-label"> Name: </label>
                    <input type="text" name="name" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $nameErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Surname: </label>
                    <input type="text" name="surname" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $surnameErr; ?> </span>
                </div>

                <div class="pb-2">
                    <div class="form-check-label">
                        <label> Gender: </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="m">
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="f">
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="o" checked>
                        <label class="form-check-label" for="inlineRadio3">Other</label>
                    </div>
                </div>


                <div>
                    <label class="form-label"> Date of birth: </label>
                    <input type="date" name="date" id="" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    <span class="text-danger"> * <?php echo $dateErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Username: </label>
                    <input type="text" name="username" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $usernameErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Password: </label>
                    <input type="password" name="pass" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $passErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Retype password: </label>
                    <input type="password" name="retypepass" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $retypepassErr; ?> </span>
                </div>

                <div>
                    <input type="submit" name="submit" value="Send!" class="btn btn-success">
                </div>

            </form>
        </div>
    </div>
    
</body>
</html>