<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$colname_user_passport2 = "-1";
$GoTo = $url_main . "profile.php";

if (isset($_SESSION['user_stafid'])) 
{
  $colname_user_passport2 = $_SESSION['user_stafid'];
};

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_user_passport2 = sprintf("SELECT * FROM user_passport WHERE user_stafid = %s ORDER BY userpassport_id DESC", GetSQLValueString($colname_user_passport2, "text"));
$user_passport2 = mysql_query($query_user_passport2, $hrmsdb) or die(mysql_error());
$row_user_passport2 = mysql_fetch_assoc($user_passport2);
$totalRows_user_passport2 = mysql_num_rows($user_passport2);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "passport"))
{
		if($totalRows_user_passport2 == 0)
		{
			$updateSQL = sprintf("INSERT INTO user_passport (userpassport_by, userpassport_date, user_stafid, userpassport_type, userpassport_citizen, userpassport_no, userpassport_start, userpassport_expire, userpassport_permit) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['userpassport_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['userpassport_type'], "text"),
						   GetSQLValueString($_POST['userpassport_citizen'], "text"),
						   GetSQLValueString($_POST['userpassport_no'], "text"),
						   GetSQLValueString($_POST['userpassport_start'], "text"),
						   GetSQLValueString($_POST['userpassport_expire'], "text"),
						   GetSQLValueString($_POST['userpassport_permit'], "text"));
						   
			$GoTo .= "?msg=add#pass2";
			
		} else {
			$updateSQL = sprintf("UPDATE user_passport SET userpassport_by=%s, userpassport_date=%s, userpassport_type=%s, userpassport_citizen=%s, userpassport_no=%s, userpassport_start=%s, userpassport_expire=%s, userpassport_permit=%s WHERE user_stafid=%s",
						   GetSQLValueString($_POST['userpassport_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['userpassport_type'], "text"),
						   GetSQLValueString($_POST['userpassport_citizen'], "text"),
						   GetSQLValueString($_POST['userpassport_no'], "text"),
						   GetSQLValueString($_POST['userpassport_start'], "text"),
						   GetSQLValueString($_POST['userpassport_expire'], "text"),
						   GetSQLValueString($_POST['userpassport_permit'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"));
						   
			$GoTo .= "?msg=edit#pass2";
		};
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	  
} else {
	$GoTo .= "?msg=error#pass2";
};

mysql_free_result($user_passport2);
header(sprintf("Location: %s", $GoTo));
?>
