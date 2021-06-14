<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/setting.php";

$id = getID($_GET['type'], 0);
$iditem = getID($_GET['id'],0);

if(checkUserSysAcc($row_user['user_stafid'], 12, 46, 4) && $id=='1')
{
	  $insertSQL = sprintf("UPDATE harta.category SET category_status='0' WHERE category_id=%s",
									   GetSQLValueString($iditem, "int"));
				
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";

} elseif(checkUserSysAcc($row_user['user_stafid'], 12, 46, 4) && $id=='2') 
{
	  $insertSQL = sprintf("UPDATE harta.subcategory SET subcategory_status='0' WHERE subcategory_id=%s",
									   GetSQLValueString($iditem, "int"));
				
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";
	
} elseif(checkUserSysAcc($row_user['user_stafid'], 12, 46, 4) && $id=='3') 
{
	  $insertSQL = sprintf("UPDATE harta.set SET set_status='0' WHERE set_id=%s",
									   GetSQLValueString($iditem, "int"));
				
	  mysql_select_db($database_ictdb, $ictdb);
	  $Result1 = mysql_query($insertSQL, $ictdb) or die(mysql_error());
	
	  $insertGoTo .= "?msg=del";
	
} else {
  $insertGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $insertGoTo));
?>