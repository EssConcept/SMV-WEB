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
    <link rel="stylesheet" type="text/css" href="stylerazred.css">
</head>
<body>
    <form method="post">
        <input type="submit" name="material" value="Material">
        <input type="submit" name="assignments" value="Assignments">
    </form>
    
    <div>
        <?php
        if(isset($_POST['assignments'])){
            if(isset($_GET["lesson_id"])){
                $lesson_id = $_GET["lesson_id"];

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
                                <a class='vnos' href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Ogelej si dodelitev</a>
                            </div>
                            ";
                        }
                    }
                    echo "<a href='createassignment.php?lesson_id=$lesson_id'>Ustvari dodelitev</a>";
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
                                    <div class='vnos'>$due_date</div>
                                    <a class='vnos' href='assignment.php?assignment_id=$assignment_id&lesson_id=$lesson_id'>Ogelej si dodelitev</a>
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
                            </div>
                            ";
                        }
                    }
                    echo"<a href='creatematerial.php?lesson_id=$lesson_id'>Ustvari gradivo</a>";
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
        echo "<br><a href='domacastran.php'>Domov</a>";

        ?>
    </div>
</body>
</html>