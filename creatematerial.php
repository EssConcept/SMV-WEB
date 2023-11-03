<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if($user_data['role'] != 'teacher'){
        Header("Location: logout.php");
    }
    else{
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lesson_id = $_GET["lesson_id"];
            $material_name = $_POST['material_name'];
            $directory = 'material/';
            $upload_directory = $directory . $lesson_id;
            $time_posted = date('Y-m-d H:i:s');

            
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

                        $query = "INSERT INTO study_material(material_name, lesson_id, time_posted, material_path)
                        VALUES('$material_name', '$lesson_id', '$time_posted', '$new_upload_directory')";
                        mysqli_query($con, $query);

                        Header("Location: lesson.php?lesson_id=$lesson_id");
                    }
                }
                else{
                    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadedFile)){

                        $query = "INSERT INTO study_material(material_name, lesson_id, time_posted, material_path)
                        VALUES('$material_name', '$lesson_id', '$time_posted', '$uploadedFile')";
                        mysqli_query($con, $query);

                        Header("Location: lesson.php?lesson_id=$lesson_id");
                    }
                }
            }
            else{
                if (mkdir($upload_directory, 0777, true)){
                    $uploadedFile = $upload_directory . '/' . basename($_FILES['upload_file']['name']);
            
                    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadedFile)){

                        $query = "INSERT INTO study_material(material_name, lesson_id, time_posted, material_path)
                        VALUES('$material_name', '$lesson_id', '$time_posted', '$uploadedFile')";
                        mysqli_query($con, $query);

                        Header("Location: lesson.php?lesson_id=$lesson_id");
                    }
                }
            }
        }
    }


    

?>
<!DOCTYPE html>
<html>
<head>
    <title>create material</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="material_name">Ime gradiva:</label>
        <input type="text" name="material_name" id="material_name" required><br><br>

        <label for="upload_file">Naloži gradivo:</label>
        <input type="file" name="upload_file" id="upload_file" required><br><br>

        <input type="submit" value="Submit">
    </form>
    <?php

        if(isset($_GET["lesson_id"])){
        $lesson_id = $_GET["lesson_id"];
        echo"<a href='lesson.php?lesson_id=$lesson_id'>Nazaj</a>";
        } 

    ?>
</body>
</html>