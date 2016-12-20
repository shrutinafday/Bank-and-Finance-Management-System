<?php
ob_start();
session_start(); // Starting Session

$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
// To protect MySQL injection for Security purpose
/*$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password); */
// Selecting Database

$statement = oci_parse($connection,'select * from bank_users where user_id=:username and pass=:password');
oci_bind_by_name($statement,":username",$username);
oci_bind_by_name($statement,":password",$password);
if (@oci_execute($statement,OCI_DEFAULT))
{
	
	
	if (oci_fetch ($statement))
	{
		$_SESSION['valid']=true;
		$_SESSION['timeout']=time();
		$_SESSION['username']=$username;
		if(strlen($username)!=1)
		{
			header("Location: userLogin.php"); // Redirecting To Other Page
		}
		else
		
		header("Location: adminLogin.php"); // Redirecting To Other Page
	}
	else
	{
			echo '<script language="javascript">';
			echo 'alert("Login Failed!")';
			echo '</script>';
	}
}




}
}
?>