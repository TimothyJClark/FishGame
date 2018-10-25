<?php
    $db = new SQLite3("./info.db");

    $result = $db->query("SELECT * FROM Scores ORDER BY ScoreValue DESC;");
?>

<html>
    <head>
        <title>High Scores</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/highscores_style.css">
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
        <ol>
        <?php
            $arr;

            while (($arr = $result->fetchArray()) != null)
            {
                echo("<li><p>".$arr["ScoreName"].": ".$arr["ScoreValue"]."</p></li>");
            }
        ?>
        </ol>
    </body>
</html>