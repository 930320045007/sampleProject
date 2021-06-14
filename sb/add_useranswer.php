<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/selidikdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/selidikfunc.php');?>
<?php
$insertGoTo = $url_main . "qna/surveydetailuser.php?id=" . htmlspecialchars($_POST['sd_id'], ENT_QUOTES);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
	
	foreach($_POST['qid'] AS $key => $value)
	{
		if(!checkAnswer($row_user['user_stafid'], $value))
		{
			$ja = "jawab" . $value;
			
			$insertSQL = sprintf("INSERT INTO user_answer (user_stafid, ua_date, q_id, ua_answer) VALUES (%s, %s, %s, %s)",
								 GetSQLValueString($row_user['user_stafid'], "text"),
								 GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
								 GetSQLValueString($value, "int"),
								 GetSQLValueString($_POST[$ja], "text"));
		  
			mysql_select_db($database_selidikdb, $selidikdb);
			$Result1 = mysql_query($insertSQL, $selidikdb) or die(mysql_error());
		};
	};
	
	$insertGoTo .= "&msg=add";
};

header(sprintf("Location: %s", $insertGoTo));
?>