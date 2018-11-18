<?php
    session_start();
?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/login_style.css">
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
        <form action="./login.php" method="post">
            <p>Username: <input type="text" name="username"></p>
            <p>Password: <input type="password" name="password"></p>
            <input type="submit" value="Login"> 
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
        
        $result = $db->query("SELECT * FROM Users WHERE UPPER(Username) IS UPPER('{$username}');");

        if ($result != false)
        {
            $arr = $result->fetchArray();

            $username = $arr["Username"];
            $passwordSalt = $arr["UserSalt"];
            $passwordHash = $arr["PasswordHash"];

            $inputPassHash = hash("sha256", $password . $passwordSalt);

            if (strcmp($inputPassHash, $passwordHash) === 0)
            {
                echo("<p class='success'>Successful login!</p>");

                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
            } else 
            {
                echo("<p class='error'>Error: Invalid username or password!</p>");
            }
        }
    }
?>