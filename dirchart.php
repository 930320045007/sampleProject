<?php require_once('Connections/hrmsdb.php'); ?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_division = "SELECT * FROM dir WHERE dir.dir_sub ='0' AND dir.dir_status != '0' ORDER BY dir_sort ASC";
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
      		<?php do { ?>
          	['<?php echo $row_division['dir_name']; ?>', '<?php echo $row_division['dir_name']; ?>'],
          <?php
		mysql_select_db($database_hrmsdb, $hrmsdb);
		$query_branch = "SELECT * FROM dir WHERE dir_sub = '" . $row_division['dir_id'] . "' AND dir.dir_status != '0' ORDER BY dir_sort ASC";
		$branch = mysql_query($query_branch, $hrmsdb) or die(mysql_error());
		$row_branch = mysql_fetch_assoc($branch);
		$totalRows_branch = mysql_num_rows($branch);
		?>
			<?php if ($totalRows_branch > 0) {  ?>
				<?php do { ?>
          			['<?php echo $row_branch['dir_name']; ?>', '<?php echo $row_division['dir_name']; ?>'],

					<?php 
					mysql_select_db($database_hrmsdb, $hrmsdb);
					$query_unit = "SELECT * FROM dir WHERE dir_sub = '" . $row_branch['dir_id'] . "' AND dir.dir_status != '0' ORDER BY dir_sort ASC";
					$unit = mysql_query($query_unit, $hrmsdb) or die(mysql_error());
					$row_unit = mysql_fetch_assoc($unit);
					$totalRows_unit = mysql_num_rows($unit);?>
			
					<?php if ($totalRows_unit > 0) {  ?>
						<?php do { ?>
						  ['<?php echo $row_unit['dir_name']; ?>', '<?php echo $row_branch['dir_name']; ?>'],
						  
						  <?php
						 	mysql_select_db($database_hrmsdb, $hrmsdb);
							$query_center = "SELECT * FROM dir WHERE dir_sub = '" . $row_unit['dir_id'] . "' AND dir.dir_status != '0' ORDER BY dir_sort ASC";
							$center = mysql_query($query_center, $hrmsdb) or die(mysql_error());
							$row_center = mysql_fetch_assoc($center);
							$totalRows_center = mysql_num_rows($center);
						  ?>
			
							<?php if ($totalRows_center > 0) {  ?>
								<?php do { ?>
								  ['<?php echo $row_center['dir_name']; ?>', '<?php echo $row_center['dir_name']; ?>'],
								  <?php } while ($row_center = mysql_fetch_assoc($center)); ?>
							<?php }; ?>
							
						  <?php } while ($row_unit = mysql_fetch_assoc($unit)); ?>
					<?php }; ?>
					
                <?php } while ($row_branch = mysql_fetch_assoc($branch)); ?>
            <?php };  ?>
			
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
