<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id_prev = $_GET['user_id'];

        $picture_location = "profilepictures/me.png";
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $class_name = $_POST['razred'];
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

        if($class != 22){
            $query_2 = "UPDATE users SET username = '$username', password = '$password', email = '$email', role = '$role', name = '$name', surname = '$surname' WHERE user_id = '$user_id_prev'";
            mysqli_query($con, $query_2);
            Header("Location: administration.php");
        }
        else{
            $query_2 = "UPDATE users SET username = '$username', password = '$password', email = '$email', role = '$role', class_id = $class, name = '$name', surname = '$surname' WHERE user_id = $user_id_prev";
            mysqli_query($con, $query_2);
            Header("Location: administration.php");
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Button Display</title>
    <link rel="stylesheet" type="text/css" href="styleuserchange.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $query = "SELECT * FROM users WHERE user_id=$user_id";
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $user_id_old = $row['user_id'];
                    $username_old = $row['username'];
                    $name_old = $row['name'];
                    $surname_old = $row['surname'];
                    $email_old = $row['email'];
                    $role_old = $row['role'];
                    $class_id_old = $row['class_id'];
                    $password_old = $row['password'];

                    echo "
                    <form method='POST'>
                    <h1>Spremeni Uporabnika</h1>
                        <div class='form-group'> 
                            <label for='user_id'>user_id:</label>
                            <input type='text' id='user_id' name='user_id' value='$user_id_old' readonly>
                        </div>
                        <div class='form-group'>
                            <label for='name'>Ime:</label>
                            <input type='text' id='name' name='name' value='$name_old'>
                        </div>
                        <div class='form-group'>
                            <label for='surname'>Priimek:</label>
                            <input type='text' id='surname' name='surname' value='$surname_old'>
                        </div>
                        <div class='form-group'>
                            <label for='username'>Uporabniško ime:</label>
                            <input type='text' id='username' name='username' value='$username_old'>
                        </div>
                        <div class='form-group'>
                            <label for='password'>Geslo:</label>
                            <input type='password' id='password' name='password' value='$password_old'>
                        </div>
                        <div class='form-group'>
                            <label for='email'>E naslov:</label>
                            <input type='email' id='email' name='email' value='$email_old'>
                        </div>
                        <div class='form-group'>
                        <label for='vloga'>Vloga:</label>
                            <select id='vloga' name='role' value='$role_old'>
                                <option value='student'>Dijak</option>
                                <option value='teacher'>Profesor</option>
                                <option value='admin'>Admin</option>
                            </select>
                        </div>
                        <div class='form-group'>
                        <label for='razred'>Razred:</label>
                            <select name='razred' id='razred'>
                                <option value='R4a'>R4a</option>
                                <option value='R4b'>R4b</option>
                                <option value='E4a'>E4a</option>
                                <option value='E4b'>E4b</option>
                                <option value='K4a'>K4a</option>
                                <option value='R3a'>R3a</option>
                                <option value='R3b'>R3b</option>
                                <option value='E3a'>E3a</option>
                                <option value='E3b'>E3b</option>
                                <option value='K3a'>K3a</option>
                                <option value='R2a'>R2a</option>
                                <option value='R2b'>R2b</option>
                                <option value='E2a'>E2a</option>
                                <option value='E2b'>E2b</option>
                                <option value='K2a'>K2a</option>
                                <option value='R1a'>R1a</option>
                                <option value='R1b'>R1b</option>
                                <option value='E1a'>E1a</option>
                                <option value='E1b'>E1b</option>
                                <option value='K1a'>K1a</option>
                                <option value='empty'>Učitej</option>
                            </select>
                        </div>
                        <button type='submit'>Ustvari</button>
                        <br></br><br></br>
                    </form>
                    ";
                }
            }
        }
        echo "<a href='administration.php' class='btn-link'>Nazaj</a>";
        ?>
    </div>
</body>
</html>