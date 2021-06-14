<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$insertGoTo = $url_main . "tadbir/admintransportdetail.php?tid=" . getID(htmlspecialchars($_POST['transbookid'], ENT_QUOTES));

if(checkUserSysAcc($row_user['user_stafid'], 10, 81, 2) && !checkFeedback($row_tr['transbook_id']) && checkAdminAppByID($_POST['transbookid']))
{
	if(isset($_POST['user_stafid']) && $_POST['user_stafid']!=NULL)
	{
		if(checkStafID($_POST['user_stafid']))
		{
			if(!checkUserIDByTransID($tid, $userid))
			{
				  $insertSQL2 = sprintf("INSERT INTO passenger (transbook_id, user_stafid) VALUES (%s, %s)",
									  GetSQLValueString($_POST['transbookid'], "int"),
									  GetSQLValueString($_POST['user_stafid'], "text"));
				
				  mysql_select_db($database_tadbirdb, $tadbirdb);
				  $Result2 = mysql_query($insertSQL2, $tadbirdb) or die(mysql_error());
				  
				 $insertGoTo .= "&msg=edit";
				 
			} else {
				$insertGoTo .= "&msg=error&type=userexists";
			};
			
		} else {
			$insertGoTo .= "&e=3";
		};
			
	} else {
		$insertGoTo .= "&msg=error&type=stafnull";
	};
	
} else {
	$insertGoTo .= "&eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>