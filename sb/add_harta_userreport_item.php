<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/reportdetail_admin.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{
	if(checkUserSysAcc($row_user['user_stafid'], 12, 45, 2))
	{
		if(!checkFeedbackEnd($_POST['userreport_id']))
		{
		  $insertSQL = sprintf("INSERT INTO user_item (useritem_by, useritem_date_d, useritem_date_m, useritem_date_y, userreport_id, item_id, useritem_kuantiti) VALUES (%s, %s,%s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d'), "text"),
							   GetSQLValueString(date('m'), "text"),
							   GetSQLValueString(date('Y'), "text"),
							   GetSQLValueString($_POST['userreport_id'], "int"),
							   GetSQLValueString($_POST['item_id'], "int"),
							   GetSQLValueString($_POST['useritem_kuantiti'], "int"));
		
		  mysql_select_db($database_hartadb, $hartadb);
		  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
		
		  $insertGoTo .= "?id=" . htmlspecialchars($_POST['userreport_id'], ENT_QUOTES) . "&msg=add";
		  
		} else {
			$insertGoTo .= "?id=" . htmlspecialchars($_POST['userreport_id'], ENT_QUOTES) . "&msg=error";
			
		};
		
	} else {
		$insertGoTo .= "?id=" . htmlspecialchars($_POST['userreport_id'], ENT_QUOTES) . "&eul=1";
		
	};
}
  header(sprintf("Location: %s", $insertGoTo));
?>