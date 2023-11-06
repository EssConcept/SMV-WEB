<?php
session_start();

// Check if the user is logged in
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    $query = "DELETE FROM classes WHERE class_id=$class_id";
    mysqli_query($con, $query);

    Header("Location: administration.php");
}
?>
