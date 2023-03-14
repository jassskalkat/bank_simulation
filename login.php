<?php
require("include/session.php");
$accnum;
$password;
$errorMsg;

if(isset($_SESSION["loggedIn"])){
    header("Location: home.php");
}



//seeing if the login fields are filled
if(isset($_POST["loginButton"])){
    if(!empty($_POST["accnum"]) && !empty($_POST["password"])){
        $accnum = intval($_POST["accnum"]);
        $password = $_POST["password"];
        

        $queryToLogin = "SELECT password, balance, firstName, lastName, accountId FROM account WHERE accountNumber = ".$accnum;
        if(!($result = mysqli_query($database,$queryToLogin))){
            $errorMsg = "There was an error";
        }
        //seeing if the password matches the inputed password
        else{ 
            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_row($result);
                $realPassword = $row[0];
                if($password === $realPassword){
                    $_SESSION["loggedIn"] = true;
                    $_SESSION["accnum"] = $accnum;
                    $_SESSION["balance"] = $row[1];
                    $_SESSION["firstName"] = $row[2];
                    $_SESSION["lastName"] = $row[3];
                    $_SESSION["accountId"] = $row[4];
                    header("Location: home.php");
                }
                else{
                    $errorMsg = "Incorrect password";
                }
            }
            else{
                $errorMsg = "Incorrect account number";
            }
           
        }
    }
    else{
        $errorMsg = "Fields not filled";
    }

}
?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Login Page</title>

        
    </head>

    <body>
        <h1 id = "title">Mapleplums Bank</h1>
        <div id = "loginPage">
            <form method = "post" action = "login.php">
                <p>
                    <label>Enter account number:<br>
                        <input name = "accnum" type = "text" size = "20" id = "txtbox" maxlength="5" placeholder="12345">
                    </label>
                </p>
                <p>
                    <label>Enter password:<br>
                        <input name = "password" type = "password" size = "20" id = "txtbox" placeholder="*****" maxlength="50">
                    </label>
                </p>
                <input type = "submit" value = "Login" class = "button" name = "loginButton">
<?php if(isset($errorMsg)){ ?>
                <p class = "errorMsg"><?php print($errorMsg);?></p>
<?php } ?>
            </form> 
        </div>
    </body>
</html>    