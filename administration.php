<?php

session_start();
	
	//Check if user is loged in
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
    <link rel="stylesheet" type="text/css" href="styler.css">
</head>
<body>
    <a href="profil.php">Nazaj na profil</a>
    <form method="post" id="content_form">
        <button type="submit" name="content" value="users">Uporabniki</button>
        <button type="submit" name="content" value="classes">Razredi</button>
        <button type="submit" name="content" value="subjects">Predmeti</button>
        <button type="submit" name="content" value="teachers">Učitelji</button>
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
                echo "<a href='createuser.php'>Ustvari novega uporabnika</a>";

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
                    <label for='class_name'>Ime razreda:</label>
                    <input type='text' name='class_name' id='class_name' required>

                    <input type='submit'>
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
                    <label for='subject_name'>Ime predmeta:</label>
                    <input type='text' name='subject_name' id='subject_name' required>

                    <input type='submit'>
                </form>
                ";

            }
            elseif ($content === 'teachers') {
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Učitelj / ica</div>
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
                echo "<a href='subject_assigning.php'>Dodaj učitelja k predmetu</a>";

            }
            else{
                //DODAJ NEK TEXT CE HOCES DA JE KAJ DISPLAYAN MEDTEM KO NIMAS NC ZBRAN
            }
        }
        ?>
    </div>
</body>
</html>