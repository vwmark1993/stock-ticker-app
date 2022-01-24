<?php
/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created" July 26, 2020
 * Description: Provides the connection to the phpMyAdmin database.
 */

try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=000803494",
        "root",
        "" 
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
?>