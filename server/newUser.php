<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: Handles the registration of new accounts to the system.
 */

session_start();

// Database connection.
include "connect.php";

// Check login credentials.
$newUsername = filter_input(INPUT_POST, "newUsername", FILTER_SANITIZE_SPECIAL_CHARS);
$newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_SPECIAL_CHARS);
$adminCheck = filter_input(INPUT_POST, "adminCheck", FILTER_VALIDATE_BOOLEAN);

$paramsRetrieved = false; // Boolean check for unauthorized users.

if ($newUsername !== null && $newPassword !== null) {

    $paramsRetrieved = true;

    /** New User Registration Code Block **/

    // Check if username (primary key) already exists in the database.
    $command = "SELECT COUNT(*) FROM Users 
    WHERE username=?";
    $stmt = $dbh->prepare($command);
    $params = [$newUsername];
    $success = $stmt->execute($params);

    // Returns the number of matched instances (in this case, either 1 or 0).
    $usernameExists = $stmt->fetchColumn();

    // If username already exists, do nothing.
    if ($success && $usernameExists) {

        echo "<br>Username already exists.<br>";
        echo "<a class='text-link' href='../signup.php'>Try Again.</a>";

    // If username does not exist, insert new entry into the table.
    } else if ($success && !$usernameExists) {
        $command = "INSERT INTO Users (username, password, admin)
                VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($command);
        $params = [$newUsername, $newPassword, $adminCheck];
        $success = $stmt->execute($params);

        echo "<br>Your account has been registered!<br>";
        echo "<a class='text-link' href='../index.php'>Back to Login Page.</a>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>COMP 10065 Assignment 5 - Menu Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
</head>
<body>
    <?php 
        // If already logged in, the user will be redirected to 'menu.php'.
        if (isset($_SESSION["username"])) {
            header("Location: menu.php");
        // If an unauthorized person tries to access this webpage without first logging in, they'll be redirected to 'index.php".
        } else if (!$paramsRetrieved) {
            echo "<a class='text-link' href='../index.php'>Please login.</a>";
        } 
    ?>
</body>
</html>