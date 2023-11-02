<?php

session_start();

	include("connection.php");
	include("functions.php");

	if ($_SERVER['REQUEST_METHOD'] == "POST") 
	{

		//Grabs data from form
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (!empty($username) && !empty($password)) {

			//Logs in the user
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
    <div class="heading">
        Elektronski portal - MajMun
    </div>
    <div class="login-box">
        <h2>Prijava</h2>
        <form method="POST">
          <div class="user-box">
            <input type="text" name="username" required>
            <label>Uporabnisko ime</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" required>
            <label>Geslo</label>
          </div>
          <input type="submit">
        </form>
      </div>
</body>
</html>