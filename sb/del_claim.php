<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

if(isset($_GET["url"]) && $_GET["url"]==1)
	$deleteGoTo = $url_main . "tadbir/adminclaim.php?id=" . getStafIDByClaimID($_GET['id']) . "&dmy=" . getDateOnMonthByClaimID($_GET['id']) . "/" . getDateOnYearByClaimID($_GET['id']); 
else if(isset($_GET["url"]) && $_GET["url"]==2)
	$deleteGoTo = $url_main . "tadbir/claimlist.php?m=" . getClaimDateMByClaimID($_GET['id']) . "&y=" . getClaimDateYByClaimID($_GET['id']); 
else 
	$deleteGoTo = $url_main . "tadbir/adminclaim.php?id=" . getStafIDByClaimID($_GET['id']);
	
if(isset($_GET['id']) && checkUserSysAcc($row_user['user_stafid'], 10, 70, 4)) 
{
  $updateSQL = sprintf("UPDATE tadbir.claim SET claim_status='0' WHERE claim_id=%s",
                        GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());

  $deleteGoTo .= "&msg=del";
  
} else {
	$deleteGoTo .= "&msg=error";
};

header(sprintf("Location: %s", $deleteGoTo));
?>