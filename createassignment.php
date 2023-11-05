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
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $lesson_id = $_GET["lesson_id"];
            $assignment_name = $_POST['assignment_name'];
            $assignment_desc = $_POST['assignment_desc'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $due_date = $date . ' ' . $time;

            echo "$due_date";
            $query = "INSERT INTO assignment(assignment_name, assignment_desc, lesson_id, due_date)
            VALUES('$assignment_name', '$assignment_desc', '$lesson_id', '$due_date')";
            mysqli_query($con, $query);
            Header("Location: lesson.php?lesson_id=$lesson_id");
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>create assignment</title>
    <link rel="stylesheet" href="stylecreateass.css">
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
        <h1>Nova Naloga</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="assignment_name">Ime naloge:</label>
                <input type="text" id="assignment_name" name="assignment_name" required>
            </div>
            <div class="form-group">
                <label for="assignment_desc">Opis naloge:</label>
                <input type="text" id="assignment_desc" name="assignment_desc" required>
            </div>
            <div class="form-group">
                <label for="date">Izberi datum:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Izberi čas:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <button type="submit">Nadaljuj</button>
        </form>
        <?php

if(isset($_GET["lesson_id"])){
$lesson_id = $_GET["lesson_id"];
echo"<a href='lesson.php?lesson_id=$lesson_id' id = 'nazj'>Nazaj</a>";
} 

?>
    </div>
    
</body>
</html>