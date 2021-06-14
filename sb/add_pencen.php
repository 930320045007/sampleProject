<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

$deleteGoTo = $url_main . "admin/edit.php?id=" . getUserIDByStafID(htmlspecialchars($_POST['id'], ENT_QUOTES));
  
if ((isset($_GET['pencen'])) && ($_GET['pencen'] == 1)) 
{
  $deleteSQL = sprintf("UPDATE user_pencen SET userpencen_by = %s, userpencen_date= %s, userpencen_d = %s, userpencen_m = %s, userpencen_y = %s WHERE user_stafid=%s",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:s:i A'), "text"),
                       GetSQLValueString($_POST['d'], "text"),
					   GetSQLValueString($_POST['m'], "text"),
					   GetSQLValueString($_POST['y'], "text"),
					   GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());

  $deleteGoTo .= "&msg=edit";
  
} else {
  $insertSQL = sprintf("INSERT INTO user_pencen (userpencen_by, userpencen_date, userpencen_d, userpencen_m, userpencen_y, user_stafid) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:s:i A'), "text"),
                       GetSQLValueString($_POST['d'], "text"),
					   GetSQLValueString($_POST['m'], "text"),
					   GetSQLValueString($_POST['y'], "text"),
					   GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());

  $deleteGoTo .= "&msg=add";
};

header(sprintf("Location: %s", $deleteGoTo));
?>