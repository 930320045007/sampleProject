<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$deleteGoTo = $url_main . "admin/courseslist.php";

if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 4))
{
	$colname_userprofile = "-1";
	
	if (isset($_GET['id'])) {
	  $colname_userprofile = getID($_GET['id'],0);
	};
	
	if(isset($_GET['url']) && $_GET['url']==1){
		$deleteGoTo = $url_main . "admin/coursesstaffdetail.php";
	} else {
		$deleteGoTo = $url_main . "admin/coursesdetail.php";
	};
	
	if ((isset($_GET['deluc'])) && ($_GET['deluc'] != "")) 
	{
		$deleteSQL = sprintf("UPDATE user_courses SET usercourses_status = '0' WHERE courses_id=%s AND usercourses_id=%s AND user_stafid=%s",
							 GetSQLValueString($_GET['deluc'], "int"),
							 GetSQLValueString($_GET['cid'], "int"),
							 GetSQLValueString($colname_userprofile, "text"));
	  
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
	  
		$deleteGoTo .= "?msg=del&id=" . htmlspecialchars($_GET['deluc'], ENT_QUOTES) . "&sid=" . htmlspecialchars($_GET['id'], ENT_QUOTES);
	} else {
		$deleteGoTo .= "?msg=error&id=" . htmlspecialchars($_GET['deluc'], ENT_QUOTES) . "&sid=" . htmlspecialchars($_GET['id'], ENT_QUOTES);
	};
	
} else {
	$deleteGoTo = $url_main . "admin/coursesdetail.php?del=1&id=" . htmlspecialchars($_GET['deluc'], ENT_QUOTES) . "&sid=" . htmlspecialchars($_GET['id'], ENT_QUOTES);
}

header(sprintf("Location: %s", $deleteGoTo));
?>