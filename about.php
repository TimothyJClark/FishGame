<!DOCTYPE html>
<html>
    <head>
        <title>About</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/about_style.css">
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
        <p class="aboutText">This website was created by Timothy Clark.</p> 
        <br />
        <p class="aboutText">The game hosted on the site was created using Javascript and DOM manipulation.</p>
        <br />
        <p class="aboutText">The backend is written in PHP, and the database used is a SQLite3 database.</p>
    </body>
</html>