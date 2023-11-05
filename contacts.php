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
    <link rel="stylesheet" type="text/css" href="stylecontacts.css">
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
                <a href="domacastran.php">Dom</a>
                <?php
            if($user_data['role'] == 'student'){
                echo "<a href='ocene.php'>Ocene</a>";
            }
        ?>                
        </div>  
    </header> <br> 
    <div class="grid">
        <?php
        echo "
        <div class='vnos-ocene naslovnica'>
            <div class='vnos'>Priimek, Ime</div>
            <div class='vnos'>E-Posta</div>
        </div>";

        $query = "SELECT email, name, surname FROM users WHERE role='teacher'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $surname = $row['surname'];
                $email = $row['email'];

                echo "
                <div class='vnos-ocene'>
                    <div class='vnos'>$surname, $name</div>
                    <div class='vnos'>$email</div>
                </div>
                ";
            }
        }
        ?>
    </div>
</body>
</html>

