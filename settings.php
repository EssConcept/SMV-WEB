<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $password_1 = $_POST['new_password'];
        $password_2 = $_POST['new_password_2'];
        $user_id = $user_data['user_id'];
        if($password_1 != $password_2){
            echo "Vnešena gesla se ne ujemata";
        }
        else{
            $query = "UPDATE users SET password = '$password_1' WHERE user_id = '$user_id'";
            mysqli_query($con, $query);
            Header("Location: profil.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesettings.css">
</head>
<body>
    <div class="header">
	<div class="lamal"> <div class="lamal2">ClassIQ</div><br><img src="profilepictures/ClassIQ.png" alt="ClassIQ Logo"></div>
        
    </div>
    <div class="login-box">
        <h2>Sprememba Gesla</h2>
        <form method="POST">
          <div class="user-box">
            <input id="new_password" type="password" name="new_password" required placeholder="Novo geslo">
          </div>
          <div class="user-box">
          <input id="new_password_2" type="password" name="new_password_2" required placeholder="Ponovi geslo">
          </div>
          <input type="submit" value = 'Nadaljuj'>
          
        </form> <br>
       <div id="div"><a href="profil.php" id="nvm">Nazaj</a></div>
      </div>
	  <footer class="footer">
        <p>ClassIQ Spletna Ucilnica</p>
        <p>&copy; ClassIQ 2023</p>
    </footer>
</body>
</html>