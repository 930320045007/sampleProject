<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='39';?>
<?php

if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_halllist = "SELECT * FROM tadbir.hall WHERE hall_status = 1 ORDER BY hall_id ASC";
$halllist = mysql_query($query_halllist, $tadbirdb) or die(mysql_error());
$row_halllist = mysql_fetch_assoc($halllist);
$totalRows_halllist = mysql_num_rows($halllist);
?>
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
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tarikh');
	data.addColumn('number', 'Tempahan');
	data.addRows([
	<?php for($i=0; $i<=12; $i++){ if($i<10) $i = "0" . $i;?>
	  ['<?php echo date('M y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>', <?php echo getTotalBooking(0, 0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>]<?php if($i<=date('t')) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#99CC00', '#FFCC00', '#FF00FF'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Bilangan Tempahan Dewan / Bilik', color: '#DDD', count: 10},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chartmonth_div'));
	chart.draw(data, options);
  }
</script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tarikh');
	data.addColumn('number', 'Tempahan');
	data.addRows([
	<?php for($i=0; $i<=12; $i++){ if($i<10) $i = "0" . $i;?>
	  ['<?php echo date('M y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>', <?php echo getTotalTiketApp(date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>]<?php if($i<=date('t')) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#FF00FF', '#99CC00', '#FFCC00'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Bilangan Tempahan Tiket', color: '#DDD', count: 10},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('charttiketmonth_div'));
	chart.draw(data, options);
  }
</script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tarikh');
	data.addColumn('number', 'Tempahan');
	data.addRows([
	<?php for($i=0; $i<=12; $i++){ if($i<10) $i = "0" . $i;?>
	  ['<?php echo date('M y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>', <?php echo getTotalTransportTypeByMonth(0, 0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>]<?php if($i<=date('t')) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#FFCC00', '#FF00FF', '#99CC00'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Bilangan Tempahan Kenderaan', color: '#DDD', count: 10},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chartkenderaanmonth_div'));
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
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <div>
            <ul class="funcmenu">
            <?php for($i=2012; $i<=date('Y'); $i++){?>
            <li <?php if($y==$i) echo "class=\"funcon\"";?>><a href="?y=<?php echo $i;?>"><?php echo $i;?></a></li>
            <?php };?>
            </ul>
            </div>
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <li>&nbsp;
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle" class="pad1"><div class="txt_icon"><?php echo getTotalBooking(0, 0, date('m'), date('Y'));?></div><div>rekod</div></td>
                      <td class="line_r">
                      <div>Tempahan Dewan/Bilik</div>
                      <div class="txt_color1"><?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div>
                      </td>
                      <td align="center" valign="middle" class="pad1"><div class="txt_icon"><?php echo getTotalTiketApp();?></div><div>rekod</div></td>
                      <td class="line_r">
                      <div>Permohonan Tiket</div>
                      <div class="txt_color1">belum diproses</div>
                      </td>
                      <td align="center" valign="middle" class="pad1"><div class="txt_icon"><?php echo getTotalTransportTypeByMonth(0, date('d'), date('m'), date('Y'));?></div><div>rekod</div></td>
                      <td class="line_r">
                      <div>Tempahan Kenderaan</div>
                      <div class="txt_color1">pada <?php echo date('d / m / Y (D)');?></div>
                      </td>
                    </tr>
                  </table>
                </li>
                <div class="tabber">
                    <div class="tabbertab tabbertabdefault" title="Dewan/Bilik (Bulanan)">
                        <li>
                        	<div id="chartmonth_div" style="width: 100%; height: 500px;"></div>
                        </li>
                    </div>
                    <div class="tabbertab" title="Tiket (Bulanan)">
                        <li>
                        	<div id="charttiketmonth_div" style="width: 100%; height: 500px;"></div>
                        </li>
                    </div>
                    <div class="tabbertab" title="Kenderaan (Bulanan)">
                        <li>
                        	<div id="chartkenderaanmonth_div" style="width: 100%; height: 500px;"></div>
                        </li>
                    </div>
                    <div class="tabbertab" title="Lokasi">
                    <li>
                    <div class="note">Jadual jumlah tempahan mengikut lokasi dan bulan pada tahun <?php echo $y;?></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Lokasi</th>
                        <th align="center" valign="middle" nowrap="nowrap">1</th>
                        <th align="center" valign="middle" nowrap="nowrap">2</th>
                        <th align="center" valign="middle" nowrap="nowrap">3</th>
                        <th align="center" valign="middle" nowrap="nowrap">4</th>
                        <th align="center" valign="middle" nowrap="nowrap">5</th>
                        <th align="center" valign="middle" nowrap="nowrap">6</th>
                        <th align="center" valign="middle" nowrap="nowrap">7</th>
                        <th align="center" valign="middle" nowrap="nowrap">8</th>
                        <th align="center" valign="middle" nowrap="nowrap">9</th>
                        <th align="center" valign="middle" nowrap="nowrap">10</th>
                        <th align="center" valign="middle" nowrap="nowrap">11</th>
                        <th align="center" valign="middle" nowrap="nowrap">12</th>
                      </tr>
                      <?php $i=1; do { ?>
                      <tr>
                          <td align="center" valign="middle"><?php echo $i;?></td>
                          <td align="left" valign="middle"><?php echo getHallName($row_halllist['hall_id']); ?></td>
                          <?php for($mi=1; $mi<=12; $mi++){ if($mi<10) $mi = '0' . $mi; ?>
                          <td <?php if(getTotalBooking($row_halllist['hall_id'], 0, $mi, $y)!=0) $per = ((getTotalBooking($row_halllist['hall_id'], 0, $mi, $y)/getTotalBooking(0, 0, $mi, $y))*100); else $per = 0; echo color($per);?> align="center" valign="middle"><?php echo getTotalBooking($row_halllist['hall_id'], 0, $mi, $y);?></td>
                          <?php }; ?>
                        </tr>
                        <?php $i++; } while ($row_halllist = mysql_fetch_assoc($halllist)); ?>
                      <tr class="back_lightgrey">
                          <td align="center" valign="middle" class="line_t">&nbsp;</td>
                          <td align="left" valign="middle" class="line_t"><strong>Jumlah</strong></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '01', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '02', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '03', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '04', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '05', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '06', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '07', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '08', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '09', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '10', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '11', $y);?></td>
                          <td align="center" valign="middle" class="line_t"><?php echo getTotalBooking(0, 0, '12', $y);?></td>
                        </tr>
                    </table>
                    </li>
                    <li class="gap">&nbsp;</li>
                	</div>
                </div>
            <?php } ; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($halllist);
?>
<?php include('../inc/footinc.php');?> 