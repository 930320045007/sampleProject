<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php 
$GoTo = $url_main . "profile.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "edu")) {

	  $insertSQL = sprintf("INSERT INTO user_edu (useredu_by,useredu_date, user_stafid, useredu_level, useredu_major, useredu_institution, useredu_location, useredu_year, useredu_cgpa, useredu_achievement, sponsor_id, useredu_sponsor) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['useredu_by'], "text"),
						   GetSQLValueString(date('d/m/Y h:i:s A'), "text"),
						   GetSQLValueString($_POST['user_stafid'], "text"),
						   GetSQLValueString($_POST['useredu_level'], "text"),
						   GetSQLValueString($_POST['useredu_major'], "text"),
						   GetSQLValueString($_POST['useredu_institution'], "text"),
						   GetSQLValueString($_POST['useredu_location'], "text"),
						   GetSQLValueString($_POST['useredu_year'], "text"),
						   GetSQLValueString($_POST['useredu_cgpa'], "text"),
						   GetSQLValueString($_POST['useredu_achievement'], "text"),
						   GetSQLValueString($_POST['sponsor_id'], "int"),
						   GetSQLValueString($_POST['useredu_sponsor'], "text"));
	
	  mysql_select_db($database_hrmsdb, $hrmsdb);
	  $Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());

	  $GoTo .= "?msg=add#edu2";
	
} else {
	$GoTo .= "?msg=error#edu2";
};

header(sprintf("Location: %s", $GoTo));
?>