<?php
require("include/session.php");
if(isset($_SESSION["loggedIn"])){
    header("Location: home.php");
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Bank Login Page</title>
    </head>

    <body>
        <h1 id = "title">Mapleplums Bank</h1>
        <div id = "loginPage">
            <div class = "newline"><a href = "login.php" class = "button">Login</a></div>
            <div class = "newline"><a href = "register.php" class = "button">Register</a></div>
        </div>
    </body>
</html>    
