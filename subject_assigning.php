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
    <link rel="stylesheet" type="text/css" href="stylesubjectass.css">
</head>
<body>
<header class="header-outer">
        <div class="header-inner responsive-wrapper">
            <div class="header-logo">
                <img src="profilepictures/ClassIQ.png" />
            </div>
            <?php

$user_id = $user_data['user_id'];
$img_query = "SELECT profile_picture_location FROM users WHERE user_id=$user_id";
$result = mysqli_query($con, $img_query);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $img_src = $row['profile_picture_location'];
        echo "<div class='profilepic'><img src='$img_src' alt=''></div>";
    }
}

?>
            <nav class="header-navigation">
            <p>ClassIQ</p>
                <a href="profil.php">Profil</a>
                <a href="createuser.php">Nazaj</a>           
        </div>  
    </header> <br>
    <div class="container">
        <form method="POST">
        <label for="teacher">Profesor / ica:</label>
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
        <input type="submit" value="Nadaljuj">
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
        <a href="administration.php" id="u">Nazaj</a>
    </div>
</body>
</html>
