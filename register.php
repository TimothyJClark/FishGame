<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/register_style.css">
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
        <form action="./register.php" method="post">
            <p>Username:</p><input type="text" name="username">
            <br/>
            <p>Password:</p><input type="password" name="password">
            <br/>
            <br/>
            <input type="submit" value="Register"> 
        </form>
    </body>
</html>

<?php
    $unsafe = false;

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == null || $password == null)
    {
        $unsafe = true;
    }

    if (strpos($username, "'") !== false && $unsafe == false)
    {
        $unsafe = true;
    }

    if (strpos($username, ";") !== false && $unsafe == false)
    {
        $unsafe = true;
    }

    if (strpos($password, "'") !== false && $unsafe == false)
    {
        $unsafe = true;
    }

    if (strpos($password, ";") !== false && $unsafe == false)
    {
        $unsafe = true;
    }

    if ($unsafe === false)
    {
        $db = new SQLite3("./info.db");
        
        $passwordSalt = substr(hash("md5", random_int(PHP_INT_MIN, PHP_INT_MAX)), 0, 12);
        
        $passwordHash = hash("sha256", $password . $passwordSalt);

        $result = $db->query("SELECT Username FROM Users WHERE UPPER(Username) IS UPPER('{$username}');");

        if ($result == false || $result->fetchArray() == false)
        {
            $result = $db->exec("INSERT INTO Users (Username, UserSalt, PasswordHash) VALUES ('{$username}', '{$passwordSalt}', '{$passwordHash}');");
            
            if ($result == true)
            {
                echo("<p class='success'>Success: Account has been registered!</p>");
            }
        } else 
        {
            echo("<p class='error'>Error: Username already taken!</p>");
        }
    }
?>