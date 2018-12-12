<?php
    session_start();
?>

<html>
    <head>
        <title>Logout</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/login_style.css">
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
    </body>
</html>

<?php
     $username = $_SESSION["username"];
    
     $wasLoggedIn = false;

     if ($username !== null)
     {
         $wasLoggedIn = true;
         $_SESSION["username"] = null;
     }
     
     if ($wasLoggedIn)
     {
         echo("<p class='success'>You've been successfully logged out!</p>");
     }
?>