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
    <link rel="stylesheet" type="text/css" href="styler.css">
</head>
<body>
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

                    echo "
                    <div>$assignment_name</div>
                    <div>$assignment_desc</div>
                    <div>$due_date</div>
                    ";

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
                    

                    
                    echo "<br><br><a href='deleteassignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Izbriši dodelitev</a>";
                    echo "<br><a href='lesson.php?lesson_id=$lesson_id'>Nazaj</a>";
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

                    echo "
                    <div>$assignment_name</div>
                    <div>$assignment_desc</div>
                    <div>$due_date</div>
                    ";
                    if($current_date < $due_date_time){
                    echo "
                    <form method='POST' enctype='multipart/form-data'>
                        <label for='upload_file'>Naloži rešitev:</label>
                        <input type='file' name='upload_file' id='upload_file' required><br><br>
                        <input type='submit' value='Submit'>
                    </form>
                    ";   
                    }
                                         
                    echo "<br><a href='lesson.php?lesson_id=$lesson_id'>Nazaj</a>";
                }
            }
        }

        ?>

    </div>
</body>
</html>