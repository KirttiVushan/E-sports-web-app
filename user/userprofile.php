<?php
session_start();

if(array_key_exists("id", $_COOKIE))
{
	$_SESSION['id'] = $_COOKIE['id'];
}

if(array_key_exists("id", $_SESSION))
{
	echo "Logged In ! <a href='../index.php?logout=1'>Log Out</a></p>";
}
else
{
	header("location:../index.php");
}
?>