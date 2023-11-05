<?php

session_start();

	include("connection.php");
	include("functions.php");

	if ($_SERVER['REQUEST_METHOD'] == "POST") 
	{

	
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (!empty($username) && !empty($password)) {

		
			$query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
			$result = mysqli_query($con, $query);

			if ($result) {
				if ($result && mysqli_num_rows($result) > 0) {
					$user_data = mysqli_fetch_assoc($result);

					if ($user_data['password'] === $password) {
						$_SESSION['user_id'] = $user_data['user_id'];

						if($user_data['username'] == 'Admin'){
							header("Location: profil.php");
						}
						else{
							header("Location: domacastran.php");
						}
					}
					else{
						echo "Wrong password to the username given.";
					}
				}
				else{
					echo "Username does not exist";
				}
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
<div class="header">
	<div class="lamal"> <div class="lamal2">ClassIQ</div><br><img src="profilepictures/ClassIQ.png" alt="ClassIQ Logo"></div>
        
    </div>
    <div class="login-box">
        <h2>Prijava</h2>
        <form method="POST">
          <div class="user-box">
            <input type="text" name="username" required placeholder="Uporabnisko Ime">
          </div>
          <div class="user-box">
            <input type="password" name="password" required placeholder="Geslo">
          </div>
          <input type="submit" value = 'Nadaljuj'>
        </form>
      </div>
	  <footer class="footer">
        <p>ClassIQ Spletna Ucilnica</p>
        <p>&copy; ClassIQ 2023</p>
    </footer>
</body>
</html>