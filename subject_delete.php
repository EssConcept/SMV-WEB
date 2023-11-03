<?php
session_start();

// Check if the user is logged in
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    $query = "DELETE FROM subjects WHERE subject_id=$subject_id";
    mysqli_query($con, $query);

    Header("Location: administration.php");
}
?>