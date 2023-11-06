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
    <link rel="stylesheet" href="styleprofil.css">
    <title>Document</title>
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
            <?php
            if($user_data['role'] == 'student'){
                echo "<a href='domacastran.php'>Dom</a>";
            }
        ?> 
        <?php
            if($user_data['role'] == 'teacher'){
                echo "<a href='domacastran.php'>Dom</a>";
            }
        ?> 
                <a href="contacts.php">Kontakt</a>
                <?php
            if($user_data['role'] == 'student'){
                echo "<a href='ocene.php'>Ocene</a>";
            }
        ?>                
        </div>  
    </header>
    <br> 
    <div class="gridkontejner">
        <?php
        $user = $user_data['username'];
        $query = "SELECT * FROM users WHERE username = '$user'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $username = $row['username'];
                $email = $row['email'];
                $name = $row['name'];
                $surname = $row['surname'];
                $pfp = $row['profile_picture_location'];
        ?>

                <div class="centr">
                    <img src="<?= $pfp ?>" alt="" height="300px" width="300px">
                </div>
                <div class="kontejner centr">
                    <div class="tekst">
                        <?php if ($username == 'Admin') { ?>
                            <p class="t"> <b>Uporabniško ime:</b> <?= $username ?></p>
                            <p class="t"><b>E-Mail:</b> <?= $email ?></p>
                            <a href='createuser.php' class="odjava" id="nvm">Administracija</a><br><br>
                            <a href='logout.php' class="odjava" id="nvm">ODJAVA</a>
                        <?php } else { ?>
                            <p class="t"><b>Uporabniško ime:</b> <?= $username ?></p>
                            <p class="t"><b>Ime:</b> <?= $name ?></p>
                            <p class="t"><b>Priimek:</b> <?= $surname ?></p>
                            <p class="t"><b>E-Mail:</b> <?= $email ?></p><br>
                            <a href='settings.php' class="odjava" id="nvm">Sprememba Gesla</a><br><br>
                            <a href='logout.php' class="odjava" id="nvm">ODJAVA</a>
                        <?php } ?>
                    </div>
                </div>

        <?php
            }
        }
        ?>
    </div>
</body>
</html>