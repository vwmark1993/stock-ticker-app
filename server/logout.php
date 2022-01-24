<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: Logs the user out of the system and ends the session.
 */

session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
</head>

<body>
    <?php
        //If a user logged out, a message will be displayed and they'll be redirected to 'index.php'. 
        if (isset($_SESSION["username"])) {
            session_unset();
            session_destroy();
            echo "
                <br>
                <h1>You are now logged out.</h1>
                <a class='text-link' href='../index.php'>Log in again.</a>
            ";
        // If not logged in, they will be redirected to 'index.php' anyway. 
        } else { 
            echo "<a class='text-link' href='../index.php'>Please login.</a>";
        } 
    ?>
</body>

</html>