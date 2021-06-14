<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php  
header ("Content-Type:text/xml");  

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_dir = "SELECT * FROM dir WHERE dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
$row_dir = mysql_fetch_assoc($dir);

$totalRows_dir = mysql_num_rows($dir);
?>
<?php 
echo "<bhglist>";

if($totalRows_dir>0)
{
	do {
		echo "<bhg>";
			echo "<id>" . htmlspecialchars($row_dir['dir_id'], ENT_QUOTES) . "</id>";
			echo "<jenis>" . htmlspecialchars($row_dir['dir_type'], ENT_QUOTES) . "</jenis>";
			echo "<nama>" . htmlspecialchars(getFulldirectory($row_dir['dir_id'], 0), ENT_QUOTES) . "</nama>";
		echo "</bhg>";
	}while($row_dir = mysql_fetch_assoc($dir));
};

echo "</bhglist>";

mysql_free_result($dir);
?>
