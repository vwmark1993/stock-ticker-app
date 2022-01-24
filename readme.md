##Summary:
This culminating assignment features a full-stack web application which utilizes JavaScript, jQuery, PHP and MySQL. The program is a very simplified stock ticker application which displays stock information to the user. The user is required to log into the system to access the stock information. If the user does not have an account, he/she may register a new account. Administrator accounts may add new stock records to the database table which will then be viewable by all users of the system.

##Component Files:

#index.php
The landing and login page of the application. Prompts users to log into an existing account. Validates the username and password the user enters. If the user does not have an existing account, they will be redirected to ‘signup.php’.

#signup.php
Allows new users to register an account to the system. They have the option of creating either a standard user or an administrator account. Sends the account registration information to ‘newUser.php’. If the user wishes to log in with an existing account, they will be redirected to ‘index.php’.

#newUser.php
Handles the registration of new accounts in the system. Receives input fields from ‘signup.php’ and uses them to create a new user record in the database. Checks if the chosen username already exists in the database. Inserts a new user record into the database only if the username is not a duplicate. After successful registration, the user will then be redirected to ‘index.php’.

#menu.php
The main user interface of the application. Here is where the stock records are displayed to the users. Administrator accounts have the option of adding new stock records to the database. The user may also log out of the system, which will redirect them to ‘logout.php’.

#getStocks.php
Retrieves the ten most recent stock records from the database and stores them in an associative array. The array is then encoded into JSON format.

#addStocks.php
Administrators may add/update stock records to the database. Prompts the user to input stock record information. Checks if an existing stock of the same ID is already in the database table. If the stock ID doesn’t already exist, insert the record into the database. If the stock ID already exists, update the stock record. Redirects back to ‘menu.php’ upon successful submission.

#logout.php
Logs the user out of the system and ends the session. Redirects the user to ‘index.php’.

#connect.php
Provides the connection to the database and its associated tables.

#index.js
Handles all the AJAX requests for ‘menu.php’. Also provides event handlers for displaying stock information on initialization, updating the stock information and when the user wishes to add new stock records. Coded using jQuery.

#index.css
Provides stylization for every webpage. 

