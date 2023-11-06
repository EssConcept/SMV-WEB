<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $teacher_id = $_POST['teacher_id'];
        $class_id = $_POST['class_id'];
        $subject_name = $_POST['subject_name'];
        
        $query = "INSERT INTO lessons(class_id, lesson_name, teacher_id) 
        VALUES($class_id, '$subject_name', $teacher_id)";
        mysqli_query($con, $query);

        Header("Location: administration.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styler.css">
</head>
<body>
    <div>
        <form method="POST">
            <label for="teacher_id">Profesor / ica:</label>
            <select id="teacher_id" name="teacher_id">
                <?php
                
                $query_1 = "SELECT * FROM users WHERE role='teacher'";
                $result_1 = mysqli_query($con, $query_1);
                if(mysqli_num_rows($result_1) > 0){
                    while($row_1 = mysqli_fetch_assoc($result_1)){
                        $teacher_id = $row_1['user_id'];
                        $teacher_name = $row_1['name'];
                        $teacher_surname = $row_1['surname'];

                        echo "
                        <option value='$teacher_id'>$teacher_surname $teacher_name</option>
                        ";
                    }
                }
                
                ?>
            </select>
            <label for="class_id">Razred:</label>
            <select id="class_id" name="class_id">
            <?php
                
                $query_2 = "SELECT * FROM classes";
                $result_2 = mysqli_query($con, $query_2);
                if(mysqli_num_rows($result_2) > 0){
                    while($row_2 = mysqli_fetch_assoc($result_2)){
                        $class_id = $row_2['class_id'];
                        $class_name = $row_2['class_name'];

                        echo "
                        <option value='$class_id'>$class_name</option>
                        ";
                    }
                }
                
                ?>
            </select>

            <label for="subject_name">Predmet:</label>
            <select id="subject_name" name="subject_name">
            <?php
                
                $query_3 = "SELECT * FROM subjects";
                $result_3 = mysqli_query($con, $query_3);
                if(mysqli_num_rows($result_3) > 0){
                    while($row_3 = mysqli_fetch_assoc($result_3)){
                        $subject_id = $row_3['subject_id'];
                        $subject_name = $row_3['subject_name'];

                        echo "
                        <option value='$subject_name'>$subject_name</option>
                        ";
                    }
                }
                
                ?>
            </select>
            <button type="submit">Submit</button>
        </form>
        <a href='administration.php'>Nazaj</a>
    </div>
</body>
</html>