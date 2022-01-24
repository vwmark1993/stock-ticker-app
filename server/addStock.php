<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: August 9, 2020
 * Description: Inserts new stock records into the database.
 *              Updates existing stock records with retrieved information.
 *              Returns a  JSON array of the validated stock records that were retrieved.
 */

session_start(); 

// Only users who have logged in may view the content.
if (isset($_SESSION["username"])) {
    // Database connection.
    include "connect.php";

    /** Stock Record Validation Code Block **/

    // Stock record parameters are retrieved.
    $stockId1 = filter_input(INPUT_POST, "stockId1", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockName1 = filter_input(INPUT_POST, "stockName1", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockPrice1 = filter_input(INPUT_POST, "stockPrice1", FILTER_VALIDATE_FLOAT);

    $stockId2 = filter_input(INPUT_POST, "stockId2", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockName2 = filter_input(INPUT_POST, "stockName2", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockPrice2 = filter_input(INPUT_POST, "stockPrice2", FILTER_VALIDATE_FLOAT);

    $stockId3 = filter_input(INPUT_POST, "stockId3", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockName3 = filter_input(INPUT_POST, "stockName3", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockPrice3 = filter_input(INPUT_POST, "stockPrice3", FILTER_VALIDATE_FLOAT);

    $stockId4 = filter_input(INPUT_POST, "stockId4", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockName4 = filter_input(INPUT_POST, "stockName4", FILTER_SANITIZE_SPECIAL_CHARS);
    $stockPrice4 = filter_input(INPUT_POST, "stockPrice4", FILTER_VALIDATE_FLOAT);

    // Current date and time is obtained.
    date_default_timezone_set('GMT');
    $datetime = date("Y-m-d H:i:s");

    // All retrieved stock record parameters are stored in an associative array.
    $allStockRecords = [
        [
            "stockId" => $stockId1,
            "stockName" => $stockName1,
            "price" => $stockPrice1
        ],
        [
            "stockId" => $stockId2,
            "stockName" => $stockName2,
            "price" => $stockPrice2
        ],
        [
            "stockId" => $stockId3,
            "stockName" => $stockName3,
            "price" => $stockPrice3
        ],
        [
            "stockId" => $stockId4,
            "stockName" => $stockName4,
            "price" => $stockPrice4
        ],
    ];

    $validatedStockRecords = []; // This array only stores the valid stock records that were submitted.
    $validStockRecordNumbers = []; // Keeps track of which submitted stock records that were valid.

    // Validates each retrieved stock record.
    // Stores the valid stock records into a separate array.
    // Records the number of each valid stock record.
    for ($i = 0; $i < count($allStockRecords); $i++) {
        if ($allStockRecords[$i]["stockId"] !== false && $allStockRecords[$i]["stockId"] !== null && trim($allStockRecords[$i]["stockId"]) !== "" &&
            $allStockRecords[$i]["stockName"] !== false && $allStockRecords[$i]["stockName"] !== null && trim($allStockRecords[$i]["stockName"]) !== "" &&
            $allStockRecords[$i]["price"] !== false && $allStockRecords[$i]["price"] !== null && $allStockRecords[$i]["price"] >= 0
        ) {
            $validatedStock = $allStockRecords[$i];

            array_push($validatedStockRecords, $validatedStock); // validated stock record is stored in a separate array.
            array_push($validStockRecordNumbers, $i + 1); // validated stock record number is recorded.
        }
    }

    /** Stock Record Upload Code Block **/

    // The validated stock records are uploaded to the database.
    for ($i = 0; $i < count($validatedStockRecords); $i++) {
        // Check if the Stock ID (primary key) already exists in the database.
        $command = "SELECT COUNT(*) FROM StockUpdates 
        WHERE StockId=?";
        $stmt = $dbh->prepare($command);
        $params = [$validatedStockRecords[$i]["stockId"]];
        $success = $stmt->execute($params);

        // Returns the number of matched instances (in this case, either 1 or 0).
        $recordExists = $stmt->fetchColumn();

        // If a match is found, update the existing stock record.
        if ($success && $recordExists) {
            $command = "UPDATE StockUpdates
                        SET StockName=?, CurrentPrice=?, UpdateDateTime=?
                        WHERE StockId=?";
            $stmt = $dbh->prepare($command);
            $params = [$validatedStockRecords[$i]["stockName"], $validatedStockRecords[$i]["price"], $datetime, $validatedStockRecords[$i]["stockId"]];
            $success = $stmt->execute($params);
        // If a match is not found, insert a new entry into the table.
        } else {
            $command = "INSERT INTO StockUpdates(StockId, StockName, CurrentPrice, UpdateDateTime)
            VALUES (?, ?, ?, ?)";
            $stmt = $dbh->prepare($command);
            $params = [$validatedStockRecords[$i]["stockId"], $validatedStockRecords[$i]["stockName"], $validatedStockRecords[$i]["price"], $datetime];
            $success = $stmt->execute($params);
        }
    }
    // Valid stock record numbers are encoded in JSON format.
    echo json_encode($validStockRecordNumbers);

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