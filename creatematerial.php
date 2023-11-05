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
    <link rel="stylesheet" href="stylecreatematerial.css">
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
    <div class="container">
        <h1>Novo Gradivo</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="material_name">Ime gradiva:</label>
                <input type="text" id="material_name" name="material_name" required>
            </div>
            <div class="form-group">
                <label for="upload_file">Naloži gradivo:</label>
                <input type="file" id="upload_file" name="upload_file" required>
            </div>
            <button type="submit">Nadaljuj</button><br>
            <?php

        if(isset($_GET["lesson_id"])){
        $lesson_id = $_GET["lesson_id"];
        echo"<a href='lesson.php?lesson_id=$lesson_id' id = 'nazj'>Nazaj</a>";
        } 

    ?>
        </form>
    
</body>
</html>