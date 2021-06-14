<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='9';?>
<?php
if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');
	
mysql_select_db($database_ictdb, $ictdb);
$query_rt = "SELECT * FROM report_type WHERE reporttype_status = 1 ORDER BY reporttype_name ASC";
$rt = mysql_query($query_rt, $ictdb) or die(mysql_error());
$row_rt = mysql_fetch_assoc($rt);
$totalRows_rt = mysql_num_rows($rt);
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
	data.addColumn('number', 'Pinjaman');
	data.addColumn('number', 'Aduan');
	data.addColumn('number', 'Permohonan');
	data.addRows([
	<?php for($i=1; $i<=date('t'); $i++){ if($i<10) $i = "0" . $i;?>
	  ['<?php echo date('d', mktime(0, 0, 0, date('m'), $i, date('Y')));?>', <?php echo countTotalBorrow($i, date('m'), date('Y'));?>, <?php echo countTotalReport($i, date('m'), date('Y'));?>, <?php echo countTotalApply($i, date('m'), date('Y'));?>]<?php if($i<date('t')) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#00CCFF', '#99CC00', '#FFCC00', '#FFOOFF'],
	  hAxis: {title: 'Hari (<?php echo date('M Y');?>)'},
	  vAxis: {title: 'Bilangan Pinjaman / Aduan / Permohonan', color: '#DDD', minValue: 0},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
	chart.draw(data, options);
  }
</script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Tarikh');
	data.addColumn('number', 'Pinjaman');
	data.addColumn('number', 'Aduan');
	data.addColumn('number', 'Permohonan');
	data.addRows([
	<?php for($i=0; $i<=12; $i++){?>
	  ['<?php echo date('M y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y')));?>', <?php echo countTotalBorrow(0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>, <?php echo countTotalReport(0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>, <?php echo countTotalApply(0, date('m', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))), date('Y', mktime(0, 0, 0, (date('m')-$i), 1, date('Y'))));?>]<?php if($i<12) echo ",";?>
	<?php }; ?>
	]);

	var options = {
	  fontSize: '11',
	  colors: ['#00CCFF', '#99CC00', '#FFCC00', '#FFOOFF'],
	  hAxis: {title: 'Bulan'},
	  vAxis: {title: 'Bilangan Pinjaman / Aduan / Permohonan', color: '#DDD', minValue: 0},
	  legend: {position:'none'}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chartmonth_div'));
	chart.draw(data, options);
  }
</script>
<script type="text/javascript" src="../js/tabber.js">
</script>
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
            	<li>
                &nbsp;
               	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                	  <tr>
                	    <td align="center" valign="middle" class="pad1">
                            <div class="txt_icon"><?php echo countTotalBorrowNeedApproval(0, 0, 0);?></div>
                            <div>rekod</div>
                        </td>
                	    <td class="line_r">Permohonan Pinjaman<br/><span class="txt_color1">belum dipertimbangkan</span></td>
                	    <td align="center" valign="middle" class="pad1">
                            <div class="txt_icon"><?php echo countReportNeedApproval(0, 0, 0);?></div>
                            <div>rekod</div>
                        </td>
                	    <td class="line_r">Aduan Pengguna<br/><span class="txt_color1">belum selesai</span></td>
                	    <td align="center" valign="middle" class="pad1">
                        	<div class="txt_icon"><?php echo countDeActEmail();?></div>
                	      	<div>rekod</div>
                        </td>
                	    <td class="line_r">Pengaktifan Email<br/><span class="txt_color1">pengguna</span></td>
                	    <td align="center" valign="middle" class="pad1">
                        	<div class="txt_icon"><?php echo countTotalApplyNeedApproval();?></div>
                	      	<div>rekod</div></td>
                	    <td>Permohonan Peralatan<br/><span class="txt_color1">belum dipertimbangkan</span></td>
           	        </tr>
              	  </table>
                </li>
                <div class="tabber">
                    <div class="tabbertab tabbertabdefault" title="Harian">
                    	<li><div id="chart_div" style="width: 100%; height: 500px;"></div></li>
                    </div>
                    <div class="tabbertab" title="Bulanan">
                    	<li><div id="chartmonth_div" style="width: 100%; height: 500px;"></div></li>
                    </div>
                    <div class="tabbertab" title="Jenis Aduan">
                   	  <li>
                        <div class="note">Statistik bulanan mengikut Jenis Aduan pada tahun <?php echo $y;?></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <?php if ($totalRows_rt > 0) { // Show if recordset not empty ?>
                              <tr>
                                <th align="center" valign="middle">Bil</th>
                                <th width="100%" align="left" valign="middle">Perkara</th>
                                <?php for($j=1; $j<=12; $j++){?>
                                <th align="center" valign="middle"><?php echo $j;?></th>
                                <?php }; ?>
                              </tr>
                              <?php $i=1; do { ?>
                                <tr>
                                  <td align="center" valign="middle"><?php echo $i;?></td>
                                  <td align="left" valign="middle"><?php echo $row_rt['reporttype_name']; ?></td>
                                  <?php for($k=1; $k<=12; $k++){ if($k<10) $k = '0' . $k;?>
                                  <?php 
								  if(getTotalReportTypeByMonth($row_rt['reporttype_id'], $k, $y)!=0) 
								  	$per = ((getTotalReportTypeByMonth($row_rt['reporttype_id'], $k, $y)/getTotalReportTypeByMonth('0', $k, $y))*100);
								  else
								  	$per = 0;?>
                                  <td <?php echo color($per);?> align="center" valign="middle"><?php echo getTotalReportTypeByMonth($row_rt['reporttype_id'], $k, $y);?></td>
                                  <?php }; ?>
                                </tr>
                                <?php $i++; } while ($row_rt = mysql_fetch_assoc($rt)); ?>
                                  <tr class="back_lightgrey">
                                    <td align="center" valign="middle" class="line_t">&nbsp;</td>
                                    <td align="left" valign="middle" class="line_t"><strong>Jumlah Keseluruhan</strong></td>
                                  	<?php for($l=1; $l<=12; $l++){ if($l<10) $l = '0' . $l;?>
                                    <td align="center" valign="middle" class="line_t"><?php echo getTotalReportTypeByMonth('0', $l, $y);?></td>
                                  	<?php }; ?>
                                  </tr>
                              <tr>
                                <td colspan="15" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_rt ?> rekod dijumpai</td>
                              </tr>
                              <?php } else { ?>
                              <tr>
                                <td colspan="15" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                              </tr>
                              <?php }; ?>
                            </table>
                      </li>
                  </div>
                    <div class="tabbertab" title="Penilaian">
                   	  <li>
                      <?php $stafict = getUserIDSysAcc(6, 28);?>
                        <div class="note">Penilaian 'Star Rating' kakitangan pada tahun <?php echo $y;?></div>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                      	<?php $i=1; foreach($stafict AS $key => $value){?>
                          <?php if($i%3==1) echo "<tr>";?>
                            <td class="icon_pad1"><?php echo viewProfilePic($value);?></td>
                            <td width="30%" class="txt_line line_r">
                            <div><strong><?php echo shortText(getFullNameByStafID($value),20) . " (" . $value . ")";?></strong></div>
                            <div><?php echo star(getPercStarRatingByUserID($value, 0, $y));?></div>
                            <div><?php echo getTotalReportByUserID($value, 0, $y);?> aduan</div>
                            </td>
                          <?php if($i%3==0) echo "</tr>";?>
                       	<?php $i++; }; ?>
                        </table>
                      </li>
                    </div>
                    <div class="tabbertab" title="Tempoh">
                   	  <li>
                      <div class="note">Tempoh yang diambil untuk menamatkan aduan pada tahun <?php echo $y;?></div>
                      <?php $stafict = getUserIDSysAcc(6, 28);?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama</th>
                          <th align="center" valign="middle" nowrap="nowrap">1 Hari<br/>(%)</th>
                          <th align="center" valign="middle" nowrap="nowrap">3 Hari<br/>(%)</th>
                          <th align="center" valign="middle" nowrap="nowrap">7 Hari<br/>(%)</th>
                          <th align="center" valign="middle" nowrap="nowrap">>7 Hari<br/>(%)</th>
                        </tr>
						<?php foreach($stafict AS $key => $value){?>
                        <?php 
							$total = getTotalReportByUserID($value, 0, $y);
							$per1d = 0;
							$per3d = 0;
							$per7d = 0;
							$per8d = 0; 
							
							if($total>0) 
							{
								$per1d = round((getTotalReportFeedbackBy1DayByUserID($value, 0, $y, 1)/$total)*100, 1); 
								$per3d = round((getTotalReportFeedbackBy1DayByUserID($value, 0, $y, 3)/$total)*100, 1);
								$per7d = round((getTotalReportFeedbackBy1DayByUserID($value, 0, $y, 7)/$total)*100, 1);
								$per8d = round((getTotalReportFeedbackBy1DayByUserID($value, 0, $y, 8)/$total)*100, 1);
							};
						?>
                        <tr>
                          <td align="left" valign="middle"><?php echo getFullNameByStafID($value) . " (" . $value . ")";?></td>
                          <td align="center" valign="middle" <?php echo color($per1d);?>><?php echo $per1d;?></td>
                          <td align="center" valign="middle" <?php echo color($per3d);?>><?php echo $per3d;?></td>
                          <td align="center" valign="middle" <?php echo color($per7d);?>><?php echo $per7d;?></td>
                          <td align="center" valign="middle" <?php echo color($per8d);?>><?php  echo $per8d;?></td>
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
                	    <td align="center" valign="middle" class="pad1">
                            <div class="txt_icon"><?php echo countTotalBorrow(0, date('m'), date('Y'));?></div>
                            <div>rekod</div>
                        </td>
                	    <td width="30%" class="line_r">Keseluruhan Pinjaman Bulanan<br/><span class="txt_color1">pada <?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></span></td>
                	    <td align="center" valign="middle" class="pad1">
                          <div class="txt_icon"><?php echo countTotalReport(0, date('m'), date('Y'));?></div>
                            <div>rekod</div>
                        </td>
                	    <td width="30%" class="line_r">Keseluruhan Aduan Pengguna Bulanan<br/><span class="txt_color1">pada <?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></span></td>
                	    <td align="center" valign="middle" class="pad1">
                       	  <div class="txt_icon"><?php echo countTotalApply(0, date('m'), date('Y'));?></div>
               	      	<div>rekod</div></td>
                	    <td width="30%">Keseluruhan Permohonan Peralatan Bulanan<br/><span class="txt_color1">pada <?php echo date('F Y', mktime(0, 0, 0, date('m'), date('d'), date('Y')));?></span></td>
              	    </tr>
              	  </table>
                </li>
            <?php }; ?>
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
mysql_free_result($rt);
?>
<?php include('../inc/footinc.php');?> 