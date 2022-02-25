<?php 
    session_start();

    if(empty($_SESSION["id"]))
    {
        header ("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andja's Social Network!</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    

    <!-- Header kao Navbar -->
    <nav class="navbar fixed-top navbar-light bg-light navbar-expand-sm border-bottom shadow-lg">
        <div class="container-fluid">
            <h4 class="navbar-brand text-light bg-dark p-2 font-weight-bold shadow-lg border border-danger rounded">Hello, <?php echo $_SESSION["full_name"];  ?>!</h4>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link p-2 font-weight-bold m-2" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link p-2 font-weight-bold m-2" href="followers.php">Friends</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link p-2 font-weight-bold m-2" href="changeProfile.php">Change profile</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link p-2 font-weight-bold m-2" href="changePass.php">Change password</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger font-weight-bold m-2" href="logout.php">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
