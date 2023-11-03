<?php

session_start();

if (isset($_SESSION['user_id'])) {
	unset($_SESSION);
}
header("Location: login.php");
die();

?>