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

    <header>
        <nav class="navBar">
            <p class="navButton" onclick="window.location.assign('./index.php')">Home</p>

            <p class="navButton" onclick="window.location.assign('./about.php')">About</p>

            <p class="navButton" onclick="window.location.assign('./register.php')">Register</p>

            <p class="navButton" onclick="window.location.assign('./login.php')">Login</p>

            <p class="navButton" onclick="window.location.assign('./highscores.php')">Highscores</p>

            <p class="navButton" onclick="window.location.assign('./play.php')">Play</p>
        </nav>
    </header>

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