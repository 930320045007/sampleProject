<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php  include('../sb/email.php');?>
<?php
$insertGoTo = $url_main . "tadbir/maintenance.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formmaintenance")) {
		
			$insertSQL = sprintf("INSERT INTO maintenance (maintenance_by, maintenance_d,maintenance_m,maintenance_y, transport_id, maintenance_odometer, maintenance_note) VALUES (%s, %s, %s, %s,%s,%s,%s)",
								 GetSQLValueString($row_user['user_stafid'], "text"),
								 GetSQLValueString(date('d'), "text"),
								 GetSQLValueString(date('m'), "text"),
								 GetSQLValueString(date('Y'), "text"),
								 GetSQLValueString($_POST['transportid'], "int"),
								 GetSQLValueString($_POST['maintenance_odometer'], "text"),
								 GetSQLValueString($_POST['maintenance_note'], "text"));
		  
			mysql_select_db($database_tadbirdb, $tadbirdb);
			$Result1 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
			
			$h= getMaintenanceIDByUserID($row_user['user_stafid'], date('d'), date('m'), date('Y'));
			 foreach($_POST['jp'] AS $key => $value)
			  {
				  if($value != 0)
				  {
						$insertSQL = sprintf("INSERT INTO maintenance_normalize (maintenance_id, maintenancetype_id) VALUES (%s, %s)",
											   GetSQLValueString($h, "int"),
											   GetSQLValueString($value, "int"));
						
						  mysql_select_db($database_tadbirdb, $tadbirdb);
						  $Result2 = mysql_query($insertSQL, $tadbirdb) or die(mysql_error());
				  }
			  }	
			  
		$emailto = array();
		$emailto[] = $row_user['user_stafid'];
		$emailto = array_merge($emailto,getUserIDSysAcc(10, 80));
		
		mail($emailto, 0, 0, 1, $h);
		
	$insertGoTo = $url_main . "tadbir/maintenancedetail.php?id=" . $h . "&msg=add";
} else {
		$insertGoTo = $url_main . "tadbir/maintenance.php?eul=1";
	};

header(sprintf("Location: %s", $insertGoTo));
?>