<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>About</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/about_style.css">
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
        <p class="aboutText">This website was created by Timothy Clark.</p> 
        <p class="aboutText">The game hosted on the site was created using Javascript and DOM manipulation.</p>
        <p class="aboutText">The backend is written in PHP, and the database used is a SQLite3 database.</p>
    </body>
</html>