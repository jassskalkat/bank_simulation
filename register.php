<?php
require("include/session.php");
if(isset($_SESSION["loggedIn"])){
    header("Location: home.php");
}
$errorMsg = "";

 
do{
    if(isset($_POST["registerButton"])){
        if(!empty($_POST["fName"]) && !empty($_POST["lName"]) && !empty($_POST["registerPassword"] && !empty($_POST["reRegisterPassword"]))){
            $fName = $_POST["fName"];
            $lName = $_POST["lName"];
            $regex = "/^[a-zA-Z]+(?:[- ]?[a-zA-Z]+)?$/";

            if(!preg_match($regex,$fName) || !preg_match($regex,$lName)){
                $errorMsg = "invalid characters in first or last name";
                break;
            }

            $registerPassword = $_POST["registerPassword"];
            if(!preg_match("/\S+/",$registerPassword)){
                $errorMsg = "No white space in password";
                break;
            }
            if(strlen($registerPassword)> 50){
                $errorMsg = "password is over max length of 50";
                break;
            }
            if(strlen($registerPassword)< 5){
                $errorMsg = "password must be atleast 5 characters long";
                break;
            }
            if($registerPassword != $_POST["reRegisterPassword"]){
                $errorMsg = "Passwords do not match";
                break;
            }
            $accnum= rand(10001,99999); 
            $_SESSION["accnum"] = $accnum;
            
            $registerPasswordSafe = mysqli_real_escape_string($database,$registerPassword);
            $registerQuery = "INSERT INTO account (firstName, lastName, accountNumber, password) VALUES ('".$fName."', '".$lName."', '".$accnum."', '".$registerPasswordSafe."')";
            
            if(mysqli_query($database,$registerQuery) === true){
                $id = mysqli_insert_id($database); 
                $_SESSION["loggedIn"] = true;
                $_SESSION["accnum"] = $accnum;
                $_SESSION["balance"] = 0;
                $_SESSION["firstName"] = $fName;
                $_SESSION["lastName"] = $lName;
                $_SESSION["accountId"] = $id;
                header("Location: home.php");
            }
            else{
                $errorMsg = "problem";
            }
        }
        else{
            $errorMsg = "Fields not filled";
        }
    }
}while(false);
//seeing if the login fields are filled



?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Register Page</title>
    </head>

    <body>
        <h1 id = "title">Mapleplums Bank</h1>
        <div id = "loginPage">
            <form method = "post" action = "register.php">
                <p>
                    <label>First Name:<br>
                        <input name = "fName" type = "text" size = "20" id = "txtbox" maxlength="50">
                    </label>
                </p>
                <p>
                    <label>Last Name:<br>
                        <input name = "lName" type = "text" size = "20" id = "txtbox" maxlength="50">
                    </label>
                </p>
                <p>
                    <label>password:<br>
                        <input name = "registerPassword" type = "password" size = "20" maxlength="50" id = "txtbox">
                    </label>
                </p>
                <p>
                <label>password:<br>
                        <input name = "reRegisterPassword" type = "password" size = "20" maxlength="50" id = "txtbox">
                    </label>
                </p>
                <input type = "submit" value = "register" class = "button" name = "registerButton">
<?php if(isset($errorMsg)){?>            
                <p class = "errorMsg"><?php print($errorMsg);?></p>
<?php } ?>
            </form> 
        </div>
    </body>
</html>  