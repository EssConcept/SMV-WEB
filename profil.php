<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylep.css">
    <title>Document</title>
</head>
<body>
    <div class="heading">
        Elektronski portal - MajMun
    </div>
    <div class="gridkontejner">
        <?php
        $user = $user_data['username'];
        $query = "SELECT * FROM users WHERE username = '$user'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $username = $row['username'];
                $email = $row['email'];
                $name = $row['name'];
                $surname = $row['surname'];
                $pfp = $row['profile_picture_location'];
                
                if($username == 'Admin'){
                    echo "
                    <div class='centr'><img src='$pfp' alt='' height='150px' width='150px'></div>
                    <div class='centr'>Podatki:
                        <li class='t'>Uporabniško ime: $username</li>
                        <li class='t'>E-mail: $email</li>
                        <li class='a'><a href='createuser.php'>Ustvari račun</a></li>
                        <li class='a'><a href='domacastran.php'>Dom</a></li> 
                        <li class='a'><a href='logout.php'>ODJAVA</a></li>
                    </div>
                    ";
                }
                else{
                    echo"
                    <div class='centr'><img src='$pfp' alt='' height='300px' width='300px'></div>
                    <div class='centr'>Podatki:
                        <li class='t'>Uporabniško ime: $username</li>
                        <li class='t'>Ime: $name</li>
                        <li class='t'>Priimek: $surname</li>
                        <li class='t'>E-mail: $email</li>
                        <li class='a'><a href='domacastran.php'>Dom</a></li> 
                        <li class='a'><a href='logout.php'>ODJAVA</a></li>          
                    </div>
                    ";
                }
            }
        }
        
        ?>
        
    </div>
</body>
</html>