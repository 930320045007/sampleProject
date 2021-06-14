<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php
$deleteGoTo = $url_main . "tadbir/adminbooking.php";

if(checkUserSysAcc($row_user['user_stafid'], 10, 40, 4))
{
	if(isset($_GET['delhall']) && $_GET['delhall']!=NULL)
	{
	  $deleteSQL = sprintf("UPDATE tadbir.hall_book SET hallbook_status = '0' WHERE hallbook_id=%s",
						   GetSQLValueString($_GET['delhall'], "int"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	
	  $deleteGoTo .= "?msg=del&lokasi=" . getBookingHallID($_GET['delhall']) . "&bulan=" . getBookingDateMY($_GET['delhall']);
	  
	} else {
  		$deleteGoTo .= "?del=1";
	};
	
} else {
  $deleteGoTo .= "?del=1&lokasi=" . getBookingHallID($_GET['delhall']) . "&bulan=" . getBookingDateMY($_GET['delhall']);
};

header(sprintf("Location: %s", $deleteGoTo));
?>