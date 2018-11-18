<!DOCTYPE html>
<html>
    <head>
        <title>Fishgame</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/play_style.css">
        <script src="./js/game.js"></script>
    </head>

    <?php
        $masterFile = fopen("navbar.master", "r");
        
        while (!feof($masterFile))
        {
            echo(fgets($masterFile));
        }

        fclose($masterFile);
    ?>

    <body id="gameDisplay">
        <p id="score">Score: 0</p>
        <img id="background" src="./images/background.png">
    </body>
</html>
