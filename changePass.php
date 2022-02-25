<?php 
    require_once "header.php";
    require_once "connection.php";

    $logId = $_SESSION["id"];

    $oldpass = $newpass = $retypenewpass = "";
    $oldpassErr = $newpassErr = $retypenewpassErr = "";
    $validated = true;

    //Uzimanje STARIH podataka iz baze
    $q = "SELECT pass FROM users WHERE id = $logId";
    $rezultat = $conn->query($q);
    $red = $rezultat->fetch_assoc();
    $oldPass = $red["pass"];

    if(!$rezultat) 
    {
        "Error: " . $conn->error;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Uzimamo NOVE podatke iz forme...
        $oldpass = $_POST["oldpass"];
        $newpass = $_POST["newpass"];
        $retypenewpass = $_POST["retypenewpass"];

        //oldpass validacija
        if(md5($_POST["oldpass"]) != $oldPass)
        {
            $validated = false;
            $oldpassErr = "You entered wrong password, try again!";
        }

        /*
        if(empty($_POST["oldpass"]) || strpos($_POST["oldpass"], " ") !== false)
        {
            $validated = false;
            $oldpassErr = "You must enter your password without spaces and tabs!";
        }
        elseif(strlen($_POST["oldpass"]) < 5 || strlen($_POST["oldpass"]) > 25)
        {
            $validated = false;
            $oldpassErr = "Your password must have between 5 and 25 characters!";
        }
        else 
        {
            $oldpass = $_POST["oldpass"];
        }
        */

        //newpass validacija 
        if(empty($_POST["newpass"]) || strpos($_POST["newpass"], " ") !== false)
        {
            $validated = false;
            $newpassErr = "You must enter your password without spaces and tabs!";
        }
        elseif(strlen($_POST["newpass"]) < 5 || strlen($_POST["newpass"]) > 25)
        {
            $validated = false;
            $newpassErr = "Your password must have between 5 and 25 characters!";
        }
        else 
        {
            $newpass = $_POST["newpass"];
        }

        //Retype new password validacija
        if($_POST["retypenewpass"] === $_POST["newpass"])
        {
            $retypenewpass = $_POST["retypenewpass"];
        }
        else 
        {
            $validated = false;
            $retypenewpassErr = "Your new password and retype password must match!";
        }

        if($validated)
        {
            $q = "UPDATE users 
            SET pass = md5('$newpass') 
            WHERE id = $logId";

            $conn->query($q);

        }


    }    

?>


<title>Change password</title>
    
    <div class="container py-5">
        <div class="row d-flex justify-content-center py-5">

            <form action="#" method="POST" class="text-center">

                <p>
                    <label class="form-label"> Old password: </label>
                    <input type="password" name="oldpass" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $oldpassErr; ?> </span>
                </p>

                <p>
                    <label class="form-label"> New password: </label>
                    <input type="password" name="newpass" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $newpassErr; ?> </span>
                </p>

                <p>
                    <label class="form-label"> Retype new password: </label>
                    <input type="password" name="retypenewpass" id="" class="form-control">
                    <span class="text-danger"> * <?php echo $retypenewpassErr; ?> </span>
                </p>

                <p>
                    <input type="submit" name="submit" value="Click here to change your password" class="btn btn-success">
                </p>

            </form>
        </div>
    </div>


</body>
</html>