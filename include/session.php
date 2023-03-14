<?php

session_start();
if(!($database = mysqli_connect( "localhost", "root", NULL, "db109")))                      
    die( "Could not connect to database" );

/**
 * @param mysqli $db
 */
function updateSessionBalance($db){
    $accID = $_SESSION["accountId"];
    $query = "SELECT balance FROM account WHERE accountId = $accID";
    if(!($result = mysqli_query($db,$query)) || mysqli_num_rows($result) === 0){
        session_destroy();
        header("Location: login.php");
        return;
    }
    $balance = mysqli_fetch_row($result);
    $_SESSION["balance"] = $balance[0];
}
?>