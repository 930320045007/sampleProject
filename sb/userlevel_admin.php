<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php	
$insertGoTo = $url_main . "ict/userlevel.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formual"))
{
	if(checkUserSysAcc($row_user['user_stafid'], 6, 15, 2)) // semakkan user akses untuk add data
	{
		if(checkStafID($_POST['user_stafid']))
		{
			if(!checkUserLevelRegister($_POST['user_stafid'], $_POST['menu_id'], $_POST['submenu_id']))
			{ 
				// semak staf sudah berdaftar atau belum
				$insertSQL = sprintf("INSERT INTO user_sysacc (usersysacc_by, usersysacc_date, user_stafid, menu_id, submenu_id, usersysacc_view, usersysacc_add, usersysacc_edit, usersysacc_del) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($row_user['user_stafid'], "text"),
							   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
							   GetSQLValueString($_POST['user_stafid'], "text"),
							   GetSQLValueString($_POST['menu_id'], "int"),
							   GetSQLValueString($_POST['submenu_id'], "int"),
							   GetSQLValueString($_POST['usersysacc_view'], "int"),
							   GetSQLValueString($_POST['usersysacc_add'], "int"),
							   GetSQLValueString($_POST['usersysacc_edit'], "int"),
							   GetSQLValueString($_POST['usersysacc_del'], "int"));
		
				  mysql_select_db($database_hrmsdb, $hrmsdb);
				  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				  
				  $insertGoTo .= "?msg=add";
				  
			} else {
				$insertGoTo .= "?eul=2";
			};
			
		} else {
		  $insertGoTo .= "?e=2";
		};
		
	} else {
		  $insertGoTo .= "?eul=1";
	};

} else {

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formual"))
{
	//kod untuk update
     $updateSQL = sprintf("UPDATE user_sysacc SET usersysacc_view=%s, usersysacc_add=%s, usersysacc_edit=%s, usersysacc_del=%s WHERE usersysacc_id=%s",
							   GetSQLValueString($_POST['usersysacc_view'], "int"),
							   GetSQLValueString($_POST['usersysacc_add'], "int"),
							   GetSQLValueString($_POST['usersysacc_edit'], "int"),
							   GetSQLValueString($_POST['usersysacc_del'], "int"),
							   GetSQLValueString($_POST['usersysacc_id'], "int"));
				  mysql_select_db($database_hrmsdb, $hrmsdb);
				  $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
				  
				  $insertGoTo .= "?msg=edit";
				  
}else{
	$insertGoTo .= "?msg=error";
}

};

header(sprintf("Location: %s", $insertGoTo));
?>