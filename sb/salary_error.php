<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php

$insertGoTo = $_POST['url'];

if(!checkSalaryErrorID($row_user['user_stafid'], $_GET['m'], $_GET['y']))
{
	if(isset($_SESSION['user_stafid']) && $_POST['kl']==getPassKey(getPassOldByUserID($row_user['user_stafid']),'2'))
	{
		$insertSQL = sprintf("INSERT INTO www.salary_error (salaryerror_date_d, salaryerror_date_m, salaryerror_date_y, user_stafid, salaryerror_month, salaryerror_year) VALUES (%s, %s, %s, %s, %s, %s)",
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('m'), "text"),
							 GetSQLValueString(date('Y'), "text"),
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString($_GET['m'], "text"),
							 GetSQLValueString($_GET['y'], "text"));
	  
		  mysql_select_db($database_hrmsdb, $hrmsdb);
		  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
			$insertGoTo .= "?msg=add";
		
			$emailto = array();
			$emailto[] = $row_user['user_stafid']; // array emailstafid[0] = Staf ID yg memohon
			$emailto = array_merge($emailto,getUserIDSysAcc(5, 34)); // StafID yg ada kelulusan Modul
			
			$usersalaryid = getSalaryErrorID($row_user['user_stafid'], $_GET['m'], $_GET['y']);
			
			emailSalaryError($emailto, 0, 0, 1, $usersalaryid);
			
	} else {
		$insertGoTo .= "?msg=passev";
	};
	
} else {
	$insertGoTo .= "?es=2";
};

header(sprintf("Location: %s", $insertGoTo));

?>
