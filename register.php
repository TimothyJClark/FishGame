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