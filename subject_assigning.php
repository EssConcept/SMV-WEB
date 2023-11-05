<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylerazred.css">
</head>
<body>
    <div>
        <form method="POST">
        <label for="teacher">Učitelj / ica:</label>
        <select name="teacher" id="teacher">
        <?php
        
        $query = "SELECT * FROM users WHERE role = 'teacher'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $user_id = $row['user_id'];
                $name = $row['name'];
                $surname = $row['surname'];
                
                echo "<option value='$user_id'>$name $surname</option>";
            }
        }
        ?>
        </select>

        <label for="subject">Predmet:</label>
        <select name="subject" id="subject">
        <?php
        
        $query = "SELECT * FROM subjects";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $subject_id = $row['subject_id'];
                $subject_name = $row['subject_name'];
                
                echo "<option value='$subject_id'>$subject_name</option>";
            }
        }
        
        ?>
        </select>
        <input type="submit">
        </form>
        <div>
            <?php
            
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                $subject_id = $_POST['subject'];
                $teacher_id = $_POST['teacher'];

                $query = "INSERT INTO teachers(teacher_id, subject_id) VALUES($teacher_id, $subject_id)";
                mysqli_query($con, $query);
            }
            
            ?>
        </div>
        <a href="administration.php">Nazaj</a>
    </div>
</body>
</html>
