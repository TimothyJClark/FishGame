<?php
session_start();
?>

<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/register_style.css">
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
        <form action="./register.php" method="post">
            <p>Username: <input type="text" name="username"></p>
            <p>Password: <input type="password" name="password"></p>
            <input type="submit" value="Register"> 
        </form>
    </body>
</html>

<?php
    $unsafe = false;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $passwordMismatch = false;

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

        $usernameHash = hash("sha256", $username);
        
        $passwordSalt = substr(hash("md5", random_int(PHP_INT_MIN, PHP_INT_MAX)), 0, 12);
        
        $passwordInitialHash = hash("sha256", $password . $passwordSalt);
        $passwordFinalHash = hash("sha256", "537ca51a-19bf-4ff6-be54-d01150220856" . $passwordInitialHash);

        $result = $db->query("SELECT UsernameHash FROM Users WHERE UPPER(UsernameHash) IS UPPER('{$usernameHash}');");

        if ($result == false || $result->fetchArray() == false)
        {
            $result = $db->exec("INSERT INTO Users (UsernameHash, UserSalt, PasswordHash) VALUES ('{$usernameHash}', '{$passwordSalt}', '{$passwordFinalHash}');");
            
            if ($result == true)
            {
                echo("<p class='success'>Success: Account has been registered!</p>");
                $_SESSION["username"] = $username;
            }
        } else 
        {
            echo("<p class='error'>Error: Username already taken!</p>");
        }
    }
?>