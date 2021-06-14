<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$colname_user_med2 = "-1";

$GoTo = $url_main . "profile.php";

if (isset($_SESSION['user_stafid']))
{
	$colname_user_med2 = $_SESSION['user_stafid'];

	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_user_med2 = sprintf("SELECT * FROM user_med WHERE user_stafid = %s ORDER BY usermed_id DESC", GetSQLValueString($colname_user_med2, "text"));
	$user_med2 = mysql_query($query_user_med2, $hrmsdb) or die(mysql_error());
	$row_user_med2 = mysql_fetch_assoc($user_med2);
	$totalRows_user_med2 = mysql_num_rows($user_med2);

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "med"))
	{
		
		if($totalRows_user_med2 == 0)
		{
			$updateSQL = sprintf("INSERT INTO www.user_med (usermed_date, usermed_by, usermed_blood, usermed_height, usermed_weight, usermed_disable, usermed_allergic, usermed_disease, usermed_datetreatment, usermed_doctor, user_stafid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['usermed_by'], "text"),
						   GetSQLValueString($_POST['usermed_blood'], "text"),
						   GetSQLValueString($_POST['usermed_height'], "text"),
						   GetSQLValueString($_POST['usermed_weight'], "text"),
						   GetSQLValueString($_POST['usermed_disable'], "text"),
						   GetSQLValueString($_POST['usermed_allergic'], "text"),
						   GetSQLValueString($_POST['usermed_disease'], "text"),
						   GetSQLValueString($_POST['usermed_datetreatment'], "text"),
						   GetSQLValueString($_POST['usermed_doctor'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"));
		} else {	
			$updateSQL = sprintf("UPDATE www.user_med SET usermed_by=%s, usermed_date=%s, usermed_blood=%s, usermed_height=%s, usermed_weight=%s, usermed_disable=%s, usermed_allergic=%s, usermed_disease=%s, usermed_datetreatment=%s, usermed_doctor=%s WHERE user_stafid=%s",
						   GetSQLValueString($_POST['usermed_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['usermed_blood'], "text"),
						   GetSQLValueString($_POST['usermed_height'], "text"),
						   GetSQLValueString($_POST['usermed_weight'], "text"),
						   GetSQLValueString($_POST['usermed_disable'], "text"),
						   GetSQLValueString($_POST['usermed_allergic'], "text"),
						   GetSQLValueString($_POST['usermed_disease'], "text"),
						   GetSQLValueString($_POST['usermed_datetreatment'], "text"),
						   GetSQLValueString($_POST['usermed_doctor'], "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"));
		};
		
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	  
	  $GoTo .= "?msg=edit#med2";
	  
	};
	
	mysql_free_result($user_med2);
	
} else {
	$GoTo .= "?msg=error#med2";
};

header(sprintf("Location: %s", $GoTo));
?>
