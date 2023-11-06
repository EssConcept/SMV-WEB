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
    <link rel="stylesheet" type="text/css" href="styledomacastran.css">
</head>
<body>
<header class="header-outer">
        <div class="header-inner responsive-wrapper">
            <div class="header-logo">
                <img src="profilepictures/ClassIQ.png" />
            </div>
            <div class="profilepic">
                <img src="profilepictures/me.png" alt="">
            </div>
            <nav class="header-navigation">
            <p>ClassIQ</p>
                <a href="profil.php">Profil</a>
                <a href="contacts.php">Kontakti</a>
                <?php
            if($user_data['role'] == 'student'){
                echo "<a href='ocene.php'>Ocene</a>";
            }
        ?>                
        </div>  
    </header>

    <div class="container">
        <h1>Predogled Predmetov</h1>
        <div class="grid">

            <?php

            $role = $user_data['role'];
            if($role == 'teacher'){

                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Ime predmeta</div>
                    <div class='vnos'>Razred</div>
                    <div class='vnos'>Ogled Predmeta</div>
                </div>";
                

                $teacher_id = $user_data['user_id'];
                $query = "SELECT * FROM lessons WHERE teacher_id = '$teacher_id'";
                $result = mysqli_query($con, $query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        
                        $lesson_id = $row['lesson_id'];
                        $lesson_name = $row['lesson_name'];
                        $class_id = $row['class_id'];

                        $innerQuery = "SELECT class_name FROM classes WHERE class_id = '$class_id'";
                        $innerResult = mysqli_query($con, $innerQuery);

                        if(mysqli_num_rows($innerResult) > 0){
                            while($row = mysqli_fetch_assoc($innerResult)){
                                $class_name = $row['class_name'];

                                
                                echo "
                                <div class='vnos-ocene'>
                                    <div class='vnos'>$lesson_name</div>
                                    <div class='vnos'>$class_name</div>
                                    <div class='vnos'><a href='lesson.php?lesson_id=$lesson_id' class='test'>Oglejte si!</a></div>
                                </div>";
                            }
                        }                          
                    }
                }

            }
            else if($role == 'student'){

                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Ime predmeta</div>
                    <div class='vnos'>Profesor / ica</div>
                    <div class='vnos'>Ogled Predmeta</div>
                </div>";

                $student_id = $user_data['user_id'];
                $class_id = $user_data['class_id'];

                $query = "SELECT * FROM lessons WHERE class_id = '$class_id'";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $lesson_id = $row['lesson_id'];
                        $lesson_name = $row['lesson_name'];
                        $teacher_id = $row['teacher_id'];

                        $innerQuery = "SELECT name, surname FROM users WHERE user_id = '$teacher_id'";
                        $innerResult = mysqli_query($con, $innerQuery);
                        if(mysqli_num_rows($innerResult) > 0){
                            while($row = mysqli_fetch_assoc($innerResult)){
                                $teacher_name = $row['name'];
                                $teacher_surname = $row['surname'];

                                echo "
                                <div class='vnos-ocene'>
                                    <div class='vnos'>$lesson_name</div>
                                    <div class='vnos'>$teacher_surname $teacher_name</div>
                                    <div class='vnos'><a href='lesson.php?lesson_id=$lesson_id' class='test'>Oglejte si!</a></div>
                                </div>";
                            }
                        }
                    }
                }
            }

            ?>
        </div>
    </div>
</body>
</html>
