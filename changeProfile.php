    <?php 
        require_once "header.php";
        require_once "connection.php";

        $logId = $_SESSION["id"];

        //postavljanje početnih vrednosti 
        $name = $surname = $gender = $dob = $bio = "";
        $nameErr = $surnameErr = $dobErr = $bioErr = "";
        $validated = true;

        //Uzimanje STARIH podataka iz baze
        $q = "SELECT * FROM profiles WHERE user_id = $logId";
        $rezultat = $conn->query($q);
        $red = $rezultat->fetch_assoc();
        $name = $red["name"];
        $surname = $red["surname"];
        $gender = $red["gender"];
        $dob = $red["dob"];
        $bio = $red["bio"];

        if(!$rezultat) 
        {
            "Error: " . $conn->error;
        }


        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //Uzimamo NOVE podatke iz forme...
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $gender = $_POST["gender"];
            $dob = $_POST["dob"];
            $bio = $_POST["bio"];

            //name validacija
            if(empty($_POST["name"]) || !ctype_alpha(str_replace(" ","",$_POST["name"])))
            {
                $validated = false;
                $nameErr = "You must enter your name!";
            }
            elseif(strlen($_POST["name"]) > 50)
            {
                $validated = false;
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
                $validated = false;
                $surnameErr = "You must enter your name!";
            }
            elseif(strlen($_POST["surname"]) > 50)
            {
                $validated = false;
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
            if(empty($_POST["dob"]))
            {
                $dob = $_POST["dob"];
            }
            elseif($_POST["dob"] < "1900-12-31")
            {
                $validated = false;
                $dobErr = "You must be alive to register :)";
            }
            else 
            {
                $dob = $_POST["dob"];
            }

            //bio validacija
            if(empty($_POST["bio"]))
            {
                $bio = $_POST["bio"];
            }
            elseif(strlen($_POST["bio"]) > 500)
            {
                $validated = false; 
                $bioErr = "Your biography must be shorter than 500 characters!";
            }
            else 
            {
                $bio = $_POST["bio"];
            }

            if($validated)
            {
                $q = "UPDATE profiles 
                SET name = '$name', surname = '$surname', gender = '$gender',
                dob = '$dob', bio = '$bio' WHERE user_id = $logId";

                $rezultat = $conn->query($q);
                
                $sql = "SELECT CONCAT(profiles.name, ' ', profiles.surname) AS
                'full_name' FROM users
                INNER JOIN profiles
                ON users.id = profiles.user_id
                WHERE user_id = $logId";

                $rezultat = $conn->query($sql);
                $row = $rezultat->fetch_assoc();
                $_SESSION["full_name"] = $row["full_name"];
                
                //stavljena je lokacija za isti fajl kako bi osvežilo stranu i prikazalo promenjeno ime i prezime
                header("Location: changeProfile.php");
            }
        }
    ?>

    <title>Change profile</title>
    
    <div class="container py-5">
        <div class="row d-flex justify-content-center py-5">

            <form action="#" method="POST" class="text-center">
                <div>
                    <label class="form-label"> Name: </label>
                    <input type="text" name="name" id="" class="form-control" value="<?php echo $name ?>">
                    <span class="text-danger"> * <?php echo $nameErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Surname: </label>
                    <input type="text" name="surname" id="" class="form-control" value="<?php echo $surname ?>">
                    <span class="text-danger"> * <?php echo $surnameErr; ?> </span>
                </div>
                
                <div class="pb-2">
                    <div class="form-check-label">
                        <label> Gender: </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="m" <?php if($gender == "m"){echo 'checked';} ?>>
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="f" <?php if($gender == "f"){echo 'checked';} ?>>
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="o" <?php if($gender != "m" && $gender != "f"){echo 'checked';} ?>>
                        <label class="form-check-label" for="inlineRadio3">Other</label>
                    </div>
                </div>


                <div>
                    <label class="form-label"> Date of birth: </label>
                    <input type="date" name="dob" id="" class="form-control" value="<?php echo $dob ?>">
                    <span class="text-danger"> * <?php echo $dobErr; ?> </span>
                </div>

                <div>
                    <label class="form-label"> Biography: </label>
                    <textarea name="bio" cols="30" rows="5" class="form-control"><?php echo $bio; ?></textarea>
                    <span class="text-danger"> * <?php echo $bioErr; ?> </span>
                </div>

                <div>
                    <input type="submit" name="submit" value="Change personal info" class="btn btn-success">
                </div>

            </form>
        </div>
    </div>


</body>
</html>