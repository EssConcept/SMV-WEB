<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    $assignment_id = $_GET['assignment_id'];
    $lesson_id = $_GET['lesson_id'];
    if(isset($assignment_id)){
        $query = "DELETE FROM assignment WHERE assignment_id = '$assignment_id'";
        mysqli_query($con, $query);
        Header("Location: lesson.php?lesson_id=$lesson_id");
    }

?>