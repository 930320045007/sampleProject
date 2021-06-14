<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php include('../sb/email.php');?>
<?php

$updateGoTo = $url_main . "tadbir/admintransportdetail.php?tid="  . getID($_POST['transbookid']);

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 2))
{
	if(!checkTransbookEndByTransID($_POST['transbookid']))
	{
		if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "kenderaan")) 
		{
			$updateSQL = sprintf("UPDATE transport_book SET admin_by=%s, admin_date=%s, admin_note=%s, admin_status=%s WHERE transbook_id=%s",
								
								 GetSQLValueString($row_user['user_stafid'], "text"),				
								 GetSQLValueString(date('d/m/Y h:i:s A'), "text"), 
								 GetSQLValueString($_POST['admin_note'], "text"),	 
								 GetSQLValueString($_POST['admin_status'], "text"),
								 GetSQLValueString($_POST['transbookid'], "int"));
		  
			mysql_select_db($database_tadbirdb, $tadbirdb);
			$Result = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
		
			$emailto = array();
			$emailto[] = getUserIDByTransbookID($_POST['transbookid']); // array emailstafid[0] = Staf ID yg memohon
			
			emailKelulusanPermohonanKenderaan($emailto, 0, 0, 1, $_POST['transbookid']); // 3- email kelulusan daripada Ketua
		
			$updateGoTo .= "&msg=edit";
		  
		} else {
			$updateGoTo .= "&msg=error";
		};
	} else {
		$updateGoTo .= "&msg=error";
	};
} else {
	$updateGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>