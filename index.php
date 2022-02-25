<?php 
    session_start();
    require_once "connection.php";

    //$username = $_SESSION["username"];
    //$pass = $_SESSION["pass"];
    
    if(isset($_SESSION["id"]))
    {
        header("Location: followers.php");
    }
    /*
    if(isset($_SESSION["username"]) && isset($_SESSION["pass"]))
    {
        header("Location: followers.php");
    }
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Or Register</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>

    <div class="container text-center justify-content-center align-middle col-md-6 offset-md-3 py-5">
        <img src="social.png" alt="social_logo" class="img-fluid d-inline-block">
    
        <p>If you have account - <a href="login.php" class="font-weight-bold">LOGIN!</a></p>

        <p>If you don't have account - <a href="register.php" class="font-weight-bold">REGISTER!</a></p>
        
    </div>
    
</body>
</html>