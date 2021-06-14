<?php require_once('../Connections/hrmsdb.php'); ?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_ss = "SELECT * FROM user_salaryskill WHERE usersalaryskill_status = 1 ORDER BY usersalaryskill_id ASC";
$ss = mysql_query($query_ss, $hrmsdb) or die(mysql_error());
$row_ss = mysql_fetch_assoc($ss);
$totalRows_ss = mysql_num_rows($ss);

$i=0;
do {
  $newvalue = str_replace(",", "",$row_ss['usersalaryskill_basicsalary']);
	
  $deleteSQL = sprintf("UPDATE user_salaryskill SET usersalaryskill_basicsalary = '" . $newvalue . "' WHERE usersalaryskill_id=%s",
                       GetSQLValueString($row_ss['usersalaryskill_id'], "int"));

  mysql_select_db($database_hrmsdb, $hrmsdb);
  $Result1 = mysql_query($deleteSQL, $hrmsdb) or die(mysql_error());
  $i++;
} while($row_ss = mysql_fetch_assoc($ss));

mysql_free_result($ss);
?>
Penambahbaikkan = <?php echo $i;?>