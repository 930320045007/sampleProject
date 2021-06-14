<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php include('../sb/email.php');?>
<?php
 

 $_SESSION['description'][] = NULL;
  unset($_SESSION['description']);
  
  $_SESSION['quantity'][] = NULL;
  unset($_SESSION['quantity']);
  
  $_SESSION['calculation'][] = NULL;
  unset($_SESSION['calculation']);
  
  $_SESSION['amount'][] = NULL;
  unset($_SESSION['amount']);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "jkb"))
{
	
		$insertSQL = sprintf("INSERT INTO finance.jkb (jkb_date_d, jkb_date_m, jkb_date_y,  user_stafid, dir_id, category, jkb_ref, jkb_activity, jkb_detail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", 
							 GetSQLValueString(date('d'), "text"),
							 GetSQLValueString(date('m'), "text"),
							 GetSQLValueString(date('Y'), "text"),
							 GetSQLValueString($row_user['user_stafid'], "text"),
							 GetSQLValueString($_POST['dir_id'], "int"),
							 GetSQLValueString($_POST['category'], "int"),
							 GetSQLValueString($_POST['jkb_ref'], "text"),
							 GetSQLValueString($_POST['jkb_activity'], "text"),
							 GetSQLValueString($_POST['jkb_detail'], "text"));
	  
		mysql_select_db($database_financedb, $financedb);
		$Result1 = mysql_query($insertSQL, $financedb) or die(mysql_error());
		
		$jkbID = getJkbID($row_user['user_stafid'], date('d'), date('m'), date('Y'));
	
		if(isset($_POST['desc']) && count($_POST['desc'])!=0)
		{
			foreach($_POST['desc'] AS $key => $value)
			{
			  $insertSQL = sprintf("INSERT INTO finance.apply (jkb_id, apply_description, apply_quantity, apply_calculation, apply_amount) VALUES (%s, %s, %s, %s, %s)",
								   GetSQLValueString($jkbID, "int"),
								   GetSQLValueString($value, "text"),
								   GetSQLValueString($_POST['quantity'][$key], "text"),
								   GetSQLValueString($_POST['calc'][$key], "text"),
								   GetSQLValueString($_POST['amount'][$key], "text"));
			
			  mysql_select_db($database_financedb, $financedb);
			  $Result1 = mysql_query($insertSQL, $financedb) or die(mysql_error());
			};
		};

		$emailto = array();
		$emailto[] = $row_user['user_stafid'];
		$emailto = array_merge($emailto,getUserIDSysAcc(16, 89));
		
		emailNewJKB($emailto, 0, 0, 1, $jkbID);
		
		$insertGoTo = $url_main . "fin/jkbdetail.php?id=" . $jkbID . "&msg=add";
		
	} else {
		$insertGoTo = $url_main . "fin/jkb.php?etic=1";
	};
	

header(sprintf("Location: %s", $insertGoTo));
?>