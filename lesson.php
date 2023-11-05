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
    <title>lessons</title>
    <link rel="stylesheet" type="text/css" href="stylelesson.css">
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
    </header><br>
    <form method="post">
        <div class="lamal">
        <input type="submit" name="material" value="Gradivo">
        <input type="submit" name="assignments" value="Naloge">
        </div>
    </form>
    
    <div class="grid">
        <?php


        if(isset($_POST['assignments'])){
            if(isset($_GET["lesson_id"])){
                $lesson_id = $_GET["lesson_id"];
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Ime naloge</div>
                    <div class='vnos'>Rok Oddaje</div>
                    <div class='vnos'>Ogled naloge</div>
                </div>";
                if ($user_data['role'] == 'teacher') {
                    $query = "SELECT * FROM assignment WHERE lesson_id = '$lesson_id' ORDER BY assignment_id";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $assignment_id = $row['assignment_id'];
                            $assignment_name = $row['assignment_name'];
                            $due_date = $row['due_date'];

                            echo "
                            <div class='vnos-ocene'>
                                <div class='vnos'>$assignment_name</div>
                                <div class='vnos'>$due_date</div>
                                <a class='vnos' href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Oglej si nalogo</a>
                            </div><br>
                            ";
                        }
                    }
                    echo "<div id = 'div'><a href='createassignment.php?lesson_id=$lesson_id' id= 'nvm'>Ustvari Nalogo</a></div>";
                }
                else{
                   
                    $query = "SELECT * FROM assignment WHERE lesson_id = '$lesson_id'";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $assignment_id = $row['assignment_id'];
                            $assignment_name = $row['assignment_name'];
                            $due_date = $row['due_date'];
                            $due_date_time = new DateTime($due_date);
                            $current_date = new DateTime();

                            if($current_date < $due_date_time){
                                echo "   
                                <div class='vnos-ocene'>
                                    <div class='vnos'>$assignment_name</div>
                                    <div class='vnos' id= 'oddaja'>$due_date</div>
                                    <a class='vnos' href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Oglej si nalogo</a>
                                </div>
                                ";
                            }
                        }
                    }
                }
            }
            else{
                Header("Location: domacastran.php");
            }
        } 
        else{
            if(isset($_GET["lesson_id"])){
                $lesson_id = $_GET["lesson_id"];
                echo "
                <div class='vnos-ocene naslovnica'>
                    <div class='vnos'>Ime Gradiva</div>
                    <div class='vnos'>Datum vnosa</div>
                    <div class='vnos'>Prenesi Datoteko</div>
                </div>";
                if ($user_data['role'] == 'teacher') {
                    $query = "SELECT * FROM study_material WHERE lesson_id = '$lesson_id'";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $material_name = $row['material_name'];
                            $time_posted = $row['time_posted'];
                            $material_path = $row['material_path'];

                            echo"
                            <div class='vnos-ocene'>
                                <div class='vnos'>$material_name</div>
                                <div class='vnos'>$time_posted</div>
                                <a class='vnos' href='$material_path' download>Prenesi datoteko</a>
                            </div><br>
                            ";
                        }
                    }
                    echo"<div id = 'div'><a href='creatematerial.php?lesson_id=$lesson_id' id= 'nvm'>Ustvari Gradivo</a></div>";
                }
                else{
                    $query = "SELECT * FROM study_material WHERE lesson_id = '$lesson_id' ORDER BY material_id";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $material_name = $row['material_name'];
                            $time_posted = $row['time_posted'];
                            $material_path = $row['material_path'];

                            echo"
                            <div class='vnos-ocene'>
                                <div class='vnos'>$material_name</div>
                                <div class='vnos'>$time_posted</div>
                                <a class='vnos' href='$material_path' download>Prenesi datoteko</a>
                            </div>
                            ";
                        }
                    }
                }
            }
            else{
                Header("Location: domacastran.php");
            }
        }
        

        ?>
    </div>
</body>
</html>