<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

    //Check if user is admin
	$user_data = check_login($con);
    if($user_data['username'] != 'Admin'){
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION);
        }
        header("Location: login.php");
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){

        $picture_location = "profilepictures/me.png";
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $class_name = $_POST['class'];
        $class = 0;
        switch($class_name){
            case'R4a': $class = 1;
                break;
            case'R4b': $class = 2;
                break;
            case'E4a': $class = 3;
                break;
            case'E4b': $class = 4;
                break;
            case'K4a': $class = 5;
                break;
            case'R3a': $class = 7;
                break;
            case'R3b': $class = 8;
                break;
            case'E3a': $class = 9;
                break;
            case'E3b': $class = 10;
                break;
            case'K3a': $class = 11;
                break;
            case'R2a': $class = 12;
                break;
            case'R2b': $class = 13;
                break;
            case'E2a': $class = 14;
                break;
            case'E2b': $class = 15;
                break;
            case'K2a': $class = 16;
                break;
            case'R1a': $class = 17;
                break;
            case'R1b': $class = 18;
                break;
            case'E1a': $class = 19;
                break;
            case'E1b': $class = 20;
                break;
            case'K1a': $class = 21;
                break;
            case'empty': $class = 22;
                break;
            default: break;
        }

        if(!empty($name) && !empty($surname) && !empty($username) 
            && !empty($password) && !empty($email) && !empty($role) && $class != 0)
        {
            if($class != 22){
                $query = "INSERT INTO users(username, password, email, role, class_id, name, surname, profile_picture_location) 
                VALUES('$username', '$password', '$email', '$role', '$class', '$name', '$surname', '$picture_location')";
                mysqli_query($con, $query);
            }
            else{
                $query = "INSERT INTO users(username, password, email, role, name, surname, profile_picture_location) 
                VALUES('$username', '$password', '$email', '$role', '$name', '$surname', '$picture_location')";
                mysqli_query($con, $query);
            }
        }
        else{
            echo "Error!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="u-profil.css">
</head>
<body>
    <div class="container">
        <h1>Nov Profil</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Ime:</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="surname">Priimek:</label>
                <input type="text" id="surname" name="surname">
            </div>
            <div class="form-group">
                <label for="username">Uporabniško ime:</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Geslo:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="email">E naslov:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="vloga">Vloga:</label>
                <select id="vloga" name="role">
                    <option value="student">Dijak</option>
                    <option value="teacher">Profesor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="razred">Razred:</label>
                <select name="class" id="razred">
                    <option value="R4a">R4a</option>
                    <option value="R4b">R4b</option>
                    <option value="E4a">E4a</option>
                    <option value="E4b">E4b</option>
                    <option value="K4a">K4a</option>
                    <option value="R3a">R3a</option>
                    <option value="R3b">R3b</option>
                    <option value="E3a">E3a</option>
                    <option value="E3b">E3b</option>
                    <option value="K3a">K3a</option>
                    <option value="R2a">R2a</option>
                    <option value="R2b">R2b</option>
                    <option value="E2a">E2a</option>
                    <option value="E2b">E2b</option>
                    <option value="K2a">K2a</option>
                    <option value="R1a">R1a</option>
                    <option value="R1b">R1b</option>
                    <option value="E1a">E1a</option>
                    <option value="E1b">E1b</option>
                    <option value="K1a">K1a</option>
                    <option value="empty">Učitej</option>
                </select>
            </div>
            <button type="submit">Ustvari</button>
            <br></br><br></br>
        </form>
        <a href="profil.php">Nazaj</a>
    </div>
</body>
</html>