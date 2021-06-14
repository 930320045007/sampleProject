<?php require_once('Connections/hrmsdb.php'); ?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_division = "SELECT * FROM division ORDER BY division_sort ASC";
$division = mysql_query($query_division, $hrmsdb) or die(mysql_error());
$row_division = mysql_fetch_assoc($division);
$totalRows_division = mysql_num_rows($division);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="css/dir.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['orgchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addRows([
          ['Ketua Pengarah', ''],
      		<?php do { ?>
          	['<?php echo $row_division['division_name']; ?>', 'Ketua Pengarah'],
          <?php
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_branch = "SELECT * FROM branch WHERE branch_sub1 = '" . $row_division['division_id'] . "' ORDER BY branch_sort ASC";
		$branch = mysql_query($query_branch, $hrmsdb) or die(mysql_error());
		$row_branch = mysql_fetch_assoc($branch);
		$totalRows_branch = mysql_num_rows($branch);

		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_unit = "SELECT * FROM unit WHERE unit_sub1 = '" . $row_division['division_id'] . "' ORDER BY unit_sort ASC";
		$unit = mysql_query($query_unit, $hrmsdb) or die(mysql_error());
		$row_unit = mysql_fetch_assoc($unit);
		$totalRows_unit = mysql_num_rows($unit);
		
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_center = "SELECT * FROM center WHERE center_sub1 = '" . $row_division['division_id'] . "' ORDER BY center_sort ASC";
		$center = mysql_query($query_center, $hrmsdb) or die(mysql_error());
		$row_center = mysql_fetch_assoc($center);
		$totalRows_center = mysql_num_rows($center);
		?>
			<?php if ($totalRows_branch > 0) {  ?>
				<?php do { ?>
          			['<?php echo $row_branch['branch_name']; ?>', '<?php echo $row_division['division_name']; ?>'],
                <?php } while ($row_branch = mysql_fetch_assoc($branch)); ?>
            <?php };  ?>
			
            <?php if ($totalRows_unit > 0) {  ?>
				<?php do { ?>
                  ['<?php echo $row_unit['unit_name']; ?>', '<?php echo $row_division['division_name']; ?>'],
                  <?php } while ($row_unit = mysql_fetch_assoc($unit)); ?>
            <?php }; ?>
			
			<?php if ($totalRows_center > 0) {  ?>
				<?php do { ?>
                  ['<?php echo $row_center['center_name']; ?>', '<?php echo $row_division['division_name']; ?>'],
                  <?php } while ($row_center = mysql_fetch_assoc($center)); ?>
            <?php }; ?>
			
        	<?php } while ($row_division = mysql_fetch_assoc($division)); ?>
        ]);
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        chart.draw(data, {allowHtml:true});
      }
    </script>
</head>

<body>
<div id='chart_div'></div>
</body>
</html>
<?php
mysql_free_result($division);

mysql_free_result($branch);

mysql_free_result($unit);

mysql_free_result($center);
?>
