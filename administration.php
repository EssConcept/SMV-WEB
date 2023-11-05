<?php

session_start();
	
	
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['class_name'])){
            $class_name = $_POST['class_name'];
            $inner_query = "INSERT INTO classes(class_name) VALUES('$class_name')";
            mysqli_query($con, $inner_query);
        }
        elseif(isset($_POST['subject_name'])){
            $subject_name= $_POST['subject_name'];
            $inner_query = "INSERT INTO subjects(subject_name) VALUES('$subject_name')";
            mysqli_query($con, $inner_query);
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Button Display</title>
    <link rel="stylesheet" type="text/css" href="styleadministration.css">
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
    </header>
    <form method="post" id="content_form">
        <button type="submit" name="content" value="users">Uporabniki</button>
        <button type="submit" name="content" value="classes">Razredi</button>
        <button type="submit" name="content" value="subjects">Predmeti</button>
        <button type="submit" name="content" value="teachers">Profesorji</button>
        <button type="submit" name="content" value="lessons">Dodelitev predmetov</button>
    </form>

    <div id="displayArea">
        <?php
    
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            if ($content === 'users') {
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>user_id</div>
                    <div class='vnos'>username</div>
                    <div class='vnos'>name</div>
                    <div class='vnos'>surname</div>
                    <div class='vnos'>email</div>
                    <div class='vnos'>role</div>
                    <div class='vnos'>class_id</div>
                    <div class='vnos'>Spremeni</div>
                    <div class='vnos'>Izbris</div>
                </div>";

                $query = "SELECT * FROM users";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $user_id = $row['user_id'];
                        $username = $row['username'];
                        $email = $row['email'];
                        $role = $row['role'];
                        $class_id = $row['class_id'];
                        $name = $row['name'];
                        $surname = $row['surname'];

                        echo "
                        <div class='vnos-ocene'>
                            <div class='vnos'>$user_id</div>
                            <div class='vnos'>$username</div>
                            <div class='vnos'>$name</div>
                            <div class='vnos'>$surname</div>
                            <div class='vnos'>$email</div>
                            <div class='vnos'>$role</div>
                            <div class='vnos'>$class_id</div>
                            <a href='user_change.php?user_id=$user_id'>Spremeni</a>
                            <a href='user_delete.php?user_id=$user_id'>Izbriši</a>
                        </div>";
                    }
                }
                echo "<a href='createuser.php' id = 'ustvari'>Ustvari novega uporabnika</a>";

            }
            elseif ($content === 'classes') {
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>class_id</div>
                    <div class='vnos'>class_name</div>
                    <div class='vnos'>Izbris</div>
                </div>";

                $query = "SELECT * FROM classes";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $class_id = $row['class_id'];
                        $class_name = $row['class_name'];

                        echo "
                        <div class='vnos-ocene'>
                            <div class='vnos'>$class_id</div>
                            <div class='vnos'>$class_name</div>
                            <a href='class_delete.php?class_id=$class_id'>Izbriši</a>
                        </div>";
                    }
                }
                echo "
                <form method='POST'>
                    <label for='class_name'>Nov razred:</label>
                    <input type='text' name='class_name' id='class_name' required>

                    <input type='submit' value = 'Nadaljuj'>
                </form>
                ";

            }
            elseif ($content === 'subjects') {
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>subject_id</div>
                    <div class='vnos'>subject_name</div>
                    <div class='vnos'>Izbris</div>
                </div>";

                $query = "SELECT * FROM subjects";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $subject_id = $row['subject_id'];
                        $subject_name = $row['subject_name'];

                        echo "
                        <div class='vnos-ocene'>
                            <div class='vnos'>$subject_id</div>
                            <div class='vnos'>$subject_name</div>
                            <a href='subject_delete.php?subject_id=$subject_id'>Izbriši</a>
                        </div>";
                    }
                }

                echo "
                <form method='POST'>
                    <label for='subject_name'>Nov predmet:</label>
                    <input type='text' name='subject_name' id='subject_name' required>

                    <input type='submit' value = 'Nadaljuj'>
                </form>
                ";

            }
            elseif ($content === 'teachers') {
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Profesor / ica</div>
                    <div class='vnos'>Ime predmeta</div>
                    <div class='vnos'>Izbris</div>
                </div>";

                $query = "SELECT * FROM teachers";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $subject_id = $row['subject_id'];
                        $teacher_id = $row['teacher_id'];

                        $inner_query = "SELECT subject_name FROM subjects WHERE subject_id = '$subject_id'";
                        $inner_result = mysqli_query($con, $inner_query);
                        if(mysqli_num_rows($inner_result) > 0){
                            while($inner_row = mysqli_fetch_assoc($inner_result)){
                                $subject_name = $inner_row['subject_name'];

                                $inner_query_two = "SELECT * FROM users WHERE user_id = '$teacher_id'";
                                $inner_result_two = mysqli_query($con, $inner_query_two);
                                if(mysqli_num_rows($inner_result_two) > 0){
                                    while($inner_row_two = mysqli_fetch_assoc($inner_result_two)){
                                        $name = $inner_row_two['name'];
                                        $surname = $inner_row_two['surname'];

                                        echo "
                                        <div class='vnos-ocene'>
                                            <div class='vnos'>$name $surname</div>
                                            <div class='vnos'>$subject_name</div>
                                            <a href='teaches_delete.php?subject_id=$subject_id&teacher_id=$teacher_id'>Izbriši</a>
                                        </div>";
                                    }
                                }
                            }
                        }
                    }
                }
                echo "<a href='subject_assigning.php' id = 'linked'>Dodaj profesorja k predmetu</a>";

            }
            elseif($content === 'lessons'){
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Lesson_id</div>
                    <div class='vnos'>Ime razreda</div>
                    <div class='vnos'>Ime lekcije</div>
                    <div class='vnos'>Ime profesorja</div>
                    <div class='vnos'>Izbris</div>
                </div>";
                $query = "SELECT * FROM lessons";
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $lesson_id = $row['lesson_id'];
                        $class_id = $row['class_id'];
                        $lesson_name = $row['lesson_name'];
                        $teacher_id = $row['teacher_id'];

                        $inner_query = "SELECT class_name FROM classes WHERE class_id = '$class_id'";
                        $inner_result = mysqli_query($con, $inner_query);
                        if(mysqli_num_rows($inner_result) > 0){
                            while($inner_row = mysqli_fetch_assoc($inner_result)){
                                $class_name = $inner_row['class_name'];

                                $inner_query_two = "SELECT * FROM users WHERE user_id = '$teacher_id'";
                                $inner_result_two = mysqli_query($con, $inner_query_two);
                                if(mysqli_num_rows($inner_result_two) > 0){
                                    while($inner_row_two = mysqli_fetch_assoc($inner_result_two)){
                                        $teacher_name = $inner_row_two['name'];
                                        $teacher_surname = $inner_row_two['surname'];
                                        
                                        echo "
                                        <div class='vnos-ocene'>
                                            <div class='vnos'>$lesson_id</div>
                                            <div class='vnos'>$class_name</div>
                                            <div class='vnos'>$lesson_name</div>
                                            <div class='vnos'>$teacher_name $teacher_surname</div>
                                            <a href='lesson_delete.php?lesson_id=$lesson_id'>Izbriši</a>
                                        </div>";
                                    }
                                }
                            }
                        }
                    }
                }
                echo "<a href='createlesson.php' id = 'ustvari2'>Ustvari lekcijo</a>";
            }
        }
        ?>
    </div>
</body>
</html>