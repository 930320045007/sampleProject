<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php

$deleteGoTo = $url_main . "ict/servicelist.php"; 

$colname_serv= "-1";

if (isset($_GET['id'])) 
{
	$colname_serv = getID($_GET['id'],0);
}
	
if(checkUserSysAcc($row_user['user_stafid'], 6, 31, 4))
{
  $updateSQL = sprintf("UPDATE ict.service SET service_status='0' WHERE service_id=%s",
                        GetSQLValueString($colname_serv, "int"));

  mysql_select_db($database_ictdb, $ictdb);
  $Result1 = mysql_query($updateSQL, $ictdb) or die(mysql_error());

 $deleteGoTo .= "?msg=del&id=" . getID($colname_serv); 
 
} else {
	$deleteGoTo .= "?eul=1";
};

header(sprintf("Location: %s", $deleteGoTo));
?>