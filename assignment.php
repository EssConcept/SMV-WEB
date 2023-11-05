<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lesson_id = $_GET["lesson_id"];
        $directory = 'submissions/';
        $upload_directory = $directory . $lesson_id;
        $time_posted = date('Y-m-d H:i:s');
        $assignment_id = $_GET['assignment_id'];
        $student_id = $user_data['user_id'];
        
        if (file_exists($upload_directory)){
            $uploadedFile = $upload_directory . '/' . basename($_FILES['upload_file']['name']);
            
            if(file_exists($uploadedFile)){
                $file = basename($_FILES['upload_file']['name']);
                $file_extension = pathinfo($file, PATHINFO_EXTENSION);
                $random_string = bin2hex(random_bytes(3));
                $file_no_extension_name = pathinfo($file, PATHINFO_FILENAME);
                $file_new = $file_no_extension_name . '_' . $random_string . '.' . $file_extension;
                $new_upload_directory = $directory . $lesson_id . '/' . $file_new;

                if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $new_upload_directory)){

                    $query = "INSERT INTO assignment_submissions(assignment_id, student_id, submission_date, content)
                    VALUES('$assignment_id', '$student_id', '$time_posted', '$new_upload_directory')";
                    mysqli_query($con, $query);

                    Header("Location: lesson.php?lesson_id=$lesson_id");
                }
            }
            else{
                if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadedFile)){

                    $query = "INSERT INTO assignment_submissions(assignment_id, student_id, submission_date, content)
                    VALUES('$assignment_id', '$student_id', '$time_posted', '$uploadedFile')";
                    mysqli_query($con, $query);

                    Header("Location: lesson.php?lesson_id=$lesson_id");
                }
            }
        }
        else{
            if (mkdir($upload_directory, 0777, true)){
                $uploadedFile = $upload_directory . '/' . basename($_FILES['upload_file']['name']);
        
                if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadedFile)){

                    $query = "INSERT INTO assignment_submissions(assignment_id, student_id, submission_date, content)
                    VALUES('$assignment_id', '$student_id', '$time_posted', '$uploadedFile')";
                    mysqli_query($con, $query);

                    Header("Location: lesson.php?lesson_id=$lesson_id");
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>lessons</title>
    <link rel="stylesheet" type="text/css" href="styleassignment.css">
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
    <div>

        <?php
       
        $assignment_id = $_GET['assignment_id'];
        $lesson_id = $_GET['lesson_id'];
        $query = "SELECT * FROM assignment WHERE assignment_id = '$assignment_id'";
        $result = mysqli_query($con, $query);

        if ($user_data['role'] == 'teacher') {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $assignment_id = $row['assignment_id'];
                    $assignment_name = $row['assignment_name'];
                    $assignment_desc = $row['assignment_desc'];
                    $due_date = $row['due_date'];
                    echo "<div class='grid'>
                    <div class='vnos-ocene naslovnica'>
                        <div class='vnos'>Priimek, Ime</div>
                        <div class='vnos'>Datum Oddaje</div>
                        <div class='vnos'>Ogled in ocenjevanje</div>
                    </div>"; 

                    $inner_query = "SELECT * FROM assignment_submissions WHERE assignment_id = '$assignment_id'";
                    $inner_result = mysqli_query($con, $inner_query);
                    
                    if(mysqli_num_rows($inner_result) > 0){
                        while($inner_row = mysqli_fetch_assoc($inner_result)){
                            $student_id = $inner_row['student_id'];
                            $submission_date = $inner_row['submission_date'];

                            $inner_query_2 = "SELECT * FROM users WHERE user_id = '$student_id'";
                            $inner_result_2 = mysqli_query($con, $inner_query_2);

                            if(mysqli_num_rows($inner_result_2) > 0){
                                while($inner_row_2 = mysqli_fetch_assoc($inner_result_2)){
                                    $name = $inner_row_2['name'];
                                    $surname = $inner_row_2['surname'];

                                    echo "
                                    <div class='vnos-ocene'>
                                        <div class='vnos'>$surname $name</div>
                                        <div class='vnos'>$submission_date</div>
                                        <div class='vnos'>
                                        <a href='assignmentcheck.php?assignment_id=$assignment_id&student_id=$student_id&lesson_id=$lesson_id'
                                        class='test'>Oglejte si!</a></div>
                                    </div>
                                    ";
                                }
                            }
                        }
                    }
                    

                    
                    echo "<br><br><div id = 'div'><a href='deleteassignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id' id= 'nvm'>Izbriši dodelitev</a></div>";
                    echo "<br><div id = 'div'><a href='lesson.php?lesson_id=$lesson_id' id= 'nvm'>Nazaj</a></div>";
                }
            }
        }
        else{
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $assignment_id = $row['assignment_id'];
                    $assignment_name = $row['assignment_name'];
                    $assignment_desc = $row['assignment_desc'];
                    $due_date = $row['due_date'];
                    $due_date_time = new DateTime($due_date);
                    $current_date = new DateTime();

                    if($current_date < $due_date_time){
                    echo "
                        <div class='container'>
                        <h1>Oddaja Naloge</h1>
                        <div><b>IME NALOGE:</b> $assignment_name</div>
                        <div><b>OPIS NALOGE:</b> $assignment_desc</div>
                        <div><b>ROK ODDAJE:</b> $due_date</div><br>
                        <form method='POST' enctype='multipart/form-data'>
                            <div class='form-group'>
                                <label for='upload_file'>Nalozi datoteko:</label>
                                <input type='file' name='upload_file' id='upload_file' required>
                            </div>
                            <div class='button'><button type='submit' name='content' value='Submit'>Oddaj</button></div>
                            <a href='lesson.php?lesson_id=$lesson_id' class='btn-link'>Nazaj</a>
                    </form>
                    ";   
                    }
                                         
                
                }
            }
        }

        ?>

    </div>
</body>
</html>