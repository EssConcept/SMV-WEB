<?php

function check_login($con){

	//If user is not set (loged in), website relocates us to login page
	if(isset($_SESSION['user_id']))
	{
		$id = $_SESSION['user_id'];
		$query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
		$querj = "SELECT * FROM users WHERE user_id = ['%Admin%']";

		$result = mysqli_query($con, $query);
		if ($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}
	header("Location: login.php");
	die();
}

?>