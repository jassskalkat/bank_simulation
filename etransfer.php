<?php
require("include/session.php");
if(!isset($_SESSION["loggedIn"])){
    header("Location: index.php");
}
updateSessionBalance($database);
$errorMsg = "";
$check = false;
do{
    if(isset($_POST["submitTransferButton"])){
        if(!empty($_POST["accnum"]) && !empty($_POST["amount"])){
            $accnum = intval($_POST["accnum"]);
            $amount = $_POST["amount"];
            if(!is_numeric($amount)){
                $errorMsg = "You can only input numbers";
                break;
            }
            if($accnum == $_SESSION["accnum"]){
                $errorMsg = "Cannot etransfer yourself";
                break;
            }
            if($amount>500){
                $errorMsg = "Cannot transfer over $500";
                break;
            }
            if($amount<=0){
                $errorMsg = "Cannot transfer negative money";
                break;
            }
            if($amount>$_SESSION["balance"]){
                $errorMsg = "Cannot transfer more than you have";
                break;
            }
            $queryToLogin = "SELECT accountNumber FROM account";
            if(!($result = mysqli_query($database,$queryToLogin))){
                 $errorMsg = "There was an error";
            }
            else{//query successful
                while($row = mysqli_fetch_row($result)){ // checking if the inputed acc num exists
                    if($row[0] == $accnum){
                        $check = true;
                        break;
                    }
                }
                if($check){// accnum does exist
                    $thisAccNum = $_SESSION["accnum"];
                    $amount = round($amount,2); // new
                    $query1 = "UPDATE account SET balance=balance-$amount WHERE accountNumber = $thisAccNum";
                    $query = "UPDATE account SET balance=balance+$amount WHERE accountNumber = $accnum";
                    if(!($newQueryResult = mysqli_query($database,$query))){// changing the value in the other account
                        $errorMsg = "query unsuccessful"; 
                        break;
                    }
                    if(!($newQueryResult1 = mysqli_query($database,$query1))){//changing the value in this account
                        $errorMsg = "query unsuccessful"; 
                        break;
                    }


                    $amount = $amount *-1;// make it negative to take be a subtraction in this persons transactions
                    $query2 = "INSERT INTO transactions (accountNumber, amount) VALUES ('".$thisAccNum."', '".$amount."')";// query to update this persons transactions
                    $amount = $amount *-1;// make it postive again for the other persons transactions
                    $query3 = "INSERT INTO transactions (accountNumber, amount) VALUES ('".$accnum."', '".$amount."')"; // query to update the other persons transactions
               
                    if(!($newQueryResult2 = mysqli_query($database,$query2)) || !($newQueryResult2 = mysqli_query($database,$query3))){
                        $errorMsg = "query unsuccessful"; 
                        break;
                    }
                    $_SESSION["balance"] = $_SESSION["balance"] - $amount;
                    

                }
                else{// acc num doesnt exit
                    $errorMsg = "This account does not exist";
                    break;
                }


            }
        }
        else{
            $errorMsg = "Fields not filled";
            break;
        }
    }
}while(false);









?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Etrasnfer Page</title>

        <!-- <script>
            var table = document.getElementById("table");
            var content = "";
        </script> -->
    </head>
    
    <body>
        <nav>
            <a href = "home.php"  class = "topLinks">Home</a>      
            <a href = "etransfer.php"  class = "topLinks">Etransfer</a>
            <a href = "transactions.php" class = "topLinks">Transactions</a>
            <a href = "logout.php" class = "topLinks">Logout</a>
        </nav>
        <h1 id = "title">Mapleplums bank</h1>
        <h2 id = "greeting">Etransfer</h2>

        <div class = "box">
           <table border="1" id = "table">
<?php

$query = "SELECT accountNumber, firstName, lastName FROM account";
if (!($result = mysqli_query($database, $query))) {
    print( "<p>Could not execute query!</p>" );
    die();
} 
//$result = mysqli_query($database,$query);
while($row = mysqli_fetch_row($result)){ 
    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] ." ". $row[2] . "</td></tr>"; 
}

?>
           </table>

           <form method = "post" action = "etransfer.php">
                <p>
                    <label>Enter account to transfer to:<br>
                        <input name = "accnum" type = "text" size = "10" id = "txtbox" placeholder="12345">
                    </label>
                </p>
                <p style = "margin-bottom:1px;">
                    <label>Enter amount to transfer:<br>
                        <input name = "amount" type = "text" size = "10" id = "txtbox" placeholder="500">
                    </label>
                </p>
                <p style = "font-size:small; margin-top: 1px; margin-bottom:0;">*max transfer amount = $500*</p>
                <p style ="margin: 0; padding-top:0%;">
                    <label><br>
                        <input type = "submit" value = "Submit" class = "button" name = "submitTransferButton">
                    </label>
                </p>
<?php if(isset($errorMsg)){?>            
    <p class = "errorMsg"><?php print($errorMsg);?></p>
<?php } ?>
           </form>
        </div>
        

    </body>
</html>  