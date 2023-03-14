<?php
require("include/session.php");
if(!isset($_SESSION["loggedIn"])){
    header("Location: index.php");
}
updateSessionBalance($database);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Bank Login Page</title>
        <script>
            const accountBalance = <?php printf("%.2f",$_SESSION["balance"]);?>;
        </script>
        <script src = "home.js"></script>

    </head>
    
    <body>
        <nav>
            <a href = "home.php"  class = "topLinks">Home</a>      
            <a href = "etransfer.php"  class = "topLinks">Etransfer</a>
            <a href = "transactions.php" class = "topLinks">Transactions</a>
            <a href = "logout.php" class = "topLinks">Logout</a>
        </nav>
        <h1 id = "title">Mapleplums bank</h1>
        <h2 id = "greeting"></h2>
        <h2 id = "name"><?php printf("%s %s", $_SESSION["firstName"],$_SESSION["lastName"]);?></h2>
        <div class = "box">
            <table border = "1">
                <head>
                    <tr>
                        <th>Account Name:</th>
                        <th>Balance:</th>
                    </tr>
                </head>
                <tr>
                    <td>Chequing</td>
                    <td id = "balance"><?php printf("$%.2f",$_SESSION["balance"]);?></td>
                </tr>
            </table>
            <form method = "post" class = "inline" id = "addFunds">
                <input type = "submit" value = "Add Funds" class = "button">
            </form>
            <form method = "post" class = "inline" id = "withdrawFunds">
                <input type = "submit" value = "Withdraw Funds" class = "button">
            </form>
            <h6>Account Number: <?php printf("%d",$_SESSION["accnum"]);?></h6> 
        </div>
        

    </body>
</html>    
<!-- .$accountBalance. -->