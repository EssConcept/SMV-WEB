<?php

session_start();
	
	//Check if user is loged in
	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


    if($user_data['role'] == 'teacher'){
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            
            $classname = $_POST['classname'];
            $classgroup = $_POST['classgroup'];
            $teacher_id = $user_data['user_id'];

            $query = "SELECT * FROM classes WHERE class_name = '$classgroup' LIMIT 1";
            $result = mysqli_query($con, $query);

            while($row = mysqli_fetch_assoc($result)){
                $class_id = $row['class_id'];
                $query = "INSERT INTO lessons(class_id, lesson_name, teacher_id)
                VALUES('$class_id', '$classname', '$teacher_id')";
                mysqli_query($con, $query);
            }
        }
    }
    else{
        Header("Location: logout.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylerazred.css">
</head>
<body>
    <div>
        <form method="POST">
            <div class="form-group">
                <label for="classname">Ime razreda:</label>
                <input type="text" id="classname" name="classname">
            </div>
            <div class="form-group">
                <label for="classgroup">Razred:</label>
                <select name="classgroup" id="classgroup">
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
                </select>
            </div>
            <button type="submit">Ustvari</button>
        </form>
        <a href='domacastran.php'>Domov</a>
    </div>
</body>
</html>