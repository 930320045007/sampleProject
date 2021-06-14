<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
$val = strval($_GET['pergerakan_lokasi']);
$id = strval($_GET['user_stafid']);
$day = strval($_GET['day']);
$month = strval($_GET['month']);
// $year = intval($_POST['year']);

    $sql = sprintf("INSERT INTO pergerakan (pergerakan_stafid, pergerakan_by, pergerakan_day, pergerakan_month, pergerakan_year, pergerakan_location) VALUES (%s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($id, "text"),
                        GetSQLValueString($id, "text"),
                        GetSQLValueString($day, "text"),
                        GetSQLValueString($month, "text"),
                        GetSQLValueString(date('Y'), "text"),
                        GetSQLValueString($val, "text"));

	// $sql="insert into pergerakan (pergerakan_stafid, pergerakan_by, pergerakan_day, pergerakan_month, pergerakan_year, pergerakan_location) values ('" .$user_stafid. "','" .$user_stafid. "','" .$day. "','" .$month. "','" .$year. "','" .$val. "')";
    $result = mysql_query($sql,$hrmsdb) or die(mysql_error());
    echo '<h1>Berjayaaaaayayyayayaya</h1>'
		
?>
