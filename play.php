<!DOCTYPE html>
<html>
    <head>
        <title>Fishgame</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/play_style.css">
        <script src="./js/game.js"></script>
    </head>

    <header id="head">
        <nav class="navBar">
            <p class="navButton" onclick="window.location.assign('./index.php')">Home</p>

            <p class="navButton" onclick="window.location.assign('./about.php')">About</p>

            <p class="navButton" onclick="window.location.assign('./register.php')">Register</p>

            <p class="navButton" onclick="window.location.assign('./login.php')">Login</p>

            <p class="navButton" onclick="window.location.assign('./highscores.php')">Highscores</p>

            <p class="navButton" onclick="window.location.assign('./play.php')">Play</p>
        </nav>
    </header>

    <body id="gameDisplay">
        <p id="score">Score: 0</p>
        <img id="background" src="./images/background.png">
    </body>
</html>
