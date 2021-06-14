<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php /*?><?php include('../sb/email.php');?><?php */?>
<?php
$insertGoTo = $url_main . "tadbir/admintransportdetail.php?tid=" . getID(htmlspecialchars($_POST['transbookid'],ENT_QUOTES));

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 2) && !checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($_POST['transbookid']))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2"))
	{
		$insertSQL = sprintf("INSERT INTO tadbir.transdriver (transbook_id, transport_id, driver_id) VALUES (%s, %s, %s)",
			GetSQLValueString($_POST['transbookid'], "int"),
			GetSQLValueString($_POST['transport_id'], "int"),
			GetSQLValueString($_POST['driver_id'], "int"));
	
		mysql_select_db($database_tadbirdb, $tadbirdb);
		$Result = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
		
		//$emailto = array();
//		$emailto[] = getStafIDByID($_POST['driver_id']); // email kepada pemandu
//		
//		emailPemanduKenderaan($emailto, 0, 0, 1, $_POST['transbookid']); 
	
		$insertGoTo .= "&msg=edit";
		
	} else {
		$insertGoTo .= "&msg=error";
	};
	
} else {
	$insertGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>