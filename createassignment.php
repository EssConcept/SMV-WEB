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
</head>
<body>
    <form method="POST">
        <label for="assignment_name">Ime dodelitve:</label>
        <input type="text" name="assignment_name" id="assignment_name" required><br><br>

        <label for="assignment_desc">Opis dodelitve:</label>
        <input type="text" name="assignment_desc" id="assignment_desc" required><br><br>

        <label for="date">Izberi datum:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="time">Izberi čas:</label>
        <input type="time" id="time" name="time" required><br><br>

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