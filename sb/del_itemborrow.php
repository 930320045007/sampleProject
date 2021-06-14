<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "ict/loandetail.php?id=" . htmlspecialchars($_GET['id'], ENT_QUOTES);

if ((isset($_GET['delitemborrow'])) && ($_GET['delitemborrow'] != ""))
{

  $deleteSQL = sprintf("UPDATE ict.item_borrow SET itemborrow_status = '0' WHERE itemborrow_id=%s",
                       GetSQLValueString($_GET['delitemborrow'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());

  $deleteGoTo .= "&msg=del";
  
} else {
  $deleteGoTo .= "&del=1";
}
header(sprintf("Location: %s", $deleteGoTo));
?>