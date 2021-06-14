<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "ict/email.php?msg=add";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "daftaremail")) {
	
	$ui = $_POST['stafid']; //array
	$em = $_POST['login_username']; //array

  foreach( $ui as $key => $value)
  {
	  if($em[$key]!="")
	  {
		  if(!checkEmailReg($em[$key]))
		  {
			$insertSQL = sprintf("INSERT INTO login (login_date, login_by, login_username, login_password, user_stafid) VALUES (%s, %s, %s, %s, %s)",
								 GetSQLValueString(date('d/m/Y'), "text"),
								 GetSQLValueString($_POST['login_by'], "text"),
								 GetSQLValueString(strtolower($em[$key] . "@nsc.gov.my"), "login"),
								 GetSQLValueString(getPassKey(getDKey()), "login"),
								 GetSQLValueString(ucwords($value), "text"));
		  
			mysql_select_db($database_hrmsdb, $hrmsdb);
			$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
	  
			activateEmail(getHeadIDByUserID(ucwords($value)), 0, 0, 1, ucwords($value));
			
		  } else {
			  $insertGoTo = $url_main . "ict/email.php?e=4";
		  }
	  }
  }
}

header(sprintf("Location: %s", $insertGoTo));
?>