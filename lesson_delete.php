<?php
session_start();

// Check if the user is logged in
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_GET['lesson_id'])) {
    $lesson_id = $_GET['lesson_id'];

    $query = "DELETE FROM lessons WHERE lesson_id=$lesson_id";
    mysqli_query($con, $query);

    Header("Location: administration.php");
}
?>