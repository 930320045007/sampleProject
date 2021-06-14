<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ideasdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ideasfunc.php');?>
<?php

$insertGoTo = $url_main . "ideas/index.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formIdeasSupport")) 
{
	if($_POST['ids_id'] != NULL)
	{
		if(!checkUserVoteByIdeasID($row_user['user_stafid'], $_POST['ids_id']) && checkExpiredByIdeasID($_POST['ids_id']))
		{
			$insertSQL = sprintf("INSERT INTO ideas.ids_support (idss_date, user_stafid, ids_id) VALUES (%s, %s, %s)",
								 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
								 GetSQLValueString($row_user['user_stafid'], "text"),
								 GetSQLValueString($_POST['ids_id'], "int"));
			
			mysql_select_db($database_ideasdb, $ideasdb);
			$Result1 = mysql_query($insertSQL, $ideasdb) or die(mysql_error());
			
			$insertGoTo .= "?msg=add";
		
		} else {
			$insertGoTo .= "?msg=error";
		};
	
	} else { 
		$insertGoTo .= "?msg=error";
	};
	
} else {
	$insertGoTo .= "?msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>