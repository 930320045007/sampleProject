<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
if ((isset($_POST["MM_update_pass"])) && ($_POST["MM_update_pass"] == "formpass"))
{
	if($_POST['kl_old']==getPassKey(getPassOldByUserID($row_user['user_stafid']),'2'))
	{
		if($_POST['kl_new']==$_POST['kl_new2'] && $_POST['kl_new']!="" && $_POST['kl_new']!=$_POST['kl_old'])
		{
			$updateSQL = sprintf("UPDATE login SET login_password=%s WHERE user_stafid=%s",
								   GetSQLValueString(getPassKey($_POST['kl_new'],'1'), "login"),
								   GetSQLValueString($row_user['user_stafid'], "text"));
								   
			 mysql_select_db($database_hrmsdb, $hrmsdb);
			 $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());
			 
			 $GoTo = htmlspecialchars($_POST['url'], ENT_QUOTES) . "?msg=passs";
		} else {
			$GoTo = htmlspecialchars($_POST['url'], ENT_QUOTES) . "?msg=passecn";
		};
		
	} else {
		$GoTo = htmlspecialchars($_POST['url'], ENT_QUOTES) . "?msg=passeco";
	};
	
} else {
	$GoTo = htmlspecialchars($_POST['url'], ENT_QUOTES) . "?msg=error";
};

header(sprintf("Location: %s", $GoTo));
?>