<?php

//Grabs data from database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eclassesdb";

//Check if we have connection to the database
if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Connection to data base failed!");
}

?>