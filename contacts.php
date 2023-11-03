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
    <link rel="stylesheet" type="text/css" href="styler.css">
</head>
<body>
    <div><a href="domacastran.php">Domov</a></div>
    <div>
        <?php
        
        $query = "SELECT email, name, surname FROM users WHERE role='teacher'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $surname = $row['surname'];
                $email = $row['email'];

                echo "
                <div>$surname, $name</div>
                <div>$email</div>
                ";
            }
        }
        
        ?>
    </div>
</body>
</html>
