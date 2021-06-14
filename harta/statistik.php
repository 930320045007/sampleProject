<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/hartadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/hartafunc.php');?>
<?php $menu='12';?>
<?php $menu2='44';?>
<?php
if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');
	
mysql_select_db($database_hartadb, $hartadb);
$query_kat = "SELECT * FROM harta.category WHERE category_status = 1 ORDER BY category_name ASC";
$kat = mysql_query($query_kat, $hartadb) or die(mysql_error());
$row_kat = mysql_fetch_assoc($kat);
$totalRows_kat = mysql_num_rows($kat);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="https://www.google.com/jsapi">
</script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tarikh');
        data.addColumn('number', 'Aduan');
        data.addRows([
		<?php 
		for($i=0; $i<=30; $i++){ //bulan semasa
			if($i<10) $i = "0" . $i;?>
          ['<?php echo date('d/m', mktime(0, 0, 0, date('m'), (date('d')-$i), date('Y')));?>', <?php echo countNewReport(date('d', mktime(0, 0, 0, date('m'), (date('d')-$i), date('Y'))), date('m', mktime(0, 0, 0, date('m'), (date('d')-$i), date('Y'))), date('Y', mktime(0, 0, 0, date('m'), (date('d')-$i), date('Y'))), 0);?>]<?php if($i<30) echo ",";?>
		<?php }; ?>
        ]);

        var options = {
		  fontSize: '11',
		  colors: ['#99CC00', '#00CCFF', '#FFCC00', '#FFOOFF'],
          hAxis: {title: 'Tarikh'},
          vAxis: {title: 'Bilangan Aduan', color: '#DDD', count: 10, minValue: 0},
		  legend: {position:'none'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chartdaily_div'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tarikh');
	data.addColumn('number', 'Aduan');
	data.addRows([
	<?php for($j=0; $j<=12; $j++){ if($j<10) $j = "0" . $j;?>
	  ['<?php echo date('M y', mktime(0, 0, 0, (date('m')-$j), 1, date('Y')));?>', <?php echo countNewReport(0, date('m', mktime(0, 0, 0, (date('m')-$j), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$j), 1, date('Y'))), 0);?>]<?php if($j<12) echo ",";?>
	<?php }; ?>
	]);
  
	var options = {
	  fontSize: '11',
	  colors: [ '#FFCC00', '#99CC00', '#00CCFF', '#FFOOFF'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Bilangan Aduan', color: '#DDD', count: 10, minValue: 0},
	  legend: {position:'none'}
	};
  
	var chart = new google.visualization.ColumnChart(document.getElementById('chartmonth_div'));
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <div class="tabber">
			  <div class="tabbertab tabbertabdefault" title="Harian">
			  <li><div id="chartdaily_div" style="width: 100%; height: 500px;"></div></li>
			  </div>
			  <div class="tabbertab" title="Bulanan">
			  <li><div id="chartmonth_div" style="width: 100%; height: 500px;"></div></li>
			  </div>
			  <div class="tabbertab" title="Kategori">
			  <li>
              	<div class="note">Statistik bulanan mengikut Kategori pada tahun <?php echo $y;?></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                    <th width="100%" align="left" valign="middle" nowrap="nowrap">Kategori</th>
                    <?php for($i=1; $i<=12; $i++){?>
                    <th align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></th>
                    <?php }; ?>
                  </tr>
                  <?php $ci=1; do { ?>
                    <tr>
                      <td align="center" valign="middle"><?php echo $ci;?></td>
                      <td align="left" valign="middle"><?php echo $row_kat['category_name']; ?></td>
                    <?php for($j=1; $j<=12; $j++){?>
					<?php
					if($j<10) $j = '0' . $j;
                    if(countByCategory(0, $j, $y, $row_kat['category_id'])!=0) 
                      $per = ((countByCategory(0, $j, $y, $row_kat['category_id'])/countByCategory(0, $j, $y, 0))*100);
                    else
                      $per = 0;
					?>
                    <td <?php echo color($per);?> align="center" valign="middle" nowrap="nowrap"><?php echo countByCategory(0, $j, $y, $row_kat['category_id']);?></td>
                    <?php }; ?>
                    </tr>
                    <?php $ci++; } while ($row_kat = mysql_fetch_assoc($kat)); ?>
                    <tr class="back_lightgrey">
                      <td align="center" valign="middle" class="line_t">&nbsp;</td>
                    <td align="left" valign="middle" class="line_t"><strong>Jumlah</strong></td>
                    <?php for($k=1; $k<=12; $k++){?>
                    <td align="center" valign="middle" nowrap="nowrap" class="line_t"><?php if($k<10) $k = '0' . $k; echo countByCategory(0, $k, $y, 0);?></td>
                    <?php }; ?>
              		</tr>
                  	<tr>
                    	<td colspan="3" align="center" valign="middle" class="txt_color1 noline">rekod dijumpai</td>
                    </tr>
                </table>
              </li>
			  </div>
			  <div class="tabbertab" title="Penilaian">
			  <li>
				  <?php $stafict = getUserIDSysAcc(12, 45);?>
                  <div class="note">Penilaian 'Star Rating' kakitangan pada tahun <?php echo $y;?></div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                  	<?php $i=1; foreach($stafict AS $key => $value){?>
                      <?php if($i%3==1) echo "<tr>";?>
                        <td class="icon_pad1"><?php echo viewProfilePic($value);?></td>
                        <td width="30%" class="txt_line line_r">
                        <div><strong><?php echo shortText(getFullNameByStafID($value),20);?> (<?php echo $value;?>)</strong></div>
                        <div><?php echo star(getHartaPercStarRatingByUserID($value, 0, $y));?></div>
                        <div><?php echo getHartaTotalReportByUserID($value, 0, $y);?> aduan</div>
                        </td>
                      <?php if($i%3==0) echo "</tr>";?>
                   	<?php $i++; }; ?>
                    </table>
              </li>
              </div>
			  <div class="tabbertab" title="Tempoh">
			  <li>
              <?php $stafict = getUserIDSysAcc(12, 45);?>
              <div class="note">Statistik tempoh yang diambil untuk tamat aduan pada tahun <?php echo $y;?></div>
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              	  <tr>
              	    <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>
              	    <th align="center" valign="middle" nowrap="nowrap">1 Hari<br />
              	      (%)</th>
              	    <th align="center" valign="middle" nowrap="nowrap">3 Hari<br />
              	      (%)</th>
              	    <th align="center" valign="middle" nowrap="nowrap">7 Hari<br />
              	      (%)</th>
              	    <th align="center" valign="middle" nowrap="nowrap">&gt; 7 Hari<br />
              	      (%)</th>
            	    </tr>
                  	<?php $i=1; foreach($stafict AS $key => $value){?>
					<?php 
					$totalgrand = getHartaTotalReportByUserID($value, 0, $y);
					
					$total1day = getHartaRespondByUserID($value, 0, $y, 1);
					$total3day = getHartaRespondByUserID($value, 0, $y, 3);
					$total7day = getHartaRespondByUserID($value, 0, $y, 7);
					$total8day = getHartaRespondByUserID($value, 0, $y, 8);
					
					if($totalgrand>0)
					{
						$perc1d = round(($total1day/$totalgrand)*100,1);
						$perc3d = round(($total3day/$totalgrand)*100,1);
						$perc7d = round(($total7day/$totalgrand)*100,1);
						$perc8d = round(($total8day/$totalgrand)*100,1);
					} else {
						$perc1d = 0;
						$perc3d = 0;
						$perc7d = 0;
						$perc8d = 0;
					}
					?>
              	  <tr>
              	    <td align="left" valign="middle"><?php echo getFullNameByStafID($value);?> (<?php echo $value;?>)</td>
              	    <td align="center" valign="middle" <?php echo color($perc1d);?>><?php echo $perc1d;?></td>
              	    <td align="center" valign="middle" <?php echo color($perc3d);?>><?php echo $perc3d;?></td>
              	    <td align="center" valign="middle" <?php echo color($perc7d);?>><?php echo $perc7d;?></td>
              	    <td align="center" valign="middle" <?php echo color($perc8d);?>><?php echo $perc8d;?></td>
            	    </tr>
                    <?php }; ?>
            	  </table>
              </li>
              <li class="gap">&nbsp;</li>
              </div>
			</div>
                <li>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(date('d'), date('m'), date('Y'), 0);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan harian</div><div class="txt_color1"><?php echo date('d/m/Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(date('d'), date('m'), date('Y'), 2);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan harian</div><div class="txt_color1">tiada tindakan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(date('d'), date('m'), date('Y'), 1);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan harian</div><div class="txt_color1">belum ditamatkan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(date('d'), date('m'), date('Y'), 3);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap"><div>aduan harian</div><div class="txt_color1">ditamatkan</div></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, date('m'), date('Y'), 0);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan bulanan</div>
                        <div class="txt_color1"><?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, date('m'), date('Y'), 2);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan bulanan</div>
                        <div class="txt_color1">tiada tindakan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, date('m'), date('Y'), 1);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan bulanan</div>
                        <div class="txt_color1">belum ditamatkan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, date('m'), date('Y'), 3);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap"><div>aduan bulanan</div>
                        <div class="txt_color1">ditamatkan</div></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 0);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan keseluruhan</div>
                        <div class="txt_color1"><?php echo date('Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 2);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan keseluruhan</div>
                        <div class="txt_color1">tiada tindakan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 1);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap" class="line_r"><div>aduan keseluruhan</div>
                        <div class="txt_color1">belum ditamatkan</div></td>
                      <td align="center" valign="middle" class="icon_pad1"><div class="txt_icon"><?php echo countNewReport(0, 0, date('Y'), 3);?></div><div>rekod</div></td>
                      <td width="25%" nowrap="nowrap"><div>aduan keseluruhan</div>
                        <div class="txt_color1">ditamatkan</div></td>
                    </tr>
                  </table>
                </li>
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
mysql_free_result($kat);
?>
<?php include('../inc/footinc.php');?> 