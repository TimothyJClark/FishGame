<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/home_style.css">
    </head>

    <?php
        $masterFile = fopen("navbar.master", "r");
        
        while (!feof($masterFile))
        {
            echo(fgets($masterFile));
        }

        fclose($masterFile);
        
        $username = $_SESSION["username"];

        if ($username !== null)
        {
            echo("<p class='navText'>Logged In As: ". $username . "</p>");
        }
    ?>

    <body>
        <div id="welcome">
            <h1>Welcome to my website!</h1>
            <p>Below are some screenshots of the game hosted on this site:</p>
        </div>

        <img src="./images/screenshot1.png">

        <img src="./images/screenshot2.png">
    </body>
</html>