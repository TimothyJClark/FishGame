<?php
    session_start();
    $db = new SQLite3("./info.db");

    $result = $db->query("SELECT * FROM Scores ORDER BY ScoreValue DESC;");
?>

<html>
    <head>
        <title>High Scores</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/highscores_style.css">
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