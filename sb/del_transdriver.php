<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$updateGoTo = $url_main . "tadbir/admintransportdetail.php";

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 4))
{
	$colname_tr = "-1";
	
	if (isset($_GET['id']))
	{
	  $colname_tr = getID($_GET['id'],0);
	}
	
	if ((isset($_GET['trid'])) && ($_GET['trid'] != "")) 
	{
		$updateSQL = sprintf("UPDATE transdriver SET transdriver_status='0' WHERE transbook_id=%s AND transdriver_id=%s",
  					  GetSQLValueString($colname_tr, "int"),
                      GetSQLValueString($_GET['trid'], "int"));
					  
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		
		$updateGoTo .= "?msg=del&id=" . getID(htmlspecialchars($_GET['trid'], ENT_QUOTES)) . "&tid=" . getID(htmlspecialchars($_GET['id'],ENT_QUOTES));
	};
  
} else {
  $updateGoTo = $url_main . "tadbir/admintransport.php?del=1&id=" . getID(htmlspecialchars($_GET['trid'], ENT_QUOTES)) . "&tid=" . getID(htmlspecialchars($_GET['id'],ENT_QUOTES));
};

header(sprintf("Location: %s", $updateGoTo));
?>