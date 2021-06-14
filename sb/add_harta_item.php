<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/item.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{
  $insertSQL = sprintf("INSERT INTO item (item_by, item_date_d, item_date_m, item_date_y, category_id, item_name, set_id) VALUES (%s, %s,%s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "text"),
                       GetSQLValueString($_POST['category_id'], "int"),
                       GetSQLValueString($_POST['item_name'], "text"),
                       GetSQLValueString($_POST['set_id'], "int"));

  mysql_select_db($database_hartadb, $hartadb);
  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());

  $insertGoTo .= "?msg=add";
  
} else {
	$insertGoTo .= "?msg=error";
};
 header(sprintf("Location: %s", $insertGoTo));
?>