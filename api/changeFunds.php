<?php
//This page is to update the funds from adding or withdrawing funds
header("Content-Type: text/plain");
set_include_path("../");
require("include/session.php");
if(!isset($_SESSION["loggedIn"])){
    http_response_code(403);
    exit();
}
updateSessionBalance($database);
$balance = $_SESSION["balance"];

if(!isset($_POST["amount"]) || empty($_POST["amount"]) || !is_numeric($_POST["amount"])){
    http_response_code(400);
    exit();
}

$amount = doubleval($_POST["amount"]);

if($amount>=10000){
    http_response_code(400);
    exit();
}

$balance += $amount;
$balance = round($balance,2);
if($balance < 0){// fixes rounding problems
    $balance = 0;
}
$accNum = $_SESSION["accnum"];
$accId = $_SESSION["accountId"];
$query = "UPDATE account SET balance=$balance WHERE accountId=$accId";//query to update the balance in account table
$query2 ="INSERT INTO transactions (accountNumber, amount) VALUES ('".$accNum."', '".$amount."')";// query to update the transactions table
if(!($result = mysqli_query($database,$query)) || !($result2 = mysqli_query($database,$query2))){
    http_response_code(503);
    exit();
}

$_SESSION["balance"] = $balance;
printf("%.2f",$balance);