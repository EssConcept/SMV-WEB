<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if($user_data['role'] != 'teacher'){
        Header("Location: logout.php");
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $grade = $_POST['grade'];
        $lesson_id = $_GET["lesson_id"];
        $assignment_id = $_GET['assignment_id'];
        $student_id = $_GET['student_id'];

        $query = "INSERT INTO assignment_grades(assignment_id, student_id, score, lesson_id)
        VALUES('$assignment_id', '$student_id', '$grade', '$lesson_id')";
        mysqli_query($con, $query);

        Header("Location: assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>lessons</title>
    <link rel="stylesheet" type="text/css" href="stylerazred.css">
</head>
<body>
    <div>
        <?php
        
        $lesson_id = $_GET["lesson_id"];
        $assignment_id = $_GET['assignment_id'];
        $student_id = $_GET['student_id'];

        $query_1 = "SELECT * FROM users WHERE user_id = '$student_id'";
        $result_1 = mysqli_query($con, $query_1);

        if(mysqli_num_rows($result_1) > 0){
            while($row = mysqli_fetch_assoc($result_1)){
                $name = $row['name'];
                $surname = $row['surname'];

                echo "
                <div>$surname $name</div>";
                
            }
        }

        $query_2 = "SELECT * FROM assignment_submissions WHERE assignment_id = '$assignment_id' AND student_id = '$student_id'";
        $result_2 = mysqli_query($con, $query_2);

        if(mysqli_num_rows($result_2) > 0){
            while($row = mysqli_fetch_assoc($result_2)){
                $submission_date = $row['submission_date'];
                $content_path = $row['content'];
                
                echo "<div><a href='$content_path' download>Prenesi datoteko</a>$submission_date</div>";
                echo "
                <br><div>
                    <form method='POST'>
                        <label for='grade'>Ocena:</label>
                        <input type='number' id='grade' name='grade' min='1' max='5' required>
                        <input type='submit' value='Submit'>
                    </form>
                </div>";
            }
        }
        echo "<br><a href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Nazaj</a>";
        ?>
    </div>
</body>
</html>