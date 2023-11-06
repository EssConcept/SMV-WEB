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
    <link rel="stylesheet" type="text/css" href="styleasscheck.css">
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
                <a href="contacts.php">Kontakt</a>
                <a href='domacastran.php'>Dom</a>               
        </div>  
    </header>
    <div class="grid">
    <div class='vnos-ocene naslovnica'>
            <div class='vnos'>Priimek, Ime</div>
            <div class='vnos'>Datum Oddaje</div>
            <div class='vnos'>Prenesi Datoteko</div>
            <div class='vnos'>Ocena</div>
        </div>
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
                ";
                
            }
        }

        $query_2 = "SELECT * FROM assignment_submissions WHERE assignment_id = '$assignment_id' AND student_id = '$student_id'";
        $result_2 = mysqli_query($con, $query_2);

        if(mysqli_num_rows($result_2) > 0){
            while($row = mysqli_fetch_assoc($result_2)){
                $submission_date = $row['submission_date'];
                $content_path = $row['content'];
                
                echo "
                <div class='vnos-ocene'>
                <div class='vnos'>$surname $name</div>
                                    <div class='vnos'>$submission_date</div>
                                    <a href='$content_path' class='vnos'>Prenesi datoteko</a>
                                    <div class='vnos'><form method='POST'>
                                    <label for='grade'>Ocena:</label>
                                    <input type='number' id='grade' name='grade' min='1' max='5' required>
                                     <button type='submit'>Potrdi</button>
                                </form></div>
                                </div>";
              
            }
        }
        echo "<br><div id='div'><a href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id' id='nvm'>Nazaj</a></div>";
        ?>
    </div>
</body>
</html>