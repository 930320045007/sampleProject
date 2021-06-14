<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>

<?php


  $_SESSION['desc'] = NULL;
  unset($_SESSION['desc']);
  
  $_SESSION['cat'] = NULL;
  unset($_SESSION['cat']);
  
  $_SESSION['quantity'] = NULL;
  unset($_SESSION['quantity']);
  
  $_SESSION['amount'] = NULL;
  unset($_SESSION['amount']);
  
$updateGoTo = $url_main . "tadbir/adminmaintenancedetail.php?id=" . htmlspecialchars($_POST['maintenance_id'], ENT_QUOTES);

if(checkUserSysAcc($row_user['user_stafid'], 10, 86, 3))
{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2"))
	{
	  $updateSQL = sprintf("UPDATE maintenance SET maintenance_appby=%s, maintenance_appdate=%s, maintenance_appnote=%s, maintenance_in_d=%s, maintenance_in_m=%s, maintenance_in_y=%s, maintenance_in_time=%s, maintenance_out_d=%s, maintenance_out_m=%s, maintenance_out_y=%s, maintenance_out_time=%s, transagency_id=%s, maintenance_refno=%s, maintenance_do_d=%s, maintenance_do_m=%s, maintenance_do_y=%s WHERE maintenance_id=%s",
						   GetSQLValueString($row_user['user_stafid'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['maintenance_appnote'], "text"),
						   GetSQLValueString($_POST['maintenance_in_d'], "text"),
						   GetSQLValueString($_POST['maintenance_in_m'], "text"),
						   GetSQLValueString($_POST['maintenance_in_y'], "text"),
						   GetSQLValueString($_POST['maintenance_in_time'], "text"),
						   GetSQLValueString($_POST['maintenance_out_d'], "text"),
						   GetSQLValueString($_POST['maintenance_out_m'], "text"),
						   GetSQLValueString($_POST['maintenance_out_y'], "text"),
						   GetSQLValueString($_POST['maintenance_out_time'], "text"),
						   GetSQLValueString($_POST['transagency_id'], "int"),
						   GetSQLValueString($_POST['maintenance_refno'], "text"),
						   GetSQLValueString($_POST['maintenance_do_d'], "text"),
						   GetSQLValueString($_POST['maintenance_do_m'], "text"),
						   GetSQLValueString($_POST['maintenance_do_y'], "text"),
						   GetSQLValueString($_POST['maintenance_id'], "int"));
	
	  mysql_select_db($database_tadbirdb, $tadbirdb);
	  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
	  
	  if(isset($_POST['invdesc']) && count($_POST['invdesc'])!=0)
		{
	    foreach($_POST['invdesc'] AS $key => $value)
			  { 
$updateSQL = sprintf("INSERT INTO tadbir.desc_invoice (maintenance_id, desc_id, category_id, descinv_quantity, descinv_amount) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['maintenance_id'], "int"),
			GetSQLValueString($value, "int"),
			GetSQLValueString($_POST['invcat'][$key], "int"),
			GetSQLValueString($_POST['invquantity'][$key], "text"),
			GetSQLValueString($_POST['invamount'][$key], "text"));
	
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
			  }
		}
	
		$updateGoTo .= "&msg=edit";
		
	} else {
		$updateGoTo .= "&msg=error";
	};
	
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>