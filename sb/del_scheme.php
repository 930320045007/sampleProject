<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$updateGoTo = $url_main . "admin/emp.php";

if(isset($_GET['id']) && checkUserSysAcc($row_user['user_stafid'], 5, 7, 4))
{
  $updateSQL = sprintf("UPDATE scheme SET scheme_status='0' WHERE scheme_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
  
  $updateGoTo .= "?msg=del&cid=" . htmlspecialchars($_GET['cid'], ENT_QUOTES);
  
} else {
  $updateGoTo .= "?del=1&cid=" . htmlspecialchars($_GET['cid'], ENT_QUOTES);
};

header(sprintf("Location: %s", $updateGoTo));
?>