<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "personal"))
{
  $GoTo = $url_main . "profile.php";
}
else if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "personal2")) {
  $id = $_POST["idstaff"];
  $GoTo = $url_main . "admin/profile.php?id=" . $id;
  $flag = getStafIDByUserID($id);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "personal") || ($_POST["MM_update"] == "personal2"))
{
  
	$colname_user_personal2 = "-1";
	if (isset($_SESSION['user_stafid']) && $flag)
	{
	  $colname_user_personal2 = $flag;
	}
  else {
    $colname_user_personal2 = $_SESSION['user_stafid'];
  }
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_user_personal2 = sprintf("SELECT * FROM www.user_personal WHERE user_stafid = %s ORDER BY userpersonal_id DESC", GetSQLValueString($colname_user_personal2, "text"));
	$user_personal2 = mysql_query($query_user_personal2, $hrmsdb) or die(mysql_error());
	$row_user_personal2 = mysql_fetch_assoc($user_personal2);
	$totalRows_user_personal2 = mysql_num_rows($user_personal2);
		
	if($totalRows_user_personal2 == 0)
	{
		$updateSQL = sprintf("INSERT INTO www.user_personal (userpersonal_by, userpersonal_date, userpersonal_marital, userpersonal_address, userpersonal_address2, userpersonal_address3, userpersonal_zip, userpersonal_city, userpersonal_state, userpersonal_telh, userpersonal_telm, userpersonal_telw, userpersonal_telo, userpersonal_emailo, userpersonal_license, userpersonal_licensetype, userpersonal_size, userpersonal_dob_state, user_stafid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['userpersonal_by'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['userpersonal_marital'], "int"),
                       GetSQLValueString($_POST['userpersonal_address'], "text"),
                       GetSQLValueString($_POST['userpersonal_address2'], "text"),
                       GetSQLValueString($_POST['userpersonal_address3'], "text"),
                       GetSQLValueString($_POST['userpersonal_zip'], "text"),
                       GetSQLValueString($_POST['userpersonal_city'], "text"),
                       GetSQLValueString($_POST['userpersonal_state'], "text"),
                       GetSQLValueString($_POST['userpersonal_telh'], "text"),
                       GetSQLValueString($_POST['userpersonal_telm'], "text"),
                       GetSQLValueString($_POST['userpersonal_telw'], "text"),
                       GetSQLValueString($_POST['userpersonal_telo'], "text"),
                       GetSQLValueString($_POST['userpersonal_emailo'], "text"),
                       GetSQLValueString($_POST['userpersonal_license'], "text"),
                       GetSQLValueString($_POST['userpersonal_licensetype'], "text"),
                       GetSQLValueString($_POST['userpersonal_size'], "text"),
                       GetSQLValueString($_POST['userpersonal_dob_state'], "int"),
                       GetSQLValueString($colname_user_personal2, "text"));
					   
		$GoTo .= "?msg=add#personal";
	} else {
	
  		$updateSQL = sprintf("UPDATE www.user_personal SET userpersonal_by=%s, userpersonal_date=%s, userpersonal_marital=%s, userpersonal_address=%s, userpersonal_address2=%s, userpersonal_address3=%s, userpersonal_zip=%s, userpersonal_city=%s, userpersonal_state=%s, userpersonal_telh=%s, userpersonal_telm=%s, userpersonal_telw=%s, userpersonal_telo=%s, userpersonal_emailo=%s, userpersonal_license=%s, userpersonal_licensetype=%s, userpersonal_size=%s, userpersonal_dob_state=%s WHERE user_stafid=%s",
                       GetSQLValueString($_POST['userpersonal_by'], "text"),
					   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
					   GetSQLValueString($_POST['userpersonal_marital'], "int"),
                       GetSQLValueString($_POST['userpersonal_address'], "text"),
                       GetSQLValueString($_POST['userpersonal_address2'], "text"),
                       GetSQLValueString($_POST['userpersonal_address3'], "text"),
                       GetSQLValueString($_POST['userpersonal_zip'], "text"),
                       GetSQLValueString($_POST['userpersonal_city'], "text"),
                       GetSQLValueString($_POST['userpersonal_state'], "text"),
                       GetSQLValueString($_POST['userpersonal_telh'], "text"),
                       GetSQLValueString($_POST['userpersonal_telm'], "text"),
                       GetSQLValueString($_POST['userpersonal_telw'], "text"),
                       GetSQLValueString($_POST['userpersonal_telo'], "text"),
                       GetSQLValueString($_POST['userpersonal_emailo'], "text"),
                       GetSQLValueString($_POST['userpersonal_license'], "text"),
                       GetSQLValueString($_POST['userpersonal_licensetype'], "text"),
                       GetSQLValueString($_POST['userpersonal_size'], "text"),
                       GetSQLValueString($_POST['userpersonal_dob_state'], "int"),
                       GetSQLValueString($_POST['user_stafid'], "text"));
					   
		$GoTo .= "?msg=edit#personal";
	};

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
  
  mysql_free_result($user_personal2);
  
} else {
	$GoTo .= "?msg=error#personal";
};

header(sprintf("Location: %s", $GoTo));
?>
