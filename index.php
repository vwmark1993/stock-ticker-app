<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: Login webpage.
 *              Prompts users to enter their login information.
 */

session_start();

// Redirects to the main menu if the user is already logged in.
if (isset($_SESSION["username"])) {
    header("Location: server/menu.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<title>COMP 10065 Assignment 5 - Login Page</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <br>
    <h1>Please Log In</h1>
    <form method="post" action="server/menu.php">
        <input type="text" name="username" placeholder="Username" value="" maxlength="12" pattern="[A-Za-z0-9]{1,20}" title="Please enter a username containing only letters and numbers." required><br>
        <input type="password" name="password" placeholder="Password" value="" maxlength="20" pattern="[A-Za-z0-9]{1,20}" title="Please enter a password containing only letters and numbers." required><br>
        <button type='submit'>Login</button>
        <button type='reset'>Clear</button>
    </form>
    <a class="text-link" href="signup.php">Don't have an account?</a>
</body>

</html>