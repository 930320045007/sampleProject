<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('email.php');?>
<?php

$updateGoTo = $url_main . "property.php";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
	if(checkUserByPropertyID($row_user['user_stafid'],$_POST['userproperty_id']))
	 {
	  	$updateSQL = sprintf("UPDATE www.user_property SET userproperty_status = '0' WHERE userproperty_id=%s",
							  GetSQLValueString($_POST['userproperty_id'], "int"));
							  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			  
		$updateSQL = sprintf("INSERT INTO www.disposal (disposal_date,disposal_by,userproperty_id,disposalway_id, disposal_sellprice, disposal_note) VALUES (%s, %s, %s,%s,%s,%s)",
			GetSQLValueString($_POST['disposal_date'], "text"),
			GetSQLValueString($row_user['user_stafid'], "text"),
			GetSQLValueString($_POST['userproperty_id'], "int"),
			GetSQLValueString($_POST['disposalway'], "int"),
			GetSQLValueString($_POST['disposal_sellprice'], "text"),
			GetSQLValueString($_POST['disposal_note'], "text"));
	
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
		
 	    $emailto = array();
		$emailto[] = htmlspecialchars($_POST['user_stafid'], ENT_QUOTES); // array emailstafid[0] = Staf ID yg memohon
		
		$userpropertyid = getUserPropertyID($row_user['user_stafid'],date('d'), date('m'), date('Y'));
	   		
		sys_prorec('hr', 'user_property', $row_user['user_stafid'], '4', 'id=' . $userpropertyid);
		
		emailPropertyAdd($emailto, 0, 0, 1, $userpropertyid);
		
		$updateGoTo .= "?msg=del";
	} else {
		$updateGoTo .= "?msg=error";	
	};
	
} else {
	$deleteGoTo .= "?del=1";
};

header(sprintf("Location: %s", $updateGoTo));
?>
