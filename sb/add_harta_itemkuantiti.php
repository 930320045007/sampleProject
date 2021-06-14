<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php
$insertGoTo = $url_main . "harta/itemadd.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{
  $insertSQL = sprintf("INSERT INTO item_stock (itemstock_by, itemstock_date_d, itemstock_date_m, itemstock_date_y, item_id, item_kuantiti) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d'), "text"),
                       GetSQLValueString(date('m'), "text"),
                       GetSQLValueString(date('Y'), "text"),
                       GetSQLValueString($_POST['item_id'], "int"),
                       GetSQLValueString($_POST['item_kuantiti'], "int"));

  mysql_select_db($database_hartadb, $hartadb);
  $Result1 = mysql_query($insertSQL, $hartadb) or die(mysql_error());

  $insertGoTo .= "?id=" . htmlspecialchars($_POST['item_id'], ENT_QUOTES) . "&msg=add";
  
} else {
	$insertGoTo .= "?id=" . htmlspecialchars($_POST['item_id'], ENT_QUOTES) . "&msg=error";
};

header(sprintf("Location: %s", $insertGoTo));
?>