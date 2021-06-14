<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/setting.php";

if(checkUserSysAcc($row_user['user_stafid'], 12, 46, 2))
{
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "kat")) 
	{
	  $insertSQL = sprintf("INSERT INTO harta.category (category_code, category_name) VALUES (%s, %s)",
						   GetSQLValueString(strtoupper($_POST['category_code']), "text"),
						   GetSQLValueString($_POST['category_name'], "text"));
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
	  $insertGoTo .= "?msg=add";
	  
	} else if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "skat")){
		
	  $insertSQL = sprintf("INSERT INTO harta.subcategory (category_id, subcategory_name) VALUES (%s, %s)",
						   GetSQLValueString(strtoupper($_POST['category_id']), "text"),
						   GetSQLValueString($_POST['subcategory_name'], "text"));
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
	  $insertGoTo .= "?msg=add";
	  
	} else if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "unit")) {
		
	  $insertSQL = sprintf("INSERT INTO harta.set (set_name) VALUES (%s)",
						   GetSQLValueString($_POST['set_name'], "text"));
	
	  mysql_select_db($database_hartadb, $hartadb);
	  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());
	  $insertGoTo .= "?msg=add";
	  
	} else {
		$insertGoTO .= "?msg=error";
	};
	
} else {
	$insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>