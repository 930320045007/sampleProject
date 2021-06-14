<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "ict/reportdetail.php?id=" . htmlspecialchars($_POST['id'], ENT_QUOTES);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formfeedback"))
{
	  $updateSQL = sprintf("UPDATE ict.user_report SET userreport_star=%s, userreport_starby=%s, userreport_stardate=%s WHERE userreport_id=%s",
			 GetSQLValueString($_POST['star'], "int"),
			 GetSQLValueString($row_user['user_stafid'], "text"),
			 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
			 GetSQLValueString($_POST['id'], "int"));
	  
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
	
	  $updateGoTo .= "&msg=edit";
	  
} else {
	  $updateGoTo .= "&e=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>