<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gameover!</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/over_style.css">
    </head>

    <?php
        $masterFile = fopen("navbar.master", "r");
        
        while (!feof($masterFile))
        {
            echo(fgets($masterFile));
        }

        fclose($masterFile);
    ?>

    <body>
        <h1>Game over!</h1>
        <br />

        <?php

        $user = $_SESSION["username"];
        $score = $_COOKIE["score"];

        var_dump($user);

        if ($user != null)
        {
            $db = new SQLite3("./info.db");

            $db->exec("INSERT INTO Scores (ScoreName, ScoreValue) VALUES ('{$user}', '{$score}');");
            
            echo("<h1>Your score has been submitted to the high scores page...</h1>");
        } else 
        {
            echo("<h1>Please sign up to have your scores submitted to the high scores page!</h1>");
        }

        ?>
    </body>
</html>