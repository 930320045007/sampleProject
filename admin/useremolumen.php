<?php require_once('../Connections/hrmsdb.php'); ?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ss = "SELECT user_emolumen.* FROM www.user_emolumen WHERE useremolumen_status = 1 ORDER BY useremolumen_id ASC";
$ss = mysql_query($query_ss, $hrmsdb) or die(mysql_error());
$row_ss = mysql_fetch_assoc($ss);
$totalRows_ss = mysql_num_rows($ss);

$i=0;
do {
  $newvalue = str_replace(",", "",$row_ss['useremolumen']);
	
  $deleteSQL = sprintf("UPDATE user_emolumen SET useremolumen_basicsalary = '" . $newvalue . "' WHERE useremolumen_id=%s",
                       GetSQLValueString($row_ss['useremolumen_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
  $i++;
} while($row_ss = mysql_fetch_assoc($ss));

mysql_free_result($ss);
?>
Penambahbaikkan = <?php echo $i;?>
