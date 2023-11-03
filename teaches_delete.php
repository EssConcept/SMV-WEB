<?php
session_start();

// Check if the user is logged in
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_GET['subject_id']) && isset($_GET['teacher_id'])) {
    $subject_id = $_GET['subject_id'];
    $teacher_id = $_GET['teacher_id'];

    $query = "DELETE FROM teachers WHERE subject_id=$subject_id AND teacher_id=$teacher_id";
    mysqli_query($con, $query);

    Header("Location: administration.php");
}
?>