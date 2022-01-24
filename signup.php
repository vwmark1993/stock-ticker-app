<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: Account registration webpage.
 *              Prompts users to create a new account.
 *              They have the option of creating either a standard user or administrator account.
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
		<title>COMP 10065 Assignment 5 - Signup Page</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <br>
    <h1>Account Registration</h1>
    <form method="post" action="server/newUser.php">
        <input type="text" name='newUsername' placeholder="New Username" value="" maxlength="12" pattern="[A-Za-z0-9]{1,20}" title="Please enter a username containing only letters and numbers." required><br>
        <input type="password" name="newPassword" placeholder="New Password" value="" maxlength="20" pattern="[A-Za-z0-9]{1,20}" title="Please enter a password containing only letters and numbers." required><br>
        <br>
        <p>*Administrator accounts are allowed to upload new stock records to the database.</p>
        <br>
        <fieldset name="accountType">
            <legend>&nbsp;&nbsp;Account Type&nbsp;&nbsp;</legend>
            <input class="radio-element" type="radio" id="user" name="adminCheck" value=0 checked>
            <label class="radio-element" for="user">User</label>
            <input class="radio-element" type="radio" id="admin" name="adminCheck" value=1>
            <label class="radio-element" for="expert">Administrator</label>
        </fieldset>
        <button type='submit'>Signup</button>
        <button type='reset'>Clear</button>
    </form>
    <a class="text-link" href="index.php">Already have an account?</a>
</body>

</html>