<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php

$insertGoTo = $url_main . "tadbir/transportlistdetail.php?id=" . getID(htmlspecialchars($_POST['transportid'], ENT_QUOTES));

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cukai1")) {
		if(!checkRoadtaxkDateByTransportID($_POST['transportid'])){
		 $updateSQL = sprintf("INSERT INTO roadtax (roadtax_by, roadtax_date, transport_id,roadtax_date_d, roadtax_date_m, roadtax_date_y) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:s:i A'), "text"),  
					   GetSQLValueString($_POST['transportid'], "int"),
                       GetSQLValueString($_POST['roadtax_date_d'], "text"),
					   GetSQLValueString($_POST['roadtax_date_m'], "text"),
					   GetSQLValueString($_POST['roadtax_date_y'], "text"));
					   
					 mysql_select_db($database_tadbirdb, $tadbirdb);
					$Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
				  $insertGoTo = $url_main . "tadbir/transportlistdetail.php?id=" . $_POST['transportid'] . "&msg=add";
		}  else {
   $updateSQL = sprintf("UPDATE roadtax SET roadtax_by = %s, roadtax_date= %s, roadtax_date_d = %s, roadtax_date_m = %s, roadtax_date_y = %s WHERE transport_id=%s",
                       GetSQLValueString($row_user['user_stafid'], "text"),
                       GetSQLValueString(date('d/m/Y h:s:i A'), "text"),
                       GetSQLValueString($_POST['roadtax_date_d'], "text"),
					   GetSQLValueString($_POST['roadtax_date_m'], "text"),
					   GetSQLValueString($_POST['roadtax_date_y'], "text"),
					   GetSQLValueString($_POST['transportid'], "int"));
					   
  mysql_select_db($database_tadbirdb, $tadbirdb);
  $Result1 = mysql_query($updateSQL, $tadbirdb) or die(mysql_error());
  $insertGoTo = $url_main . "tadbir/transportlistdetail.php?id=" . $_POST['transportid'] . "&msg=edit";
		}
} else {
		$insertGoTo = $url_main . "tadbir/transportlistdetail.php?eul=1";
	};
	
mysql_free_result($roadtax);
header(sprintf("Location: %s", $insertGoTo));
?>