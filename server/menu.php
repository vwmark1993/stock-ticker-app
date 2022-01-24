<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: The main user interface of the application.
 *              Handles user login authentication.
 *              Displays the stock feed to the user.
 *              Administrators are able of uploading new stock records to the database.
 *              Also allows users to log out of the system.
 */
session_start();

// Database connection.
include "connect.php";

// *** Login Authentication Code Block *** //

// Check login credentials.
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

if ($username !== null && $password !== null) {

    /** Login Authentication Code Block **/

    // Select query retrieves all existing users on the database.
    $command = "SELECT username, password FROM Users";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();

    $logins = []; // An array which holds all existing logins.

    if ($success) {
        // All usernames and corresponding passwords are stored in the array.
        while ($row = $stmt->fetch()) {
            $logins[strtolower($row["username"])] = $row["password"]; // Usernames are set to lowercase.
        }
    } else {
        echo "<h2>Database query has failed!</h2>";
    }

    // Login credentials are authenticated.
    $authenticated = false; // Boolean check.
    $admin = 0; // Used to check for administrator accounts.

    // Checks if the entered username exists.
    if (array_key_exists(strtolower($username), $logins)) {
        if ($logins[strtolower($username)] === $password) { // Correct username and password.
            $authenticated = true;

            // Check if it is an administrator account.
            $command = "SELECT admin FROM Users
                        WHERE username=?";
            $stmt = $dbh->prepare($command);
            $params = [$username];
            $success = $stmt->execute($params);

            if ($success) {
                if ($row = $stmt->fetch()) {
                    $admin = $row["admin"]; // Administrator accounts have a designated 'admin' value of 1.
                }
            } 

        } else { // Username exists but invalid password.
            echo "<br>Invalid password.<br>";
        }
    } else { // Username does not exist.
        echo "<br>Username does not exist.<br>";
    }

    if ($authenticated) { 
        // If authenticated, session data is recorded.
        $_SESSION["username"] = $username;

        // Administrator accounts are checked.
        if ($admin) {
            $_SESSION["admin"] = true;
        }
    } else {
        // Invalid login credentials. Session is terminated.
        session_unset();
        session_destroy();
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
    <script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
        crossorigin="anonymous">
    </script>
</head>

<body>
    <?php 
        // Only users who have logged in may view the content.
        if (isset($_SESSION["username"])) {

            // *** Header and Stock Table Code Block *** //

            // Retrieve the username that is stored on the database for consistency.
            // The username used to login may have been typed using different casing.
            $command = "SELECT username FROM Users
                        WHERE username=?";
            $stmt = $dbh->prepare($command);
            $params = [$_SESSION["username"]];
            $success = $stmt->execute($params);

            $userid = "";

            if ($success) {
                if ($row = $stmt->fetch()) {
                    $userid = $row["username"];
                }
            }

            // The user will know if they've logged into an administrator account.
            if (isset($_SESSION["admin"])) {
                $userid .= "<em>(Administrator)</em>";
            }

            // Header and stock feed are displayed.
            echo "
                <header>
                    <h1 id='small-screen-only'>Welcome, $userid.</h1>
                    <nav>
                        <p id='nav-heading'>Welcome, $userid.</p>
                        <div id='nav-container'>
                            <div id='toggle-button' class='nav-button'>Add Stock</div>
                            <a class='nav-button' href='logout.php'>Logout</a>
                        </div>
                    </nav>
                </header>
                <div class='get-stock-container'>
                    <h2 id='stock-table-header' class='blue-text'>'Live' Stock Feed:</h2>
                    <div id='stock-table-length'>
                        <input type='button' value='5'>
                        <input type='button' value='10' class='selected'>
                        <input type='button' value='15'>
                        <input type='button' value='20'>
                        <input type='button' value='25'>
                    </div>
                    <p class='small-text'>*Stock feed automatically refreshes every 10 seconds.</p>
                    <table id='stock-table'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Name</th>
                                <th>Price (USD)</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>    
                        <tbody id='stock-table-records'>
                            <!-- *** Stocks are displayed here. *** -->
                        </tbody>
                    </table>
                </div>
            ";

            // *** Add Stock Code Block *** //

            // This section is only visible if the user clicks on the 'Add Stocks' button.
            if (isset($_SESSION["admin"])) {
                echo "
                    <form 
                        id='add-stock-form'
                        class='add-stock-container'
                        name='addStockForm'
                        method='post'
                        action='addStock.php'
                    >                
                        <h2 class='add-stock-header blue-text'>Enter the stock records:</h2>
                        <fieldset class='add-stock-fieldset' name='stockRecord1'>
                            <legend>&nbsp;&nbsp;Stock Record [1]&nbsp;&nbsp;</legend>
                            <label for: stockId1>ID:</label>
                            <input type='text' name='stockId1' placeholder='Example: ABC' value='' size='10' maxlength='6' pattern='[A-Za-z0-9.]{1,6}' title='Please enter a valid stock ID containing only letters, numbers and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockName1>Name:</label>
                            <input type='text' name='stockName1' placeholder='Example: ABC Corporation' value='' size='30' maxlength='40' pattern='[A-Za-z0-9. ]{1,40}' title='Please enter a valid stock name containing only letters, numbers, spaces and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockPrice1>Price:</label>
                            <input type='text' name='stockPrice1' placeholder='Example: 120.96' value='' size='12' maxlength='10' pattern='[0-9.]{1,10}' title='Please enter a valid stock price.'>
                        </fieldset>
                        <br>
                        <fieldset class='add-stock-fieldset' name='stockRecord2'>
                            <legend>&nbsp;&nbsp;Stock Record [2]&nbsp;&nbsp;</legend>
                            <label for: stockId2>ID:</label>
                            <input type='text' name='stockId2' placeholder='Example: ABC' value='' size='10' maxlength='6' pattern='[A-Za-z0-9.]{1,6}' title='Please enter a valid stock ID containing only letters, numbers and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockName2>Name:</label>
                            <input type='text' name='stockName2' placeholder='Example: ABC Corporation' value='' size='30' maxlength='40' pattern='[A-Za-z0-9. ]{1,40}' title='Please enter a valid stock name containing only letters, numbers, spaces and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockPrice2>Price:</label>
                            <input type='text' name='stockPrice2' placeholder='Example: 120.96' value='' size='12' maxlength='10' pattern='[0-9.]{1,10}' title='Please enter a valid stock price.'>
                        </fieldset>
                        <br>
                        <fieldset class='add-stock-fieldset' name='stockRecord3'>
                            <legend>&nbsp;&nbsp;Stock Record [3]&nbsp;&nbsp;</legend>
                            <label for: stockId3>ID:</label>
                            <input type='text' name='stockId3' placeholder='Example: ABC' value='' size='10' maxlength='6' pattern='[A-Za-z0-9.]{1,6}' title='Please enter a valid stock ID containing only letters, numbers and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockName3>Name:</label>
                            <input type='text' name='stockName3' placeholder='Example: ABC Corporation' value='' size='30' maxlength='40' pattern='[A-Za-z0-9. ]{1,40}' title='Please enter a valid stock name containing only letters, numbers, spaces and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockPrice3>Price:</label>
                            <input type='text' name='stockPrice3' placeholder='Example: 120.96' value='' size='12' maxlength='10' pattern='[0-9.]{1,10}' title='Please enter a valid stock price.'>
                        </fieldset>
                        <br>
                        <fieldset class='add-stock-fieldset' name='stockRecord4'>
                            <legend>&nbsp;&nbsp;Stock Record [4]&nbsp;&nbsp;</legend>
                            <label for: stockId4>ID:</label>
                            <input type='text' name='stockId4' placeholder='Example: ABC' value='' size='10' maxlength='6' pattern='[A-Za-z0-9.]{1,6}' title='Please enter a valid stock ID containing only letters, numbers and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockName4>Name:</label>
                            <input type='text' name='stockName4' placeholder='Example: ABC Corporation' value='' size='30' maxlength='40' pattern='[A-Za-z0-9. ]{1,40}' title='Please enter a valid stock name containing only letters, numbers, spaces and periods.'>
                            &nbsp;&nbsp;&nbsp;<label for: stockPrice4>Price:</label>
                            <input type='text' name='stockPrice4' placeholder='Example: 120.96' value='' size='12' maxlength='10' pattern='[0-9.]{1,10}' title='Please enter a valid stock price.'>
                        </fieldset>
                        <br>
                        <button type='submit'>Submit</button>
                        <button type='reset'>Clear</button>
                    </form>
                    <br>
                    <p id='add-stock-message'></p>
                ";
            } else {
                echo "<h2 class='add-stock-header add-stock-container blue-text'>You are not authorized to use this feature. Please contact an administrator for assistance.</h2><br>";
            }
            echo "<script type='text/javascript' src='../js/index.js'></script>";
        // If an unauthorized person tries to view the webpage without logging in, they'll be redirected to 'index.php'.
        } else {
            echo "<a class='text-link' href='../index.php'>Please login.</a>";
        }
    ?>
</body>
</html>