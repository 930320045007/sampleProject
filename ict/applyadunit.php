<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='69';?>
<?php
$wsql = "";

if(isset($_POST['userapply_date_m']))
{
	$wsql .= " AND userapply_date_m = '" . htmlspecialchars($_POST['userapply_date_m'], ENT_QUOTES) . "'";
	$dm = $_POST['userapply_date_m'];
} else {
	$wsql .= " AND userapply_date_m = '" . date('m') . "'";
	$dm = date('m');
}

if(isset($_POST['userapply_date_y']))
{
	$wsql .= " AND userapply_date_y = '" . htmlspecialchars($_POST['userapply_date_y'], ENT_QUOTES) . "'";
	$dy = $_POST['userapply_date_y'];
} else {
	$wsql .= " AND userapply_date_y = '" . date('Y') . "'";
	$dy = date('Y');
}
?>
<?php

mysql_select_db($database_ictdb, $ictdb);
$query_apply = "SELECT * FROM ict.user_apply WHERE userapply_status = 1 " . $wsql . " ORDER BY userapply_date_y DESC, userapply_date_m DESC, userapply_date_d DESC, userapply_id DESC";
$apply = mysql_query($query_apply, $ictdb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
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
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            	<li class="form_back">
            	  <form id="form1" name="form1" method="post" action="">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label noline">Tarikh</td>
            	        <td width="100%" class="noline">                          
            	          <select name="userapply_date_m" id="userapply_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) $j= "0" . $j; echo $j;?>"><?php echo $j . " - " . date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	          <span class="inputlabel">/</span>
            	          <select name="userapply_date_y" id="userapply_date_y">
                          <?php for($k=2012; $k<=date('Y'); $k++){?>
            	            <option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
            	        <td class="noline"><input name="button4" type="button" class="submitbutton" id="button4" value="Senarai" onClick="MM_goToURL('parent','itemlist.php');return document.MM_returnValue"/></td>
          	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai permohonan bagi bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></div>
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
                <tr>
                  		<th align="center" valign="middle" nowrap="nowrap">Bil</th>
                        <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                        <th width="100%" align="left" valign="middle" nowrap="nowrap">Nama/ Unit</th>
                        <th align="center" valign="middle" nowrap="nowrap">Jumlah Pemohon<br />(kakitangan)</th>
                          <th align="center" valign="middle" nowrap="nowrap">Status</th>
                      </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td align="center" valign="middle"><?php echo $i;?></td>
                            <td align="center" valign="middle" nowrap="nowrap"><?php echo getApplyDateByApplyID($row_apply['userapply_id']);?></td> 
                            <td class="txt_line"><div><strong><a href="applyadmindetail.php?id=<?php echo $row_apply['userapply_id']; ?>"> 
                           <?php echo getFullNameByStafID($row_apply['userapply_by']); ?></a></strong><br /></div> 
                           <div><?php echo getFulldirectoryByUserID($row_apply['userapply_by']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_apply['userapply_by']);?></div></td>
                           <td align="center" valign="middle" nowrap="nowrap"><?php echo countTotalStafByApplyID($row_apply['userapply_id']);?></td>
                           <td align="center" valign="middle"><?php echo iconApplyStatus($row_apply['userapply_id']);?></td> 
                        </tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_apply ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
        </li>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
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
mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 