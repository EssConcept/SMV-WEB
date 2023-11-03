<?php
session_start();

// Check if the user is logged in
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $query = "DELETE FROM users WHERE user_id=$user_id";
    mysqli_query($con, $query);

    Header("Location: administration.php");
}
?>
