<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ideasdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ideasfunc.php');?>
<?php

$insertGoTo = $url_main . "ideas/index.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formIdeas")) 
{
	if($_POST['ids_detail'] != NULL)
	{
		if(!checkUserByDate($row_user['user_stafid']))
		{
			$insertSQL = sprintf("INSERT INTO ideas.ids (ids_by, ids_date_d, ids_date_m, ids_date_y, ids_date_hms, idstype_id, ids_detail) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								 GetSQLValueString($row_user['user_stafid'], "text"),
								 GetSQLValueString(date('d'), "int"),
								 GetSQLValueString(date('m'), "int"),
								 GetSQLValueString(date('Y'), "int"),
								 GetSQLValueString(date('h:i:s A'), "text"),
								 GetSQLValueString($_POST['idstype_id'], "int"),
								 GetSQLValueString($_POST['ids_detail'], "text"));
			
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