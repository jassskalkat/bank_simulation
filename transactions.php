<?php
require("include/session.php");



?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel = "stylesheet" type = "text/css" href = "style.css"/>
        <title>Transactions Page</title>
    </head>

    <body>
        <nav>
            <a href = "home.php"  class = "topLinks">Home</a>      
            <a href = "etransfer.php"  class = "topLinks">Etransfer</a>
            <a href = "transactions.php" class = "topLinks">Transactions</a>
            <a href = "logout.php" class = "topLinks">Logout</a>
        </nav>
        <h1 id = "title">Mapleplums Bank</h1>
        <h2 id = "greeting">Transactions</h2>
        <div class = "box">
            <table border = "1" id = "table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount ($)</th>
                    </tr>
                </thead>
<?php
$accountNum = $_SESSION["accnum"];
$query = "SELECT * from transactions WHERE accountNumber=$accountNum";
if(!($result = mysqli_query($database,$query))){
    print( "<p>Could not execute query!</p>" );
    die();
}
while($row = mysqli_fetch_row($result)){ 
    echo "<tr><td>" . date("Y-m-d g:i A",strtotime($row[2])) . "</td><td>" . $row[3] ."</td></tr>"; 
}

?>
            </table>
        </div>
    </body>
</html>  

