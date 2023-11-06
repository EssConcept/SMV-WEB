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
    <link rel="stylesheet" type="text/css" href="styleocena.css">
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
                <a href="domacastran.php">Dom</a>        
        </div>  
    </header>
    <div class="grid">
    <div class='vnos-ocene naslovnica'>
        <div class='vnos'>Ime predmeta</div>
        <div class='vnos'>Ocena</div>
        <div class='vnos'>Ogled Predmeta</div>
    </div>
    <?php
    
    $student_id = $user_data['user_id'];

    $query = "SELECT * FROM assignment_grades WHERE student_id = '$student_id'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $assignment_id = $row['assignment_id'];
            $score = $row['score'];
            $lesson_id = $row['lesson_id'];

            $inner_query = "SELECT lesson_name FROM lessons WHERE lesson_id = '$lesson_id'";
            $inner_result = mysqli_query($con, $inner_query);
            if(mysqli_num_rows($inner_result) > 0){
                while($row = mysqli_fetch_assoc($inner_result)){
                    $lesson_name = $row['lesson_name'];

                    echo "
                    <div class='vnos-ocene'>
                        <div class='vnos'>$lesson_name</div>
                        <div class='vnos'>$score</div>
                        <div class='vnos'><a href='lesson.php?lesson_id=$lesson_id' class='test'>Oglejte si!</a></div>
                    </div>";
                }
            }
        }
    }
    
    ?>
    </div>
</body>
</html>
