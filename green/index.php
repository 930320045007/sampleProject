<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php include('../inc/admin_sta.php');?>
<?php $menu='14';?>
<?php $menu2='82';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart()
  {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Bulan');
	data.addColumn('number', 'Akses');
	data.addRows([
	<?php 
	for($i=0; $i<=12; $i++)
	{ 
	?>
	  ['<?php echo date('M y' , mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>', <?php echo percAksesByDate(0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>]<?php if($i<12) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#99CC00','#00CCFF', '#FFCC00', '#FFOOFF'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Akses (%)', color: '#DDD', minValue: 0},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
  }
</script>
<script type="text/javascript" src="../js/tabber.js"></script>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
			  <li>
				  <div class="note">Statistik Akses <?php echo $systitle_short;?> mengikut bulan.</div>
				  <div id="chart_div" style="width: 100%; height: 500px;"></div>
			  </li>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php include('../inc/footinc.php');?> 