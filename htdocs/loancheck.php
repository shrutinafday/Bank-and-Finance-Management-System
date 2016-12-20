<?php
ob_start();
session_start(); // Starting Session

$error=''; // Variable To Store Error Message
if (isset($_POST['submit']))
{
	$connection = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
	$user_check=$_SESSION['username'];
	$sbal = oci_parse($connection,'select * from account a where a.cust_id=:username');
	oci_bind_by_name($sbal,":username",$user_check);
	$r=oci_execute($sbal);
	if (($row = oci_fetch_row($sbal)) != false)
	{
		$bal=$row[4];
	}
	if (empty($_POST['amount']) || $_POST['amount']<=0) 
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid Amount")';
		echo '</script>';
	}
	else if($bal<0)
	{
		echo '<script language="javascript">';
		echo 'alert("Negative Balance, Cannot apply for loan")';
		echo '</script>';
	}
	else
	{
// Define $username and $password
	$type=$_POST['type'];
	$amount=$_POST['amount'];
	$sloanid = oci_parse($connection,'select max(loan_id)+1 from loans');
	//oci_bind_by_name($bal,":username",$user_check);
	$r=oci_execute($sloanid);
	if (($row = oci_fetch_row($sloanid)) != false)
	{
		$loanid=$row[0];
	}
	$sbranchid = oci_parse($connection,'select branch_id from bank_users where user_id=:username');
	oci_bind_by_name($sbranchid,":username",$user_check);
	$r=oci_execute($sbranchid);
	if (($row = oci_fetch_row($sbranchid)) != false)
	{
		$brid=$row[0];
	}
	$status='Pending';
	$statement = oci_parse($connection,'insert into loans (loan_id, loan_type, amount, status, branch_id, cust_id, admin_id) values (:loanid,:type,:amount,:status,:branchid,:username,:branchid)');
	oci_bind_by_name($statement,":username",$user_check);
	oci_bind_by_name($statement,":loanid",$loanid);
	oci_bind_by_name($statement,":type",$type);
	oci_bind_by_name($statement,":amount",$amount);
	oci_bind_by_name($statement,":status",$status);
	oci_bind_by_name($statement,":branchid",$brid);
	$r=oci_execute($statement);
	}
	echo "<script type=\"text/javascript\">
				window.location = \"userLoans.php\";
		 </script>";
}	
?>