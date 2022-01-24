<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: August 2, 2020
 * Description: Retrieves the most recent stock records from the database and encodes it in JSON format.
 */

session_start();

// Only users who have logged in may view the content.
if (isset($_SESSION["username"])) {
    // Database connection.
    include "connect.php";

    // The number of stock records the user wishes to view is retrieved.
    $length = filter_input(INPUT_GET, "length", FILTER_VALIDATE_INT);

    // If an inappropriate value for '$length' is retrieved, the value will default to 10.
    if ($length !== 5 && $length !== 10 && $length !== 15 && $length !== 20 && $length !== 25) {
        $length = 10;
    }

    // The most recent stock records are retrieved and limited to the number the user wishes to view.
    $command = "SELECT * FROM StockUpdates
                ORDER BY UpdateDateTime DESC
                LIMIT $length";         
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();

    $stockRecords = []; // Stocks are stored in a list.

    // Stock records are retrieved from the database and stored as an associative array.
    while ($row = $stmt->fetch()) {
        $stock = [
            "stockId" => $row["StockId"],
            "stockName" => $row["StockName"],
            "price" => $row["CurrentPrice"],
            "lastUpdated" => $row["UpdateDateTime"]
        ];
        array_push($stockRecords, $stock); // Stock records are inserted to the list array.
    }

    // Stock list is encoded in JSON format.
    echo json_encode($stockRecords);
// If not logged in, they will be redirected to 'index.php'.    
} else {
    echo "
        <!DOCTYPE html>
        <html>
        <head>
            <link rel='stylesheet' type='text/css' href='../css/index.css'>
        </head>
        <body>
            <a class='text-link' href='../index.php'>Please login.</a>
        </body>
        </html>
    ";
}
?>