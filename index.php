<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/home_style.css">
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
        <div id="welcome">
            <h1>Welcome to my website!</h1>
            <p>Below are some gifs of the game hosted on this site:</p>
        </div>

        <img src="./images/elon.gif">
    </body>
</html>